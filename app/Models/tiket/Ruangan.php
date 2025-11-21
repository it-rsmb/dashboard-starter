<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ruangan extends Model
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

    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'id_unit',
        'nama_ruangan',
        'kode_ruangan',
        'lokasi',
    ];

    /**
     * Get the unit that owns the ruangan.
     */
    public function units()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    /**
     * Get the master assets for the ruangan.
     */
    public function masterAsets()
    {
        return $this->hasMany(MasterAset::class, 'id_ruangan', 'id_ruangan');
    }
}
