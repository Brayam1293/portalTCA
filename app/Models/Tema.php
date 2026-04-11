<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'foro';
    protected $primaryKey = 'id_foro';

    protected $fillable = [
        'titulo',
        'mensaje',
        'categoria',
        'id_usuario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_foro', 'id_foro');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_foro', 'id_foro');
    }
}