<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NombreConcepto extends Model
{   
    protected $table= 'nombreconcepto';
    public $timestamps = false;
    use HasFactory;

    public function categoria(){
        return $this->belongsTo(Categoria::class,'id_categoria');
    }

    public function concepto(){
        return $this->hasMany(Concepto::class,'id_nombreConcepto');
    }

}
