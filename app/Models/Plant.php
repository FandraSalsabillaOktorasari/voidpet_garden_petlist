<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plant extends Model
{
    protected $fillable = ['name'];

    public function vividForms(): BelongsToMany
    {
        return $this->belongsToMany(VividForm::class, 'plant_vivid_form', 'plant_id', 'vivid_form_id')->withTimestamps();
    }
}
