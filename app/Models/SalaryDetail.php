<?php

namespace App\Models;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'salary_id', 'employee_id','account_id', 'salary_amount'
    ];
     protected $primaryKey = 'salary_details_id';

public function salary()
{
    return $this->belongsTo(Salary::class, 'salary_id');
}

public function employee() {
    return $this->belongsTo(Employee::class, 'id');
}

}
