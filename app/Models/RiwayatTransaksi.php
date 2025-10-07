<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;
class RiwayatTransaksi extends Model
{
    use HasFactory;
    protected $fillable = ['id_user','no_invoice','total_berat','subtotal','status_owner','status', 'details','alamat','destination','courier','ongkir','alamat_kirim','jasa_kurir','service','est_kirim','total','snap_token','status_transaksi'];
    protected $table = 'riwayat-transaksi';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }


    protected $cast =[
        'details' => 'array',
    ];
}
