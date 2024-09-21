<?php
//KONEKSI KE MYSQLi
$host="localhost";
$user="root";
$pass="";
$database="db_gigseats";
$conn=mysqli_connect($host,$user,$pass,$database);
if(!$conn){
echo "KONEKSI GAGAL!!";
}else {
//echo "KONEKSI BERHASIL";//Komen jika koneksi sudah berhasil
}
?>