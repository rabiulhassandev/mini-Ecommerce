<?php

namespace App\Traits\User;

use Illuminate\Support\Facades\Session;





trait GeneralInfo
{

    private function general_info_update($user, $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'unique:users,username,'.$user->id.',id'],
        ]);

        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image',
            ]);

            $request['profile_photo_path'] = $request->avatar->store('users');
            \delete_file($user->profile_photo_path);
        }
        unset($request['password']);
        unset($request['account_status']);
        // update user data
        $user->update($request->all());
        // forget cache
        $user->forgetCache();
        // flash message
        Session::flash('success', 'Successfully Updated user account.');

        return \true;
    }
}
