<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonFood extends Pivot
{
    protected $table = 'person_food';
    protected $guarded = ['id'];
}
