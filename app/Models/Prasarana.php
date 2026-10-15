<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prasarana extends Model
{
    use HasFactory;

    protected $table = 'prasaranas';

    protected $fillable = [
        'nama',
        'jumlah',
        'luas',
        'kondisi',
        'foto',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'luas' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke sarana (inventaris/barang di dalam prasarana ini).
     */
    public function saranas(): HasMany
    {
        return $this->hasMany(Sarana::class, 'prasarana_id');
    }

    /**
     * Opsi kondisi prasarana.
     */
    public static function kondisiList(): array
    {
        return [
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
        ];
    }

    /**
     * Accessor URL foto.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        return asset('storage/' . $this->foto);
    }

    /**
     * Format luas dengan satuan m².
     */
    public function getLuasFormattedAttribute(): string
    {
        if ($this->luas === null) {
            return '-';
        }

        return number_format($this->luas, 2, ',', '.') . ' m²';
    }
}
