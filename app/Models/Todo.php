<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Todo extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'is_completed', 'priority', 'due_date'];

    // Ye zaroor add karein
    protected $casts = [
        'due_date' => 'date', 
    ];
}