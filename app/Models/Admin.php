<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'username', 'email', 'password', 'enabled'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


}
