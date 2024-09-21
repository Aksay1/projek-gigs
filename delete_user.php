<?php
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM tb_user WHERE id = $user_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>