<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

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
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'business_id',
        'office_id',
        'employee_business_id',
        'schedule_id',
        'parent_id',
        'designation',
        'name',
        'email',
        'password',
        'user_role',
        'otp',
        'phone',
        'mac_address',
        'device_name',
        'profile_photo_path',
        'rtl',
        'language',
        'type',
        'status',
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

    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function subCategory(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id')->orderBy('name');
    }

    public function child(): HasMany
    {
        // This relationship will only return one level of child items
        return $this->hasMany(User::class,'parent_id','id');
    }

    public function multipleChild(): HasMany
    {
        // This is method where we implement recursive relationship
        return $this->child()->with('multipleChild');
    }

    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function office(): HasOne
    {
        return $this->hasOne(Office::class, 'id','office_id');
    }

    public function punchTable(): HasMany
    {
        return $this->hasMany(PunchTable::class);
    }

    public function userSchedule(): HasOne
    {
        return $this->hasOne(UserHasSchedule::class);
    }

    public function userOffice(): HasOne
    {
        return $this->hasOne(UserOffice::class);
    }

}
