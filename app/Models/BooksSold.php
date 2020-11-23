<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksSold extends Model
{
    use HasFactory;
    protected $table = "books_sold";
    public $timestamps = false;
}
