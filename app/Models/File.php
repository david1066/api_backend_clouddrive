<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='files';
    protected $fillable = [
        'name',
        's3_name',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user() { 
        return $this->belongsTo(User::class); 
    }

    

    // Formato de la fecha en español
    public function getCreatedAtAttribute($value)
    {
        Carbon::setLocale('es');
        return Carbon::parse($value)->translatedFormat('l, d F Y H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        Carbon::setLocale('es');
        return Carbon::parse($value)->translatedFormat('l, d F Y H:i:s');
    }


}