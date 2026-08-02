<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Laporan;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory, Notifiable,SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'photo',
        'jabatan',
        'platon_id',
        'regu_id',
    ];

 
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function laporans()
{
    return $this->hasMany(Laporan::class);
}
public function platon()
{
    return $this->belongsTo(Platon::class);
}

public function regu()
{
    return $this->belongsTo(Regu::class);
}

}
