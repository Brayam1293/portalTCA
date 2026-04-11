<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    protected $table = 'foro';
    protected $primaryKey = 'id_foro';

    protected $fillable = [
        'id_usuario',
        'titulo',
        'categoria',
        'mensaje',
        'visible'
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_foro');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_foro');
    }
}
