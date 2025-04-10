<?php

use Illuminate\Support\Facades\Storage;




if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return App\Facades\Setting::get($key, $default);
    }
}


if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        $menu = new App\Models\Menu\Menu;
        return $menu->display($menuName, $type, $options);
    }
}

if (!function_exists('get_file_name')) {
    function get_file_name($name)
    {
        preg_match('/(_)([0-9])+$/', $name, $matches);
        if (count($matches) == 3) {
            return Illuminate\Support\Str::replaceLast($matches[0], '', $name) . '_' . (intval($matches[2]) + 1);
        } else {
            return $name . '_1';
        }
    }
}


if (!function_exists('storage_asset')) {
    function storage_asset($file = null, $driver = null)
    {
        $getDriver = $driver ?? Illuminate\Support\Facades\Config::get('filesystems.default');
        $path = Illuminate\Support\Facades\Config::get('filesystems.disks.' . $getDriver)['url'];
        if ($file) {
            return $path . '/' . $file;
        } else {
            return $path;
        }
    }
}

if (!function_exists('admin_asset')) {
    function admin_asset($file = null)
    {
        $path = 'admin-assets/' . $file;
        return app('url')->asset($path);
    }
}


if (!function_exists('front_asset')) {
    function front_asset($file = null)
    {
        $path = 'front-assets/' . $file;
        return app('url')->asset($path);
    }
}

if (!function_exists('upload_asset')) {

    function upload_asset($path)
    {
        return asset('storage/' . $path);
    }
}

if (!function_exists('can')) {

    function can($permission)
    {
        return auth()->user()->can($permission);
    }
}

if (!function_exists('user_role')) {
    function user_role($user = null)
    {
        if ($user != null) {
            return $user->roles()->first();
        }
        return auth()->user()->roles()->first();
    }
}

if (!function_exists('permission_check')) {

    function permission_check($permissions, $permission_id)
    {
        foreach ($permissions as $permission) {
            if ($permission->id == $permission_id) {
                return true;
            }
        }
        return false;
    }
}

function permission_key_to_name($data)
{
    return ucwords(implode(" ", explode("_", $data)));
}

if (! function_exists('upload_image')) {
    function upload_image($request, $fileName, $folderName, $oldImage = false)
    {
        if ($request->has($fileName)) {
            $request->validate([
                $fileName => ['required', 'image'],
            ]);
            if ($oldImage) {
                Storage::delete($oldImage);
            }

            return  $request->$fileName->store($folderName);
        }

        return $oldImage;
    }
}


if (!function_exists('store_file')) {

    function store_file($file, $path = 'image')
    {
        return Illuminate\Support\Facades\Storage::putFile($path, $file);
    }
}

if (!function_exists('delete_file')) {

    function delete_file($path)
    {
        return Illuminate\Support\Facades\Storage::delete($path);
    }
}


if (!function_exists('selected')) {

    function selected($valueOne = null, $valueTwo = null)
    {
        if ($valueOne == $valueTwo) {
            return 'selected';
        }
        return false;
    }
}

if (!function_exists('permission_check')) {

    function permission_check($permissions, $permission_id)
    {
        foreach ($permissions as $permission) {
            if ($permission->id == $permission_id) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('can')) {
    function can($permission, $user = null)
    {
        if ($user) {
            return $user->can($permission);
        }
        return Illuminate\Support\Facades\Auth::user()->can($permission);
    }
}
if (!function_exists('get_user_role')) {
    function get_user_role($user = null, $key = null)
    {
        if ($user != null) {
            $role = $user->roles()->first();
        } else {
            $role = auth()->user()->roles()->first();
        }
        if ($role) return $role;
        return $role = App\Models\Admin\Role::make();
    }
}


if (!function_exists('deleteFile')) {

    function deleteFile($path)
    {
        return Illuminate\Support\Facades\Storage::delete($path);
    }
}
if (!function_exists('getGroupData')) {

    function getGroupData($data)
    {
        $groupData = [];
        foreach ($data as $d) {
            $groupData[$d->group][] = $d;
        }
        return $groupData;
    }
}

if (!function_exists('back_url')) {

    function back_url()
    {
        return  url()->previous();
    }
}

if (!function_exists('config_set')) {

    function config_set($name, $data): void
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                Illuminate\Support\Facades\Config::set($name . '.' . $key, $value);
            }
        } else {
            Illuminate\Support\Facades\Config::set($name, $data);
        }
    }
}

if (!function_exists('generateOTP')) {
    function generateOTP($digits = 4)
    {
        $i = 0;
        $pin = null;
        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
}

if (! function_exists('image_url')) {
    function image_url($path, $default_image = null)
    {
        if ($path) {
            return storage_asset($path);
        }

        return $default_image;
    }
}


if (! function_exists('en2bn')) {
    function en2bn($text)
    {
        $dateBn = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $dateEn = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        $monthBn = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নবেম্বর', 'ডিসেম্বর'];
        $monthEn = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $text = str_replace($dateEn, $dateBn, $text);

        return str_replace($monthEn, $monthBn, $text);
    }
}

if (! function_exists('bn2en')) {
    function bn2en($text)
    {
        $dateBn = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $dateEn = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        $monthBn = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নবেম্বর', 'ডিসেম্বর'];
        $monthEn = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $text = str_replace($dateBn, $dateEn, $text);

        return str_replace($monthBn, $monthEn, $text);
    }
}

if (! function_exists('bnDate')) {
    function bnDate($get_date)
    {
        // return en2bn($get_date->format('d M Y'));
        return en2bn(date('d M Y', strtotime($get_date)));
    }
}

if (! function_exists('bnFullDate')) {
    function bnFullDate($get_date)
    {
        return en2bn($get_date->format('d M Y')) . ', ' . en2bn($get_date->format('H')) . 'টা ' . en2bn($get_date->format('i')) . 'মি';
    }
}
