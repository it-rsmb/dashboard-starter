<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AsetMutasi extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->id;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->id;
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::user()->id;
                $model->save(); // Save the change to the deleted_by field
            }
        });
    }
    protected $table = 'aset_mutasi';
    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'id_aset',
        'id_unit_awal',
        'id_ruangan_awal',
        'id_unit_tujuan',
        'id_ruangan_tujuan',
        'tanggal_mutasi',
        'keterangan',
    ];

    // Relasi ke aset
    public function aset()
    {
        return $this->belongsTo(MasterAset::class, 'id_aset', 'id_aset');
    }

    // Relasi opsional ke unit & ruangan
    public function unitAwal()
    {
        return $this->belongsTo(Unit::class, 'id_unit_awal', 'id_unit');
    }

    public function unitTujuan()
    {
        return $this->belongsTo(Unit::class, 'id_unit_tujuan', 'id_unit');
    }

    public function ruangan_awal()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_awal', 'id_ruangan');
    }

    public function ruangan_tujuan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_tujuan', 'id_ruangan');
    }


  
}
