<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccBalanceTransfer extends Model
{
    use HasFactory;

    protected $table = 'acc_balance_transfers';
    protected $primaryKey = 'acc_transfer_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'acc_transfer_no',
        'fiscal_year',
        'from_account',
        'to_account',
        'transfer_amount',
        'acc_transfer_date',
        'transfer_remarks',
        'transfer_status',
        'decline_remarks'
    ];

    public function fromAccount()
    {
        return $this->belongsTo(Account::class, 'from_account','account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(Account::class, 'to_account','account_id');
    }
}
