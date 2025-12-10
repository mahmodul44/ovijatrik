<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyReceipt extends Model
{
    use HasFactory;
    protected $table = 'money_receipts';
    public $timestamps = false;
    protected $primaryKey = 'mr_id';
    public $incrementing = false;
    protected $keyType = 'int';

     protected $fillable = [
        'mr_no',
        'receipt_type',
        'fiscal_year',
        'project_id',
        'member_id',
        'donar_name',
        'donar_reference',
        'pay_method_id',
        'account_id',
        'selected_months',
        'payment_date',
        'payment_amount',
        'bank_account_no',
        'mobile_account_no',
        'transaction_no',
        'bank_name',
        'payment_remarks',
        'decline_remarks',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pay_method_id', 'pay_method_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    
    public function createdUser()
    {
     return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
