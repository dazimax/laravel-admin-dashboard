<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Allow access to role
     * 
     * @return void
     * 
     * @access public
     */
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    /**
     * Get userType
     * 
     * @return string
     * 
     * @access public
     */
    public function userType()
    {
        return $this->user_type;
    }

    /**
     * Check user type is Staff
     * 
     * @return bool true | false
     * 
     * @access public
     */
    public function isStaff()
    {
        if($this->user_type == 'staff') {
            return true;
        }else{
            false;
        }
    }

    /**
     * Check user is Super Admin
     * 
     * @return bool true | false
     * 
     * @access public
     */
    public function isSuperAdmin()
    {
        if($this->role()->first()->name == 'super_admin') {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get plans
     * 
     * @return array
     * 
     * @access public
     */
    public function plans()
    {
        return $this->hasMany('App\Plan', 'user_id', 'id');
    }
}
