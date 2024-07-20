<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
