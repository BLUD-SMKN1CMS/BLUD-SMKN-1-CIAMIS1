<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'role',
        'tefa_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke TEFA
     */
    public function tefa()
    {
        return $this->belongsTo(Tefa::class);
    }

    /**
     * Check if admin is super admin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super-admin';
    }

    /**
     * Check if admin is TEFA admin
     */
    public function isAdminTefa()
    {
        return $this->role === 'admin-tefa';
    }

    /**
     * Scope untuk super admin
     */
    public function scopeSuperAdmin($query)
    {
        return $query->where('role', 'super-admin');
    }

    /**
     * Scope untuk admin TEFA
     */
    public function scopeAdminTefa($query)
    {
        return $query->where('role', 'admin-tefa');
    }

    /**
     * Get formatted role display name
     */
    public function getRoleDisplay()
    {
        return ucwords(str_replace('-', ' ', $this->role ?? 'Administrator'));
    }
}
