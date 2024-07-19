<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'university_id'
    ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
