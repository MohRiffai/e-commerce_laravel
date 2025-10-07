<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = ['id_kategori','gambar','nama_produk','berat','stok','stok_offline','deskripsi','harga_jual'];

    public function kategori() 
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
    protected $table = 'produk';

    // public function getRouteKeyName(){
    //     return 'name';
    // }
}
