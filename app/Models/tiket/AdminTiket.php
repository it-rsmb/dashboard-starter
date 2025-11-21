<?php

namespace App\Models\tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AdminTiket extends Model
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

    protected $table = 'admin_tiket';
    protected $primaryKey = 'id';

    protected $fillable = [
       'id_user',
        'admin_tipe',
        'creater',
        'deleted_by',
        'updated_by',
        'created_by',
        'phone_number',
        'nama_admin',
    ];

    /**
     * Get the ruangan for the unit.
     */
    public function ruangans()
    {
        return $this->hasMany(Ruangan::class, 'id_unit', 'id_unit');
    }
}
