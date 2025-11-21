<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MasterAset extends Model
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

    protected $table = 'master_aset';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'tipe_aset',
        'id_ruangan',
        'merk',
        'kapasitas_pk',
        'jenis',
        'sn',
        'kategori',
        'lokasi',
        'tanggal_pemasangan',
        'keterangan',
        'tanggal_pembelian',
        'nilai',
        'masa_depresiasi',
        'status',
    ];
    
    protected $casts = [
        'tanggal_pemasangan' => 'date:Y-m-d',
        'tanggal_pembelian'  => 'date:Y-m-d',
        'kapasitas_pk' => 'float',
        'nilai' => 'float',
        'masa_depresiasi' => 'integer',
    ];

    /**
     * Get the ruangan that owns the master aset.
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    // Relasi ke mutasi aset
    public function mutasi_aset()
    {
        return $this->hasMany(AsetMutasi::class, 'id_aset', 'id_aset');
    }

    // Relasi ke mutasi aset
    public function aset_spesifikasi()
    {
        return $this->hasMany(AsetSpesifikasi::class, 'id_aset', 'id_aset');
    }
}
