<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $table = 'transfers';
    public $timestamps = false;
    protected $primaryKey = 'transfer_id';
    protected $fillable = [
        'transfer_no',
        'fiscal_year',
        'from_project',
        'to_project',
        'transfer_date',
        'transfer_amount',
        'transfer_remarks',
        'decline_remarks',
        'transfer_status'
    ];

    public function fromProject()
    {
        return $this->belongsTo(Project::class, 'from_project','project_id');
    }

    public function toProject()
    {
        return $this->belongsTo(Project::class, 'to_project','project_id');
    }

}
