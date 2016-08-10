<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UserUpdate;
use App\Models\User;
use App\Repositories\Dashboard\AuthorityRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\MeRequest;
use App\Http\Requests\Dashboard\AvatarRequest;
use App\Http\Controllers\Controller;

class AdminMeController extends Controller
{
    protected $authorityRepository;

    /**
     * AdminMeController constructor.
     * @param AuthorityRepository $authorityRepository
     */
    public function __construct(AuthorityRepository $authorityRepository)
    {
        $this->authorityRepository = $authorityRepository;
    }

    public function me()
    {
        return view('dashboard.me.index');
    }

    /**
     * 修改个人资料
     *
     * @param MeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function meProfile(MeRequest $request)
    {
        $user = $this->authorityRepository->user();
        if ($request->has('password')) {
            $attributes = $request->all();
        } else {
            $attributes = $request->except('password');
        }
        $this->authorityRepository->update($user, $attributes);
        event(new UserUpdate($user));
        return redirect(route('dashboard.me'))->with('message', trans('validation.notice.update_profile_success'));
    }

    /**
     * 头像上传
     *
     * 这里不直接注入自定义的 Request 类, 因为直接注入的话如果上传的文件不符合规则, 直接被拦截了, 进不到这个方法, 实现不了 AJAX 提交
     * 因此在这方法里面进行验证, 再把错误用 json 返回到页面上
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarUpload(Request $request)
    {
        $file = $request->file('avatar');
        $avatarRequest = new AvatarRequest();
        $validator = \Validator::make($request->only('avatar'), $avatarRequest->rules());
        if ($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->messages()
            ]);
        }
        $user = $this->authorityRepository->user();
        $destination = 'avatar/' . $user->username . '/';   // 文件最终存放目录

        file_exists($destination) ? '' : mkdir($destination, 0777);
        $clientName = $file->getClientOriginalName();   // 原文件名
        $extension = $file->getClientOriginalExtension();   // 文件扩展名
        $newName = md5(date('ymd') . $clientName) . '.' . $extension;
        $avatarPath = '/' . $destination . $newName;
        $oldAvatar = substr($user->avatar, 1); // 旧头像路径, 把路径最前面的 / 删掉
        if ($file->move($destination, $newName)) {
            $this->authorityRepository->update($user, ['avatar' => $avatarPath]);
            file_exists($oldAvatar) ? unlink($oldAvatar) : '';
            return \Response::json(
                [
                    'success' => true,
                    'avatar' => $avatarPath,
                ]
            );
        }
    }
}
