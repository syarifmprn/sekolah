<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sarana extends Model
{
    use HasFactory;

    protected $table = 'saranas';

    protected $fillable = [
        'nama',
        'prasarana_id',
        'jumlah',
        'kondisi',
        'tahun_pengadaan',
        'foto',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'tahun_pengadaan' => 'integer',
        ];
    }

    /**
     * Relasi ke prasarana (ruangan/lokasi penyimpanan sarana).
     */
    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class, 'prasarana_id');
    }

    /**
     * Opsi kondisi sarana.
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
}
