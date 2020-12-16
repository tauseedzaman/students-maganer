<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students_crud extends Model
{
    use HasFactory;
    protected $table = 'students_cruds';
    protected $fillable =[
    'name',
    'rollno',
    'deportment',
];
}
