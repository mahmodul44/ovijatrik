<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    public $timestamps = false;
    protected $primaryKey = 'expense_id';
    protected $fillable = [
        'expense_no',
        'expense_cat_id',
        'fiscal_year',
        'project_id',
        'expense_date',
        'expense_remarks',
        'expense_amount',
        'pay_method_id',
        'bank_account_no',
        'mobile_account_no',
        'bank_name',
        'transaction_no',
        'status',
        'decline_remarks'
    ];

    public function expcategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_cat_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

}
