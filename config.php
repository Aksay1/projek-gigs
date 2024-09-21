<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gigseats";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil";
}

// Mengambil data pengguna
$sql = "SELECT user_id, username, email, password, level, no_hp FROM tb_user"; // Pastikan nama kolom sesuai dengan skema tabel
$result = $conn->query($sql);

// Pengecekan apakah query berhasil
if ($result === FALSE) {
    die("Query gagal: " . $conn->error); // Menampilkan error jika query gagal
}

// Inisialisasi array $users
$users = array();

// Mengecek apakah hasil query mengandung baris data
if ($result->num_rows > 0) {
    // Mengambil data dari hasil query
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "0 hasil";
}

// Menutup koneksi
$conn->close();
?>