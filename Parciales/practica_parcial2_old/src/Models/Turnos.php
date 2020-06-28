<?php
namespace App\Models;

class Turnos extends \Illuminate\Database\Eloquent\Model {
    public $id;
    public $fecha;
    public $hora;
    public $id_mascota;
    public $id_veterinario;
}