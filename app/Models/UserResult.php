<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResult extends Model
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
        'user_id',
        'quiz_id',
        'answers',
        'percentage',
        'passed',
        'time_taken',
    ];

    /**
     * Cast JSON and Boolean Fields
     */
    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}