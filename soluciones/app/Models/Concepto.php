<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    
    public function ticket(){
        return $this->belongsTo(Ticket::class,'id_ticket');
    }

    public function nombreConcepto(){
        return $this->belongsTo(NombreConcepto::class,'id_nombreConcepto');
    }
   
}
