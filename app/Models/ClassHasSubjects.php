<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHasSubjects extends Model
{
    use HasFactory;
    protected $table = "class_has_subjects";
    public $timestamps = false;
}
