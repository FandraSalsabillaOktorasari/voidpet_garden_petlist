<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    // Tambahkan baris ini agar create() diizinkan memasukkan name dan default_element
    protected $fillable = ['name', 'default_element'];
}
