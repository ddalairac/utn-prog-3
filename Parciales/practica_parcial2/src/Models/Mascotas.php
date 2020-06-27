<?php
namespace App\Models;

class Mascotas extends \Illuminate\Database\Eloquent\Model {
    public $id;
    public $nombre;
    public $edad;
    public $id_cliente;
}