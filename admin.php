<?php
include 'koneksi.php';

// Handle Edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = $id");
    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error fetching user: " . mysqli_error($conn) . "</div>";
    }
}

// Handle Update User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $id = intval($_POST['user_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    
    $sql = "UPDATE tb_user SET username='$username', email='$email', password='$password', level='$level', no_hp='$no_hp' WHERE user_id=$id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating user: " . mysqli_error($conn) . "</div>";
    }
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM tb_user WHERE user_id=$id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting user: " . mysqli_error($conn) . "</div>";
    }
}

// Handle Update Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $organizer_name = mysqli_real_escape_string($conn, $_POST['organizer_name']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_time = mysqli_real_escape_string($conn, $_POST['event_time']);
    $ticket_quantity = intval($_POST['ticket_quantity']);
    $ticket_price = intval($_POST['ticket_price']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "UPDATE tb_event SET event_name='$event_name', organizer_name='$organizer_name', event_date='$event_date', 
            event_time='$event_time', ticket_quantity=$ticket_quantity, ticket_price=$ticket_price, location='$location', 
            description='$description' WHERE event_id=$event_id";

    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating event: " . mysqli_error($conn) . "</div>";
    }
}

// Handle Delete Event
if (isset($_GET['delete_event'])) {
    $event_id = intval($_GET['delete_event']);
    $sql = "DELETE FROM tb_event WHERE event_id=$event_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting event: " . mysqli_error($conn) . "</div>";
    }
}
// Handle Delete Contact
if (isset($_GET['delete_contact'])) {
    $contact_id = intval($_GET['delete_contact']);
    $sql = "DELETE FROM tb_contact WHERE contact_id=$contact_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting contact: " . mysqli_error($conn) . "</div>";
    }
}
// Query to get all users
$result = mysqli_query($conn, "SELECT * FROM tb_user");
if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error fetching users: " . mysqli_error($conn) . "</div>";
}

// Query to count the total number of users
$count_user_sql = "SELECT COUNT(*) AS total_users FROM tb_user";
$count_user_result = mysqli_query($conn, $count_user_sql);
$user_data = mysqli_fetch_assoc($count_user_result);
$total_users = $user_data['total_users'];

