<?php

namespace App\Http\Controllers\Backend;

use App\Events\UserUpdate;
use Illuminate\Http\Request;

use App\Http\Requests\Backend;
use App\Http\Controllers\Controller;

class AdminMeController extends Controller
{
    public function me()
    {
        return view('backend.me.index');
    }

    public function meProfile(Backend\MeRequest $request)
    {
        $user = \Auth::user();
        $user->email = e($request->get('email'));
        $user->realname = e($request->get('realname'));
        if ($request->has('password')) {
            $user->password = $request->get('password');
        }
        $user->save();
        event(new UserUpdate($user));
        return redirect(route('backend.me'))->with('message', trans('validation.notice.update_profile_success'));
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
        $avatarRequest = new Backend\AvatarRequest();
        $validator = \Validator::make($request->only('avatar'), $avatarRequest->rules());
        if ($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        $destination = 'avatar/' . \Auth::user()->username . '/';   // 文件最终存放目录

        file_exists($destination) ? '' : mkdir($destination, 0777);
        $clientName = $file->getClientOriginalName();   // 原文件名
        $extension = $file->getClientOriginalExtension();   // 文件扩展名
        $newName = md5(date('ymd') . $clientName) . '.' . $extension;
        $avatarPath = '/' . $destination . $newName;
        $oldAvatar = substr(\Auth::user()->avatar, 1); // 旧头像路径, 把路径最前面的 / 删掉
        if ($file->move($destination, $newName)) {
            \Auth::user()->update(['avatar' => $avatarPath]);
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
