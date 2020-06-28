<?php
namespace App\Models;

class Usuarios extends \Illuminate\Database\Eloquent\Model{
    public $id;
    public $email;
    public $type;
    public $pass;
}