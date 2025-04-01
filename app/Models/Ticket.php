<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ticket';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'fecha_creacion',
        'fecha_resolucion',
        'id_usuario',
        'id_agente',
        'id_categoria',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function agente()
    {
        return $this->belongsTo(User::class, 'id_agente');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_ticket');
    }

    public function historialEstados()
    {
        return $this->hasMany(HistorialEstado::class, 'id_ticket');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->setTimezone(new \DateTimeZone('America/El_Salvador'))->format('Y-m-d H:i:s');
    }

}
