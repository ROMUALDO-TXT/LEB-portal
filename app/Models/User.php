<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use app\Notifications\ResetPassword;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cnpj',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function permissions()
    {
        $role = Role::where("name", $this->role)->first();
        if (isset($role)) {
            return $role->permissions;
        }
        return collect([]);
    }

    public function hasPermission($permission)
    {
        if ($this->role == "admin") {
            return true;
        }
        $permission = $this->permissions()->where("name", $permission)->first();
        return isset($permission);
    }

    public function canAccess($permission, $action)
    {
        if ($this->role == "admin") {
            return true;
        }

        $permissions = $this->permissions();
        $permissionFilter = $permissions->filter(function ($p) use ($permission) {
            return $p->name == $permission;
        })->first();

        if (isset($permissionFilter) && isset($permissionFilter->features)) {
            $features = $permissionFilter->features;
            return array_search($action, $features) !== false || array_search('*', $features) !== false;
        }
        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
