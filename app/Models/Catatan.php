<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $table = 'catatan';

    protected $fillable = ['judul', 'isi', 'tanggal', 'kategori'];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
    ];
}