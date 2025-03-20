<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Models\Admin\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Order;
use App\Models\Admin\Product;
use App\Models\Admin\Slider;

class DashboardController extends Controller
{

    /**
     * Middleware
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        \config_set('theme.cdata', [
            'title' => 'Dashboard',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => false
                ],
            ],
            'add' => \route('admin.role.create')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $analytic = [];


        if (\can('user_status_management')) $analytic['user']['status'] = UserStatus::cacheData()->count();
        if (\can('user_role_management')) $analytic['user']['role'] = Role::cacheData()->count();
        if (\can('user_permission_management')) $analytic['user']['permission'] = Permission::cacheData()->count();
        if (\can('user_browse')) {
            $analytic['user']['status_data'] = UserStatus::cacheData();
            $analytic['user']['user'] = User::cacheData()->count();
        }

        if (\can('products')) $analytic['products'] = Product::select('id')->count();
        if (\can('categories')) $analytic['categories'] = Category::select('id')->count();
        if (\can('sliders')) $analytic['sliders'] = Slider::select('id')->count();
        if (\can('orders')) $analytic['orders'] = Order::select('id')->count();




        // seo
        $this->seo()->setTitle(config('theme.cdata.title'));
        $this->seo()->setDescription(\config('theme.cdata.description'));

        return view('pages.admin.dashboard', \compact('analytic'));
    }

    /**
     *
     *
     * return Redirect Url
     *
     *
     */
    public function redirect()
    {
        return \redirect()->route('admin.dashboard');
    }
}
