<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'emp_no',
        'name',
        'phone_no',
        'email',
        'designation',
        'department',
        'join_date',
        'salary',
        'address',
        'status'
    ];

}
