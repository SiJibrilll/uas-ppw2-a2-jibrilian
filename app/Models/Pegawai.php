<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;
    protected $table = 'jibrilian_542393_pegawai';

    public function pegawai()
    {
        return $this->hasOne(Pekerjaan::class);
    }
}
