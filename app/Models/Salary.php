<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'salary_id';

     protected $fillable = [
        'salary_no', 'salary_year', 'fiscal_year', 'salary_month','account_id','salary_date', 'total_salary','status','approval_by','approval_at','created_at','created_by','updated_by','updated_at','operation_ip'
        
    ];

    public function account() {
       return $this->belongsTo(Account::class, 'account_id');
    }

    public function salaryDetails() {
     return $this->hasMany(SalaryDetail::class, 'salary_id');
    }

}