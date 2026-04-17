<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VividForm extends Model
{
    protected $fillable = ['name', 'box_type', 'rarity'];

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(Plant::class, 'plant_vivid_form', 'vivid_form_id', 'plant_id')->withTimestamps();
    }
}
