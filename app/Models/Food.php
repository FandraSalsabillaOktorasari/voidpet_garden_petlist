<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $guarded = ['id'];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'person_food')
                    ->withPivot('id', 'gift_value', 'throw_value')
                    ->withTimestamps();
    }
}
