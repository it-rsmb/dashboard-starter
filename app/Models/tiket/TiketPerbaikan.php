<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

class TiketPerbaikan extends Model
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

    protected $table = 'tiket_perbaikan';

    protected $fillable = [
        'no_tiket',
        'pembuat_tiket',
        'tgl_pembuatan',
        'departemen',
        'departemen_done',
        'ruangan_done',
        'subjek_tiket',
        'desc_tiket',
        'kategori_tiket',
        'status_tiket',
        'prioritas_tiket',
        'ruangan',
        'gambar',
        'petugas_proses',
        'tgl_proses',
        'petugas_pending',
        'tgl_pending',
        'desc_pending',
        'petugas_done',
        'tgl_done',
        'desc_done',
        'status_tiket',
    ];

    // Relasi ke detail
    public function details()
    {
        return $this->hasMany(TiketPerbaikanDetail::class, 'tiket_id', 'id');
    }

    public function detailsfoto()
    {
        return $this->hasMany(TiketPerbaikanGambar::class, 'tiket_id', 'id');
    }

    public function ruangans()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan', 'id_ruangan');
    }
    public function departemen()
    {
        return $this->belongsTo(Unit::class, 'departemen', 'id_unit');
    }

    public function ruangans_done()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_done', 'id_ruangan');
    }
    public function departemen_done()
    {
        return $this->belongsTo(Unit::class, 'departemen_done', 'id_unit');
    }


    // Relasi ke User untuk pembuat tiket
    public function pembuat_tiket()
    {
        return $this->belongsTo(User::class, 'pembuat_tiket', 'id');
    }

    // Relasi ke User untuk petugas yang memproses tiket
    public function petugas_proses()
    {
        return $this->belongsTo(User::class, 'petugas_proses', 'id');
    }

    // Relasi ke User untuk petugas yang mempending tiket
    public function petugas_pending()
    {
        return $this->belongsTo(User::class, 'petugas_pending', 'id');
    }

    // Relasi ke User untuk petugas yang menyelesaikan tiket
    public function petugas_done()
    {
        return $this->belongsTo(User::class, 'petugas_done', 'id');
    }
}
