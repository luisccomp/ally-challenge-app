<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $fillable = [
        'name',
        'city'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Retrieve all courses that belongs to a school
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'school_id');
    }
}
