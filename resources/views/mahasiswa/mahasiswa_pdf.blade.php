<!DOCTYPE html> 
<html> 
<head> 
 <title>Laporan KHS Mahasiswa</title> 
</head> 
<body> 
 <style type="text/css"> 
 table tr td, 
 table tr th{ 
 font-size: 9pt; 
 } 
 </style> 
 <center>  <h5>Laporan KHS</h4> </center> 
 
 <table class='table table-bordered' style="width:95%;margin: 0 auto;"> 
 <thead> 
 <tr> 
 <th>Email</th> 
 <th>NIM</th> 
 <th>Nama</th> 
 <th>Kelas</th> 
 <th>Jurusan</th> 
 <th>Alamat</th> 
 <th>Tanggal Lahir</th> 
 <th>Foto</th> 
 <th>Nilai</th> 
 </tr> 
 </thead> 
 <tbody> 
 @foreach($articles as $a) 
 <tr> 
 <td>{{ $a->title }}</td> 
 <td>{{ $a->content }}</td> 
 <td><img width="100px" src="{{ storage_path('app/public/'.$a->foto) }}"></td> 
 </tr> 
 @endforeach 
 </tbody> 
 </table> 
 
</body> 
</html> 