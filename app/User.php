<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function expenses() {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function hasRole($role) {
        if($this->role()->where('access', $role)->first()) {
            return true;
        }
        return false;
    }

    public function hasAnyRoles($roles) {
        if(is_array($roles)) {
            foreach($roles as $role) {
                if($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function isAdmin() {
        return \Auth::check() && $this->role()->where('access', 'admin')->first();
    }

}
