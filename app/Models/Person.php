<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = ['id'];

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'person_food')
                    ->withPivot('id', 'gift_value', 'throw_value')
                    ->withTimestamps();
    }
}
