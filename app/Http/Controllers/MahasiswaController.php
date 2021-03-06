<?php

namespace App\Http\Controllers; 

use App\Models\Mahasiswa; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; 
use App\Models\Mahasiswa_MataKuliah;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$keyword= $request->keyword;
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
        // //fungsi eloquent menampilkan data menggunakan pagination
        // //$mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
        // $mahasiswa = Mahasiswa::where('nama', 'LIKE', "%" . $keyword . "%")
        // ->orwhere('nim', 'LIKE', "%" . $keyword . "%")
        // ->orwhere('kelas', 'LIKE', "%" . $keyword . "%")
        // ->orwhere('alamat', 'LIKE', "%" . $keyword . "%")
        // ->orwhere('tanggal_lahir', 'LIKE', "%" . $keyword . "%")
        // ->paginate(4);
        // //$paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3); 
        // return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'keyword' => $keyword]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); // mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Email' => 'required',
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
            'userfile' => 'required'
        ]);

        if($request->file('userfile')){
            $image_name = $request->file('userfile')->store('image', 'public');
        }
        
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->get('Email');
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama'); 
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->nim = $request->get('Alamat');
            $mahasiswa->nim = $request->get('Tanggal_Lahir');
            $mahasiswa->foto = $image_name;
            $mahasiswa->alamat = '';
            $mahasiswa->tanggal_lahir = '';
            $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        // Mahasiswa::create($request->all());
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first(); 
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first(); 
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'kelas')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        
        //ddd($request);
        //melakukan validasi data
        $request->validate([
        'Email' => 'required',
        'Nim' => 'required',
        'Nama' => 'required',
        'Kelas' => 'required',
        'Jurusan' => 'required',
        'Alamat' => 'required',
        'Tanggal_Lahir' => 'required',
        'userfile' => 'required'
        ]);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        
        if($mahasiswa->foto && file_exists(storage_path('./app/public/'. $mahasiswa->foto))){
            Storage::delete(['./public/', $mahasiswa->foto]);
        }
        
        $image_name = $request->file('userfile')->store('image', 'public');
        $mahasiswa->foto = $image_name;

        $mahasiswa->alamat = '';
        $mahasiswa->tanggal_lahir = '';
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        // Mahasiswa::create($request->all());
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $nim)->delete();
        return redirect()->route('mahasiswa.index') 
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function khs($nim){
        $mhs = Mahasiswa::where('nim', $nim)->first();
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $mhs->id_mahasiswa)
                                       ->with('matakuliah')
                                       ->with('mahasiswa')
                                       ->get();
        $nilai->mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        //dd($nilai);
        
        return view('mahasiswa.khs', compact('nilai'));
    }
    public function cetak_pdf($nim){
        // dd('tetsing');
        $mhs = Mahasiswa::where('nim', $nim)->first();
        $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $mhs->id_mahasiswa)
                                       ->with('matakuliah')
                                       ->with('mahasiswa')
                                       ->get();
        $nilai->mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $pdf = PDF::loadview('mahasiswa.nilai_pdf', compact('nilai'));
        return $pdf->stream();
    }
};