<?php

namespace App\Models;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_categoria';

    protected $fillable = ['nombre'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_categoria');
    }
}
