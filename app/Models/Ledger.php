<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    protected $table = 'debit_credit_ledger';
    public $timestamps = false;
    protected $primaryKey = 'ledger_id';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
