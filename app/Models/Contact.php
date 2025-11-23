<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    protected $fillable = ['name', 'phone', 'email', 'message','status', 'created_by','updated_by'];

}
