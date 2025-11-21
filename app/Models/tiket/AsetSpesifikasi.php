<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AsetSpesifikasi extends Model
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
    protected $table = 'aset_spesifikasi';
    protected $primaryKey = 'id_spesifikasi';

    protected $fillable = [
        'id_aset',
        'processor',
        'ram',
        'hdd',
        'ssd',
        'vga',
        'motherboard',
        'psu',
        'spesifikasi_lain',
        'is_active'
    ];

    /**
     * Relasi ke master aset (Inverse One to One).
     */
    public function aset()
    {
        return $this->belongsTo(MasterAset::class, 'id_aset', 'id_aset');
    }
}
