<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    protected $table = 'abouts';
    protected $fillable = ['about', 'about_img', 'message', 'message_img', 'mission', 'mission_img', 'vision', 'vision_img', 'history', 'history_img', 'why_choose', 'why_choose_img', 'why_best', 'why_best_img', 'email', 'email_2', 'mobile', 'mobile_2', 'address', 'address_2', 'logo', 'facebook', 'twitter', 'instagram', 'linkedin', 'satisfactions', 'projects', 'visitors', 'happy_clients' ];

}
