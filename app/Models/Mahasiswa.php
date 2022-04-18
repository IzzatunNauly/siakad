<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
//use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable; 
//use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Model; //Model Eloquent
use App\Models\Mahasiswa;

class Mahasiswa extends Model //Definisi Model
{
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa 
    protected $primaryKey = 'nim';
    //protected $primaryKey = 'id_mahasiswa'; // Memanggil isi DB Dengan primarykey
   
    protected $fillable = [ 
        'Email',
        'nim', 
        'nama', 
        'kelas_id', 
        'jurusan', 
        'Alamat',
        'Tanggal_Lahir',
        'Foto',
    ]; 
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function mahasiswa_matakuliah(){
        return $this->belongsToMany(Mahasiswa_MataKuliah::class);
    }
}
