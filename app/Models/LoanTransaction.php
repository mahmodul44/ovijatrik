<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanTransaction extends Model
{
    use HasFactory;
    protected $table = 'loan_transactions';
    public $timestamps = false;
    protected $primaryKey = 'loan_transactions_id';


    public function loanProject()
    {
        return $this->belongsTo(Project::class, 'loan_project','project_id');
    }

    public function loanAccount()
    {
        return $this->belongsTo(LoanAccount::class, 'loan_account_id','loan_account_id');
    }
}
