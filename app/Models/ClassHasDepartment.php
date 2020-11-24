<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHasDepartment extends Model
{
    use HasFactory;
    protected $table = "class_has_department";
    public $timestamps = false;
}
