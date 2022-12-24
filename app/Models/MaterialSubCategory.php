<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_name',
        'material_category_id',
    ];

}
