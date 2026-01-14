<?php

namespace Controller;

use Model\User;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class AdminController
{
    public function sysadmins(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'lastname' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Поле :field должно быть уникальным',
            ]);

            if ($validator->fails()) {
                return (new View())->render('admin.sysadmins', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'sysadmins' => User::where('role', 'sysadmin')->orderBy('id', 'desc')->get(),
                ]);
            }

            $data = $request->all();
            $data['role'] = 'sysadmin';

            if (User::create($data)) {
                app()->route->redirect('/admin/sysadmins?success=1');
            }
        }

        return (new View())->render('admin.sysadmins', [
            'success' => $request->get('success'),
            'sysadmins' => User::where('role', 'sysadmin')->orderBy('id', 'desc')->get(),
        ]);
    }
}

