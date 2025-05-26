<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $fillable = [
        'chamado_id',       
        'user_id',    
        'mensagem',      
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
