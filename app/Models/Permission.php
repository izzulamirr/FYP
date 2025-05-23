<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
protected $primaryKey = 'PermissionID';

protected $fillable = ['Description'];

public function roles()
{
    return $this->belongsToMany(Role::class, 'role_permission', 'PermissionID', 'RoleID');
}

}
