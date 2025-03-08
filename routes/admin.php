<?php

namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\ReportIssueController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\AttributesSetController;
use App\Http\Middleware\UserStatusRestrictionMiddleware;
use App\Http\Controllers\Admin\AttributesValueController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\Setting\SettingController;

/**
 *
 *
 * ----------------------------------------------------------
 * Admin Subdomain Group
 * ----------------------------------------------------------
 *
 */
    /**
     *
     *
     * ----------------------------------------------------------
     * Lock Management
     * ----------------------------------------------------------
     *
     */
    Route::prefix('lock-screen')->group(function () {
        Route::get('/', [LockScreenController::class, 'lock'])->name('admin.lock-screen');
        Route::get('/security-checkpoint', [LockScreenController::class, 'unlock'])->name('admin.lock-screen.unlock.view');
        Route::post('/security-checkpoint', [LockScreenController::class, 'unlockScreen'])->name('admin.lock-screen.unlock');
    });

    // Forgot password
    Route::prefix('forget-password')->group(function () {
        Route::get('/', [AuthController::class, 'forgetPassword'])->name('forget.password'); // form view
        Route::post('/', [AuthController::class, 'forgetPasswordRequest'])->name('forget.password.request'); // validate phone no and send otp
        Route::get('/verify', [AuthController::class, 'verify'])->name('forget.otp.verify'); // verify page show
        Route::post('/verify', [AuthController::class, 'verifyRequest'])->name('forget.otp.verify.request'); // check otp valid or not (if valid redirect password change page)
        Route::get('/change', [AuthController::class, 'passwordChange'])->name('forget.password.change'); // password change page show
        Route::post('/change', [AuthController::class, 'passwordChangeRequest'])->name('forget.password.change.request'); // password update query
    });



    /**
     *
     *
     * ----------------------------------------------------------
     * Auth Middleware Group
     * ----------------------------------------------------------
     *
     */

     Route::prefix('admin')->middleware(['auth', 'verified', UserStatusRestrictionMiddleware::class])
     ->group(function () {
        Route::get('/', [DashboardController::class, 'redirect'])->name('admin.redirect');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


        /**
         *
         *
         * ----------------------------------------------------------
         * User Management
         * ----------------------------------------------------------
         *
         */


        Route::prefix('user')->group(function () {
            /**
             *
             *
             * ----------------------------------------------------------
             * User Status Management
             * ----------------------------------------------------------
             *
             */
            Route::prefix('status')->middleware(['permission:user_status_management'])->group(function () {
                Route::get('/', [UserStatusController::class, 'index'])->name('admin.user-status.index');
                Route::get('/create', [UserStatusController::class, 'create'])->name('admin.user-status.create');
                Route::post('/create', [UserStatusController::class, 'store'])->name('admin.user-status.store');
                Route::get('/{userStatus}/edit', [UserStatusController::class, 'edit'])->name('admin.user-status.edit');
                Route::put('/{userStatus}/edit', [UserStatusController::class, 'update'])->name('admin.user-status.update');
                Route::delete('/{userStatus}/delete', [UserStatusController::class, 'destroy'])->name('admin.user-status.delete');
            }); //end role route group
            /**
             *
             *
             * ----------------------------------------------------------
             * Role Management
             * ----------------------------------------------------------
             *
             */
            Route::prefix('role')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
                Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
                Route::post('/create', [RoleController::class, 'store'])->name('admin.role.store');
                Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
                Route::put('/{role}/edit', [RoleController::class, 'update'])->name('admin.role.update');
                Route::delete('/{role}/delete', [RoleController::class, 'destroy'])->name('admin.role.delete');
            }); //end role route group

            /**
             *
             *
             * ----------------------------------------------------------
             * Permission Management
             * ----------------------------------------------------------
             *
             */
            Route::prefix('/permission')->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('admin.permission.index');
                Route::get('/create', [PermissionController::class, 'create'])->name('admin.permission.create');
                Route::post('/create', [PermissionController::class, 'store'])->name('admin.permission.store');
                Route::get('/{permission}', [UserController::class, 'show'])->name('admin.permission.show');
                Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permission.edit');
                Route::put('/{permission}/edit', [PermissionController::class, 'update'])->name('admin.permission.update');
                Route::delete('/{permission}/delete', [PermissionController::class, 'destroy'])->name('admin.permission.delete');
            }); //end permission route group

            /**
             *
             *
             * ----------------------------------------------------------
             * Profile Management
             * ----------------------------------------------------------
             *
             */
            Route::prefix('profile')->group(function () {
                Route::get('/info', [UserController::class, 'profile'])->name('admin.user.profile');
                Route::get('/edit', [UserController::class, 'profileEdit'])->name('admin.user.profile.edit');
                Route::put('/update', [UserController::class, 'profileUpdate'])->name('admin.user.profile.update');
                Route::get('/setting', [UserController::class, 'setting'])->name('admin.user.profile.settings');
                Route::post('/setting', [UserController::class, 'update_setting'])->name('admin.user.profile.settings.update');
            });



            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
            Route::post('/create', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/{user}', [UserController::class, 'show'])->name('admin.user.show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/{user}/edit', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('admin.user.delete');
            Route::post('{user}/status-update', [UserController::class, 'statusUpdate'])->name('user.statusUpdate');
        }); //end user route group

        /**
         *
         *
         * ----------------------------------------------------------
         * page-builder Management
         * ----------------------------------------------------------
         *
         */
        Route::prefix('/page-builder')->group(function () {
            Route::get('/', [PageBuilderController::class, 'index'])->name('admin.page-builder.index');
            Route::get('/create', [PageBuilderController::class, 'create'])->name('admin.page-builder.create');
            Route::post('/create', [PageBuilderController::class, 'store'])->name('admin.page-builder.store');
            Route::get('/{pageBuilder}/edit', [PageBuilderController::class, 'edit'])->name('admin.page-builder.edit');
            Route::put('/{pageBuilder}/edit', [PageBuilderController::class, 'update'])->name('admin.page-builder.update');
            Route::delete('/{pageBuilder}/delete', [PageBuilderController::class, 'destroy'])->name('admin.page-builder.delete');
        }); //end  page-builder route group

        /**
         *
         *
         * ----------------------------------------------------------
         * Report Issue Management
         * ----------------------------------------------------------
         *
         */
        Route::prefix('/report-issue')->group(function () {
            Route::get('/', [ReportIssueController::class, 'index'])->name('admin.report-issue.index');
            Route::get('/create', [ReportIssueController::class, 'create'])->name('admin.report-issue.create');
            Route::post('/create', [ReportIssueController::class, 'store'])->name('admin.report-issue.store');
            Route::get('/{reportIssue}', [ReportIssueController::class, 'show'])->name('admin.report-issue.show');
            Route::get('/{reportIssue}/edit', [ReportIssueController::class, 'edit'])->name('admin.report-issue.edit');
            Route::put('/{reportIssue}/edit', [ReportIssueController::class, 'update'])->name('admin.report-issue.update');
            Route::delete('/{reportIssue}/delete', [ReportIssueController::class, 'destroy'])->name('admin.report-issue.delete');
        });

        /**
         *
         *
         * ----------------------------------------------------------
         * Settings Management
         * ----------------------------------------------------------
         *
         */
        Route::prefix('settings')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('admin.settings.index');
            Route::get('/{setting}/move-up', [SettingController::class, 'move_up'])->name('admin.settings.moveUp');
            Route::get('/{setting}/move-down', [SettingController::class, 'move_down'])->name('admin.settings.moveDown');
            Route::post('/', [SettingController::class, 'store'])->name('admin.settings.store');
            Route::put('/', [SettingController::class, 'update'])->name('admin.settings.update');
            Route::delete('/{setting}/delete', [SettingController::class, 'destroy'])->name('admin.settings.delete');
            Route::get('/{setting}/unset-value', [SettingController::class, 'unsetValue'])->name('admin.settings.unsetValue');
        }); //end settings group


        /**
         * ----------------------------------------------------------
         * colors Management
         * ----------------------------------------------------------
         */
        Route::prefix('colors')->group(function () {
            Route::get('/', [ColorController::class, 'index'])->name('admin.colors.index');
            Route::post('/create', [ColorController::class, 'store'])->name('admin.colors.store');
            Route::get('/{color}', [ColorController::class, 'show'])->name('admin.colors.show');
            Route::get('/{color}/edit', [ColorController::class, 'edit'])->name('admin.colors.edit');
            Route::put('/{color}/edit', [ColorController::class, 'update'])->name('admin.colors.update');
            Route::delete('/{color}/delete', [ColorController::class, 'destroy'])->name('admin.colors.delete');
        }); //end colors group

        /**
         * ----------------------------------------------------------
         * attributes sets Management
         * ----------------------------------------------------------
         */
        Route::prefix('attributes-sets')->group(function () {
            Route::get('/', [AttributesSetController::class, 'index'])->name('admin.attributes-sets.index');
            Route::post('/create', [AttributesSetController::class, 'store'])->name('admin.attributes-sets.store');
            Route::get('/{attributesSet}', [AttributesSetController::class, 'show'])->name('admin.attributes-sets.show');
            Route::get('/{attributesSet}/edit', [AttributesSetController::class, 'edit'])->name('admin.attributes-sets.edit');
            Route::put('/{attributesSet}/edit', [AttributesSetController::class, 'update'])->name('admin.attributes-sets.update');
            Route::delete('/{attributesSet}/delete', [AttributesSetController::class, 'destroy'])->name('admin.attributes-sets.delete');
        }); //end attributes sets group

        /**
         * ----------------------------------------------------------
         * attributes values Management
         * ----------------------------------------------------------
         */
        Route::prefix('attributes-values')->group(function () {
            Route::get('/', [AttributesValueController::class, 'index'])->name('admin.attributes-values.index');
            Route::post('/create', [AttributesValueController::class, 'store'])->name('admin.attributes-values.store');
            Route::get('/{attributesValue}', [AttributesValueController::class, 'show'])->name('admin.attributes-values.show');
            Route::get('/{attributesValue}/edit', [AttributesValueController::class, 'edit'])->name('admin.attributes-values.edit');
            Route::put('/{attributesValue}/edit', [AttributesValueController::class, 'update'])->name('admin.attributes-values.update');
            Route::delete('/{attributesValue}/delete', [AttributesValueController::class, 'destroy'])->name('admin.attributes-values.delete');
        }); //end attributes values group

        /**
         * ----------------------------------------------------------
         * categories Management
         * ----------------------------------------------------------
         */
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
            Route::post('/create', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::put('/{category}/edit', [CategoryController::class, 'update'])->name('admin.categories.update');
            Route::delete('/{category}/delete', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
        }); //end categories group

        /**
         * ----------------------------------------------------------
         * products Management
         * ----------------------------------------------------------
         */
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
            Route::post('/create', [ProductController::class, 'store'])->name('admin.products.store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('admin.products.show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
            Route::put('/{product}/update', [ProductController::class, 'update'])->name('admin.products.update');
            Route::post('/{product}/product-image-store', [ProductController::class, 'productImageStore'])->name('admin.products.product-image-store');
            Route::get('/{productImage}/product-image-delete', [ProductController::class, 'productImageDelete'])->name('admin.products.product-image-delete');
            Route::delete('/{product}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');
        }); //end products group

        /**
         * ----------------------------------------------------------
         * Orders Management
         * ----------------------------------------------------------
         */
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
            Route::get('/{order}/details', [OrderController::class, 'orderDetails'])->name('admin.orders.details');
            Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');
            Route::put('/{order}/payment-confirmed', [OrderController::class, 'paymentConfirmed'])->name('admin.orders.payment-confirmed');
            Route::put('/{order}/status-update', [OrderController::class, 'statusUpdate'])->name('admin.orders.status-update');
        }); //end orders group


        /**
         * ----------------------------------------------------------
         * sliders Management
         * ----------------------------------------------------------
         */
        Route::prefix('sliders')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('admin.sliders.index');
            Route::post('/create', [SliderController::class, 'store'])->name('admin.sliders.store');
            Route::get('/{slider}', [SliderController::class, 'show'])->name('admin.sliders.show');
            Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('admin.sliders.edit');
            Route::put('/{slider}/edit', [SliderController::class, 'update'])->name('admin.sliders.update');
            Route::delete('/{slider}/delete', [SliderController::class, 'destroy'])->name('admin.sliders.delete');
        }); //end sliders group

    }); //end auth route group
