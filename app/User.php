<?php

namespace App;

use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];


    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'password',
        'role',
        'address',
        'city',
        'state',
        'zip',
        'status_id',
        'phonenumber',
        'email',
        'passwordexp',
        'updated_at',
        'created_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            self::created(function (User $user) {
                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }
            });
        }

        public function contract_s()
        {
            return $this->hasMany(Contract::class, 'created_by_id', 'id');
        }

        public function Servicecosts()
        {
            return $this->hasMany(Servicecost::class, 'created_by_id', 'id');
        }

        public function service_s()
        {
            return $this->hasMany(Service::class, 'created_by_id', 'id');
        }

        public function sites()
        {
            return $this->hasMany(Site::class, 'created_by_id', 'id');
        }

        public function jobs()
        {
            return $this->hasMany(Job::class, 'created_by_id', 'id');
        }

        public function status()
        {
              return $this->belongsTo(Status::class, 'status_id');
        }

        public function getEmailVerifiedAtAttribute($value)
        {
            return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
        }

        public function setEmailVerifiedAtAttribute($value)
        {
            $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
        }



        public function setPasswordAttribute($input)
        {
            if ($input) {
                $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
            }
        }

        public function sendPasswordResetNotification($token)
        {
            $this->notify(new ResetPassword($token));
        }

        public function roles()
        {
            return $this->belongsToMany(Role::class);
        }
}
