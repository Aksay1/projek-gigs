<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['event_id']);
    $name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $organizer = mysqli_real_escape_string($conn, $_POST['organizer_name']);
    $date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $time = mysqli_real_escape_string($conn, $_POST['event_time']);
    $ticket_quantity = intval($_POST['ticket_quantity']);
    $ticket_price = mysqli_real_escape_string($conn, $_POST['ticket_price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle poster upload if a new poster is uploaded
    if (!empty($_FILES['event_poster']['name'])) {
        $poster = $_FILES['event_poster']['name'];
        move_uploaded_file($_FILES['event_poster']['tmp_name'], "uploads/" . $poster);
        $sql = "UPDATE tb_event SET event_name='$name', organizer_name='$organizer', event_date='$date', 
                event_time='$time', ticket_quantity=$ticket_quantity, ticket_price='$ticket_price', 
                location='$location', description='$description', event_poster='$poster' WHERE event_id=$id";
    } else {
        $sql = "UPDATE tb_event SET event_name='$name', organizer_name='$organizer', event_date='$date', 
                event_time='$time', ticket_quantity=$ticket_quantity, ticket_price='$ticket_price', 
                location='$location', description='$description' WHERE event_id=$id";
    }
    
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
