<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpenseCategory extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    protected $table = 'project_expense_categories';
    public $timestamps = false;
    protected $primaryKey = 'project_exp_cat_id';

}
