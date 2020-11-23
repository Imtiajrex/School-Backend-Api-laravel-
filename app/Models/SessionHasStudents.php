<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionHasStudents extends Model
{
    use HasFactory;
    protected $table = "session_has_students";
    public $timestamps = false;
}
