<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CartaMagic extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     * Definimos valores rellenables en un formulario 
     * protected $fillable
     * protected $guarded
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'tipo',
        'email_creador',
        'imagen',
        'descripcion',
    ];

    /**
     * Definimos relaccion contraria a 1 n con user magics
     * https://laravel.com/docs/8.x/eloquent-relationships#one-to-many-inverse
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

}