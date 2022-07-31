<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;

    protected $fillable = ['otp', 'expires_at'];

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id'];

}
