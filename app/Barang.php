<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $incrementing = false;
    public $primaryKey = 'kode_barang';
}
