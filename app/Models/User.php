<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable; // Added Notifiable for email verification

    protected $fillable = ['name', 'email', 'password', 'jabatan', 'supervisor_id', 'role']; 

    /**
     * A user has one employee profile
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id'); 
    }

    /**
     * A user (as a supervisor) has many employees under them
     */
    public function supervisedEmployees()
    {
        return $this->hasMany(Employee::class, 'supervisor_id', 'id'); 
    }

    /**
     * A user can have a supervisor (atasan)
     */
    public function atasan()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'id'); 
    }

    /**
     * Role-based access checks
     */
    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
