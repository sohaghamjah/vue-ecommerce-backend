<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function child(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
