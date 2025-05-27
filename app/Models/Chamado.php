<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chamado extends Model
{
    protected $fillable = [
        'user_id',       
        'tecnico_id',    
        'titulo',
        'descricao',
        'categoria',   
        'prioridade',   
        'status',     
        'anexo',        
    ];

    public function respostas() {
        return $this->hasMany(Resposta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
