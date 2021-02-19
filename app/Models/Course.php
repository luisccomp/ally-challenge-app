<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'school_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Retrieve the school that this course belongs to.
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
