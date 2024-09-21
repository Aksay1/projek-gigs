<?php
// Start session
session_start();

// Include database connection file
include "koneksi.php";

// Capture data sent from login form
$email = $_POST['logmail'];
$password = $_POST['logpass'];

// Define the password encryption format
$pengacak = "p3ng4c4k";
$password_acak = md5($pengacak . md5($password) . $pengacak);

// Query to select user data with the given email and encrypted password
$query = "SELECT * FROM tb_user WHERE email='$email' AND password='$password_acak'";

// Execute the query and store the result
$hasil = mysqli_query($conn, $query);

// Fetch data from the query result
$data = mysqli_fetch_array($hasil);

// Count the number of rows returned by the query
$cek = mysqli_num_rows($hasil);

// Check if user data was found
if ($cek > 0) {
    // Check if user is an admin
    if ($data['level'] == "admin") {
        $_SESSION['username'] = $data['username']; 
        $_SESSION['level'] = "admin";
        header("Location: admin.php");
        exit();
    }
    // Check if user is a regular user
    else if ($data['level'] == "user") {
        $_SESSION['username'] = $data['username']; 
        $_SESSION['level'] = "user";
        header("Location: index.html");
        exit();
    } else {
        echo "Invalid user level";
    }
} else {
    // If no user data was found, redirect back with error
    header("Location: login.php?error=notfound");
    exit();
}
?>
