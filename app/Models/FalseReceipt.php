<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FalseReceipt extends Model
{
    use HasFactory;
    protected $table = 'false_receipts';
    public $timestamps = false;
    protected $primaryKey = 'fls_receipt_id';
    public $incrementing = false;
    protected $keyType = 'int';

     protected $fillable = [
        'fls_receipt_no',
        'fiscal_year',
        'project_id',
        'fls_receipt_date',
        'donar_name',
        'pay_method_id',
        'remarks',
        'fls_receipt_amount',
        'posting_type'
    ];

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pay_method_id', 'pay_method_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function createdUser()
    {
     return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
