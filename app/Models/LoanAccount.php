<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    use HasFactory;
      protected $table = 'loan_accounts';
    
    // যদি primary key এর নাম id না হয়, তাহলে সেটাও declare করতে হবে
    protected $primaryKey = 'loan_account_id'; 

    // যদি increment না হয় (যদি auto_increment না থাকে)
    public $incrementing = true;
}
