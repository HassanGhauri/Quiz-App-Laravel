<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
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
        'quiz_id',
        'question',
        'choices',
        'enable',
    ];

    /**
     * Cast choices JSON to array automatically
     */
    protected $casts = [
        'choices' => 'array',
    ];

    /**
     * Relationship with Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}