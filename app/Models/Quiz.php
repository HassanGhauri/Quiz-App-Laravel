<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * Primary Key
     */
    protected $primaryKey = 'id';

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
        'title',
        'total_time',
        'passing_marks',
    ];
}