<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotFlow extends Model
{
    use HasFactory;

     protected $fillable = ['texto', 'parent_id', 'es_final'];

    public function hijos() {
        return $this->hasMany(ChatbotFlow::class, 'parent_id');
    }

    public function padre() {
        return $this->belongsTo(ChatbotFlow::class, 'parent_id');
    }
}
