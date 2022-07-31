<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lyrics extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'lyrics',
        'last_changed_by',
        'last_changed_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
