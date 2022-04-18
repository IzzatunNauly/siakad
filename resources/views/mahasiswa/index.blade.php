@extends('mahasiswa.layout') 
 
@section('content') 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
        </div>
    </div>
</div>
 
 @if ($message = Session::get('success')) 
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
 @endif
 @if ($message = Session::get('error')) 
    <div class="alert alert-error">
        <p>{{ $message }}</p>
    </div>
 @endif
 
 <table class="table table-bordered">
    <tr>
        <th>Email</th>
        <th>Nim</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>Alamat</th>
        <th>Tanggal Lahir</th>
        <th>Foto</th>
        <th width="280px">Action</th>
    </tr>
 @foreach ($paginate as $mhs) 
    <tr>
 
    <td>{{ $mhs ->email }}</td>
    <td>{{ $mhs ->nim }}</td>
    <td>{{ $mhs ->nama }}</td>
    <td>{{ $mhs ->kelas->nama_kelas }}</td>
    <td>{{ $mhs ->jurusan }}</td>
    <td>{{ $mhs ->alamat }}</td>
    <td>{{ $mhs ->tanggal_lahir }}</td>
    <td>{{ $mhs ->foto }}</td>
    <td>
    <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">
    
        <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
        <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
        @csrf 
        @method('DELETE') 

        <button type="submit" class="btn btn-danger">Delete</button>
        <a class="btn btn-warning btn-sm" href="/mahasiswa/nilai/{{ $mhs->nim }}">Nilai</a>
        </form>
        </td>
        </tr>
    @endforeach 
    </table>
    {{ $paginate->links() }}
@endsection
