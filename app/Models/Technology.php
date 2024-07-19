<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = ['name'];

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }
}
