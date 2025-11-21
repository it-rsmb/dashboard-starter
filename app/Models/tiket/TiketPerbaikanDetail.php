<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TiketPerbaikanDetail extends Model
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

    protected $table = 'tiket_perbaikan_detail';

    protected $fillable = [
        'tiket_id',
        'aset_id',
        'masalah',
        'penanganan',
        'ruangan',
        'petugas',
        'waktu_penanganan',
    ];

    // Relasi ke tiket
    public function tiket()
    {
        return $this->belongsTo(TiketPerbaikan::class, 'tiket_id', 'id');
    }

    // Relasi ke aset (kalau ada tabel aset)
    public function aset()
    {
        return $this->belongsTo(MasterAset::class, 'aset_id', 'id_aset');
    }
}
