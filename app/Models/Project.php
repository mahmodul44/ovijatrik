<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $primaryKey = 'project_id';
    public static $snakeAttributes = false;

    public function images()
    {
        return $this->hasMany(ProjectImage::class,'project_id');
    }

    public function ledger()
    {
        return $this->hasOne(Ledger::class, 'project_id','project_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id');
    }

}
