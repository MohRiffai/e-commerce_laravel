<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKasir extends Model
{
    use HasFactory;
    protected $fillable = ['no_nota','details', 'total', 'cash', 'kembalian'];

    protected $table = 'transaksi-kasir';

    protected $cast = [
        'details' => 'array',
    ];

}
