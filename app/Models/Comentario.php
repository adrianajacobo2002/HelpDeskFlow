<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comentario';

    protected $fillable = [
        'contenido',
        'fecha',
        'id_usuario',
        'id_ticket',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}
