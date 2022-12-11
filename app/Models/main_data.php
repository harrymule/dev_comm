<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class main_data extends Model
{
    use HasFactory;

    protected $table = 'main_data';
    protected $fillable = [
        'name', 'description' , 'image', 'type'
    ];
}