// Query untuk mengambil semua event
$event_result = mysqli_query($conn, "SELECT * FROM tb_event");
if (!$event_result) {
    echo "<div class='alert alert-danger' role='alert'>Error saat mengambil event: " . mysqli_error($conn) . "</div>";
}
// Query to get all contacts
$contact_result = mysqli_query($conn, "SELECT * FROM tb_contact");
if (!$contact_result) {
    echo "<div class='alert alert-danger' role='alert'>Error fetching contacts: " . mysqli_error($conn) . "</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 180px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }
        .sidebar-header {
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            color: #f3b972;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #444;
        }
        .content {
            margin-left: 180px;
            padding: 20px;
        }
        .navbar {
            margin-left: 250px;
            background-color: #333;
            color: white;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-action {
            margin: 0 5px;
        }
        .event-poster {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>GigSeats</h2>
        </div>
        <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#users"><i class="fas fa-users"></i> Users</a>
        <a href="#payments"><i class="fas fa-dollar-sign"></i> Payments</a>
        <a href="#events"><i class="fas fa-calendar-alt"></i> Events</a>
        <a href="#settings"><i class="fas fa-cogs"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid mt-4">
            <h2>Dashboard Admin</h2>
            <p>Welcome to the admin panel.</p>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">Jumlah User</h5>
                            <h2 id="user-count"><?php echo $total_users; ?></h2> <!-- Gantilah dengan nilai dinamis -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <h5 class="card-title">Total Payments</h5>
                            <h2 id="total-payments">IDR 0</h2> <!-- Gantilah dengan nilai dinamis -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Users -->
            <div id="users" class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-users"></i> List Users
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password User</th>
                                    <th>Level</th>
                                    <th>No HP</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo substr($row['password'], 0, 20) . '...'; ?></td>
                                <td><?php echo $row['level']; ?></td>
                                <td><?php echo $row['no_hp']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['user_id']; ?>" data-username="<?php echo $row['username']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-level="<?php echo $row['level']; ?>" data-no_hp="<?php echo $row['no_hp']; ?>">Edit</a>
                                    <a href="?delete=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apa kamu yakin akan menghapus?');">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7">No User Found</td>
                            </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<!-- Modal for Editing User -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <input type="text" class="form-control" id="level" name="level" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
            <!-- Payments Table -->
            <div id="payments" class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-dollar-sign"></i> Payments from Event Organizers
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Organizer Name</th>
                                    <th>Event Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <!-- You can add tbody here for dynamic payment data -->
                        </table>
                    </div>
                </div>
            </div>

       <!-- List Event -->
    <div id="events" class="card mt-4">
        <div class="card-header">
            <i class="fas fa-calendar-alt"></i> List Event
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Organizer Name</th>
                            <th>Event Date</th>
                            <th>Event Time</th>
                            <th>Ticket Quantity</th>
                            <th>Ticket Price</th>
                            <th>Poster Event</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($event_result && mysqli_num_rows($event_result) > 0): ?>
                    <?php while ($event = mysqli_fetch_assoc($event_result)): ?>
                    <tr>
                        <td><?php echo $event['event_id']; ?></td>
                        <td><?php echo $event['event_name']; ?></td>
                        <td><?php echo $event['organizer_name']; ?></td>
                        <td><?php echo $event['event_date']; ?></td>
                        <td><?php echo $event['event_time']; ?></td>
                        <td><?php echo $event['ticket_quantity']; ?></td>
                        <td>IDR <?php echo number_format($event['ticket_price'], 0, ',', '.'); ?></td>
                        <td><img src="uploads/<?php echo $event['event_poster']; ?>" alt="Poster Event" class="event-poster"></td>
                        <td><?php echo $event['location']; ?></td>
                        <td><?php echo $event['description']; ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="#" class="btn btn-sm btn-primary mb-2 w-75" data-toggle="modal" data-target="#editEventModal" 
                               data-id="<?php echo $event['event_id']; ?>"
                               data-name="<?php echo $event['event_name']; ?>"
                               data-organizer="<?php echo $event['organizer_name']; ?>"
                               data-date="<?php echo $event['event_date']; ?>"
                               data-time="<?php echo $event['event_time']; ?>"
                               data-ticket-quantity="<?php echo $event['ticket_quantity']; ?>"
                               data-ticket-price="<?php echo $event['ticket_price']; ?>"
                               data-location="<?php echo $event['location']; ?>"
                               data-description="<?php echo $event['description']; ?>">
                               Edit
                            </a>

                            <!-- Tombol Delete -->
                            <a href="?delete_event=<?php echo $event['event_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus event ini?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="11">Tidak ada event ditemukan</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit Event -->
    <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="admin.php">
                        <input type="hidden" id="event_id" name="event_id">
                        <div class="form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" required>
                        </div>
                        <div class="form-group">
                            <label for="organizer_name">Organizer Name</label>
                            <input type="text" class="form-control" id="organizer_name" name="organizer_name" required>
                        </div>
                        <div class="form-group">
                            <label for="event_date">Event Date</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="form-group">
                            <label for="event_time">Event Time</label>
                            <input type="time" class="form-control" id="event_time" name="event_time" required>
                        </div>
                        <div class="form-group">
                            <label for="ticket_quantity">Ticket Quantity</label>
                            <input type="number" class="form-control" id="ticket_quantity" name="ticket_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="ticket_price">Ticket Price</label>
                            <input type="number" class="form-control" id="ticket_price" name="ticket_price" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- List Contact -->
    <div id="contacts" class="card mt-4">
    <div class="card-header">
        <i class="fas fa-address-book"></i> List Contacts
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Organizer Name</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($contact_result && mysqli_num_rows($contact_result) > 0): ?>
                <?php while ($contact = mysqli_fetch_assoc($contact_result)): ?>
                <tr>
                    <td><?php echo $contact['contact_id']; ?></td>
                    <td><?php echo $contact['name']; ?></td>
                    <td><?php echo $contact['email']; ?></td>
                    <td><?php echo $contact['organizer_name']; ?></td>
                    <td><?php echo $contact['phone']; ?></td>
                    <td><?php echo $contact['message']; ?></td>
                    <td>
                    <a href="javascript:void(0);" onclick="openReplyModal('<?php echo $contact['contact_id']; ?>', '<?php echo $contact['email']; ?>');" class="btn btn-sm btn-primary">Reply</a>
                        <a href="?delete_contact=<?php echo $contact['contact_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7">No Contacts Found</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function openReplyModal(contactId, contactEmail) {
        // Set the contact ID and email in the modal's hidden fields
        document.getElementById('contactId').value = contactId;
        document.getElementById('contactEmail').value = contactEmail;

        // Show the modal
        $('#replyModal').modal('show');
    }
</script>

<!-- Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="replyModalLabel">Reply to Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="send_reply.php" method="POST">
          <input type="hidden" name="contact_id" id="contactId">
          <input type="hidden" name="contact_email" id="contactEmail">
          <div class="form-group">
            <label for="reply_message">Your Message</label>
            <textarea name="reply_message" class="form-control" id="replyMessage" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('id');
            var username = button.data('username');
            var email = button.data('email');
            var password = button.data('password');
            var level = button.data('level');
            var no_hp = button.data('no_hp');
            
            var modal = $(this);
            modal.find('#user_id').val(userId);
            modal.find('#username').val(username);
            modal.find('#email').val(email);
            modal.find('#password').val(password);
            modal.find('#level').val(level);
            modal.find('#no_hp').val(no_hp);
        });

        $('#editEventModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var organizer = button.data('organizer');
            var date = button.data('date');
            var time = button.data('time');
            var ticketQuantity = button.data('ticket-quantity');
            var ticketPrice = button.data('ticket-price');
            var location = button.data('location');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#event_id').val(id);
            modal.find('#event_name').val(name);
            modal.find('#organizer_name').val(organizer);
            modal.find('#event_date').val(date);
            modal.find('#event_time').val(time);
            modal.find('#ticket_quantity').val(ticketQuantity);
            modal.find('#ticket_price').val(ticketPrice);
            modal.find('#location').val(location);
            modal.find('#description').val(description);
        });
    </script>
</body>
</html>