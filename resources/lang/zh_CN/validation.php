<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'username' => [
            'required' => '用户名不能为空',
            'required_with' => '用户名不能为空',
            'alpha_dash' => '用户名只能包含字母、数字、破折号、下划线',
            'between' => '用户名长度必须在 :min 位和 :max 位之间',
            'unique' => '该用户名已被注册'
        ],
        'email' => [
            'required' => '请输入邮箱',
            'email' => '请输入正确的邮箱地址',
            'unique' => '该邮箱已被注册'
        ],
        'password' => [
            'required' => '密码不能为空',
            'required_without' => '密码不能为空',
            'between' => '用密码长度必须在 :min 位和 :max 位之间',
            'between' => '密码长度必须在 :min 位和 :max 位之间',
            'confirmed' => '两次密码不一致',
        ],
        'avatar' => [
            'image' => '上传的文件必须是图片',
            'max' => '文件大小不能超过 :max KB',
        ],

        'realname' => [
            'regex' => '真实姓名必须是汉字且字数在2和5之间',
        ],
        'title' => [
            'required' => '标题不能为空',
            'max' => '标题长度不能超过 :max 字'
        ],
        'category_id' => [
            'required' => '请选择文章分类',
            'exists' => '不存在该分类'
        ],
        'slug' => [
             'regex' => '缩略名只能是字母或数字'
        ],
        'desc' => [
            'required' => '简介不能为空',
            'min' => '简介不能少于 :min 字'
        ],

        'url' => [
            'required' => '链接不能为空',
            'url' => '请输入正确的链接，带上 http://',
            'repeat' => '这篇文章已经被别人抢先一步提交啦'
        ],
        'name' => [
            'required' => ' 名称不能为空',
            'max' => '名称长度不能超过 :max 字',
            'unique' => '该名称已经存在',
            'regex' => '名称只能用字母'
        ],
        'display_name' => [
            'required' => '展示名不能为空'
        ],
        'issue' => [
            'required' => '期数不能为空',
            'numeric' => '期数只能为数字',
            'unique' => '该期数已经存在'
        ],
        'published_at' => [
            'date' => '发布日期必须是个正确是日期'
        ]


    ],

    'notice' => [
        'database_error' => '数据库操作返回异常！',
        'update_profile_success' => '成功更新资料！',
        'publish_success' => '成功发布新文章！',
        'update_article_success' => '成功更新文章！',
        'delete_article_success' => '成功删除文章！',
        'create_category_success' => '成功创建新分类！',
        'update_category_success' => '成功更新分类！',
        'delete_category_success' => '成功删除分类！',
        'create_issue_success' => '成功创建新期数！',
        'update_issue_success' => '成功更新期数！',
        'delete_issue_success' => '成功删除期数！',
        'create_user_success' => '成功创建新用户！',
        'update_user_success' => '成功更新用户信息！',
        'delete_user_success' => '成功删除用户！',
        'delete_subscribe_success' => '成功删除订阅用户！',
        'create_role_success' => '成功创建新角色！',
        'update_role_success' => '成功更新角色！',
        'delete_role_success' => '成功删除角色！',
        'update_system_success' => '成功更新系统配置！',

    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
