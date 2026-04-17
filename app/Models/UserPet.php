<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPet extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'element' => 'array',
    ];

    protected $appends = ['total_bonus_stat', 'total_battle_stat', 'total_overall_stat'];
    // Relasi ke tabel Species
    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    // Relasi ke tabel VividForm
    public function vividForm()
    {
        return $this->belongsTo(VividForm::class);
    }

    // Event Eloquent untuk otomatisasi saat data disimpan/dihapus
    protected static function booted()
    {
        // Berjalan tepat sebelum pet baru disimpan ke database
        static::creating(function ($pet) {
            // 1. Logika Default Name: Jika nickname kosong, pakai nama spesies
            if (empty($pet->nickname)) {
                $pet->nickname = $pet->species->name;
            }

            // 2. Logika Penentuan Elemen (jika user tidak mengirim array element)
            if (empty($pet->element)) {
                if ($pet->vivid_form_id) {
                    // Jika pet memiliki Vivid Form
                    $vivid = $pet->vividForm;
                    if ($vivid->box_type === 'void') {
                        $pet->element = [$pet->species->default_element];
                    } else {
                        $pet->element = ['Deviant ' . $vivid->box_type];
                    }
                } else {
                    // Jika pet biasa (tanpa Vivid Form)
                    $pet->element = [$pet->species->default_element];
                }
            }
        });

        // Berjalan tepat sebelum pet dihapus
        static::deleting(function ($pet) {
            // Logika Safe Lock: Tolak penghapusan jika is_favorite true
            if ($pet->is_favorite) {
                throw new \Exception("Pet ini favorit dan terkunci. Lepaskan status favorit sebelum menghapus!");
            }
        });
    }
    
    // Virtual attribute untuk mendapatkan total stat dengan mudah
    public function getTotalStatAttribute()
    {
        return $this->hp + $this->focus + $this->calm + $this->speed + $this->balance + $this->strength + 
               $this->intensity + $this->clarity + $this->stability;
    }

    // --- QUERY SCOPES UNTUK FILTER & SORTING ---

    public function scopeFilter($query, array $filters)
    {
        // Search filter (text index) - search by nickname OR species target
        $query->when($filters['search'] ?? false, function ($q, $search) {
            return $q->where(function($query) use ($search) {
                // Find by nickname
                $query->where('nickname', 'like', '%' . $search . '%')
                      // Find by species name via relation
                      ->orWhereHas('species', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            });
        });

        // Filter berdasarkan Species
        $query->when($filters['species'] ?? false, function ($q, $species) {
            return $q->whereHas('species', function ($q) use ($species) {
                $q->where('name', $species);
            });
        });

        // Filter berdasarkan Element (JSON)
        $query->when($filters['element'] ?? false, function ($q, $element) {
            return $q->whereJsonContains('element', $element);
        });

        $query->when($filters['vivid_form'] ?? false, function ($q, $vivid) {
            return $q->whereHas('vividForm', function ($q) use ($vivid) {
                $q->where('name', $vivid);
            });
        });

        // Filter berdasarkan Rarity
        $query->when($filters['rarity'] ?? false, function ($q, $rarity) {
            return $q->whereHas('vividForm', function ($q) use ($rarity) {
                $q->where('rarity', $rarity);
            });
        });

        // Filter berdasarkan Box Type (Void, Water, dll)
        $query->when($filters['box_type'] ?? false, function ($q, $box) {
            return $q->whereHas('vividForm', function ($q) use ($box) {
                $q->where('box_type', $box);
            });
        });

        $query->when($filters['stage'] ?? false, function ($q, $stage) {
            return $q->where('stage', $stage);
        });
    }

    public function scopeSort($query, $sort)
    {
        if ($sort === 'stats') {
            // Prioritas 1: Total Bonus Stat tertinggi
            $query->orderByRaw('(intensity + clarity + stability) DESC');
            
            // Prioritas 2: Jika Bonus Stat sama, lihat Total Battle Stat tertinggi
            $query->orderByRaw('(hp + focus + calm + speed + balance + strength) DESC');

            return $query;
        }

        // Default sorting: Paling recent ditambahkan
        return $query->latest(); 
    }

    // Mendapatkan total Bonus Stat
    public function getTotalBonusStatAttribute()
    {
        return $this->intensity + $this->clarity + $this->stability;
    }

    // Mendapatkan total Battle Stat
    public function getTotalBattleStatAttribute()
    {
        return $this->hp + $this->focus + $this->calm + $this->speed + $this->balance + $this->strength;
    }

    // Mendapatkan total keseluruhan (jika sewaktu-waktu tetap dibutuhkan)
    public function getTotalOverallStatAttribute()
    {
        return $this->total_bonus_stat + $this->total_battle_stat;
    }
}

