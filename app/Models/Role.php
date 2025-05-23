<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
protected $primaryKey = 'RoleID';
protected $fillable = ['user_id', 'name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'RoleID', 'PermissionID');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'RoleID');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}


}
