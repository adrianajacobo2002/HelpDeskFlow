<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialEstado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_historial';

    protected $fillable = [
        'estado',
        'fecha',
        'id_ticket',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}
