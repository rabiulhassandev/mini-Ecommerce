<?php

namespace App\Models;

use App\Traits\WithCache;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Admin\UserStatus;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Notifications\OTPNotification;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Notifications\OTPNotificationViaEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use WithCache;
    use HasRoles;

    protected static $cacheKey = '_users_';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'user_status_id',

        'bio',
        'address',
        'birth',

        'facebook',
        'twitter',
        'whatsapp',

        'profile_photo_path'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     *
     * User Statuses
     *
     */
    const STATUES = [
        'Active' => 1,
        'Suspend' => 0
    ];


    public function status()
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }

    /**
     * Send the user OTP for 2FA.
     *
     * @return array
     */
    public function sendOTP()
    {
        if ($this->otp_attempt < \config('otp.attempt')) {
            $otp = generateOTP(\config('otp.length'));

            $this->otp            = $otp;
            $this->otp_attempt += 1;
            $this->otp_created_at = Carbon::now();
            $this->save();

            $this->notify(new OTPNotificationViaEmail($this));

            return [
                'message'     => 'New OTP Generated.',
                'data'        => $this,
                'status'      => true,
                'status_code' => 200,
            ];
        }

        if (Carbon::create($this->otp_created_at)->addHour(\config('otp.bannedHour')) < Carbon::now()) {
            $this->reset_otp();

            return $this->sendOTP();
        }

        return [
            'data'        => $this,
            'message'     => 'You Limit Your OTP Attempt. You can Try after ' . config('otp.length') . ' Hours later..',
            'status'      => false,
            'status_code' => 403,

        ];
    }

    /**
     * Reset the user OTP.
     *
     * @return array
     */
    public function reset_otp()
    {
        $this->otp_attempt    = 0;
        $this->otp            = \null;
        $this->otp_created_at = \null;
        $this->save();

        return [
            'data'    => $this,
            'message' => 'OTP Session Rested.',
            'status'  => true,
        ];
    }

    /**
     * Check the user OTP.
     *
     * @param  string  $otp
     * @return array
     */
    public function verifyOTP($otp)
    {
        // check the expire time of OTP
        $expireTime = Carbon::create($this->otp_created_at)->addMinute(\config('otp.session'));
        if ($expireTime > Carbon::now()) {
            // Check the OTP
            if ($this->otp == $otp) {
                // generate token
                $token = Str::random(config('otp.tokenLength'));
                // check if token already exists
                $password_reset = DB::table('password_resets')->where('email', $this->email)->first();
                if ($password_reset) {
                    $password_reset = DB::table('password_resets')->update([
                        'email'      => $this->email,
                        'token'      => $token,
                        'created_at' => Carbon::now(),
                    ]);
                }
                else {
                    $password_reset = DB::table('password_resets')->insert([
                        'email'      => $this->email,
                        'token'      => $token,
                        'created_at' => Carbon::now(),
                    ]);
                }
                // reset otp attempt
                $this->reset_otp();

                // return response
                return [
                    'data'        => $this,
                    'message'     => 'OTP Match.',
                    'status'      => true,
                    'token'       => $token,
                    'status_code' => 200,
                ];
            }
            // return response
            return [
                'data'        => $this,
                'message'     => 'OTP Dose Not Match.',
                'status'      => false,
                'status_code' => 403,
            ];
        }
        // return response
        return [
            'data'        => $this,
            'message'     => 'OTP Expired',
            'status'      => false,
            'status_code' => 403,
        ];
    }

    /**
     * Check Password reset token.
     *
     * @param  string  $token
     * @return array
     */
    public function checkPasswordResetToken($token)
    {
        $password_reset = DB::table('password_resets')->where('token', $token)->first();

        if ($password_reset) {
            // $expireTime = Carbon::create($password_reset->created_at)->addMinute(\config('otp.session'));
            $expireTime = Carbon::parse($password_reset->created_at)->addMinutes(config('otp.session'));
            if ($expireTime > Carbon::now()) {
                // delete the token
                DB::table('password_resets')->where('token', $token)->delete();
                // return response
                return [
                    'data'        => $password_reset,
                    'message'     => 'Token Match.',
                    'status'      => true,
                    'status_code' => 200,
                ];
            }

            return [
                'data'        => $password_reset,
                'message'     => 'Token Expired',
                'status'      => false,
                'status_code' => 403,
            ];
        }

        return [
            'data'        => $password_reset,
            'message'     => 'Token Dose Not Match.',
            'status'      => false,
            'status_code' => 403,
        ];
    }



    /**
     * Summary of apiAccessTokens
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apiAccessTokens()
    {
        return $this->hasMany(ApiAccessToken::class, 'user_id');
    }
}
