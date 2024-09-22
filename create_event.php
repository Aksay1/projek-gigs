<?php
// Koneksi ke database
$host = "localhost"; // Sesuaikan dengan host kamu
$username = "root"; // Sesuaikan dengan username MySQL kamu
$password = ""; // Sesuaikan dengan password MySQL kamu
$database = "db_gigseats"; // Sesuaikan dengan nama database kamu

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $event_name = $_POST['name'];
    $organizer_name = $_POST['company_name'];
    $event_date = $_POST['date'];
    $event_time = $_POST['time'];
    $ticket_quantity = $_POST['ticket_amount'];
    $ticket_price = $_POST['ticket_price'];
    $location = $_POST['location'];
    $description = $_POST['message'];

    // Periksa apakah ada file yang diunggah
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Mengambil file poster
        $event_poster = $_FILES['photo']['name'];
        $poster_tmp = $_FILES['photo']['tmp_name'];
        $poster_dir = "uploads/" . $event_poster;

        // Periksa apakah direktori "uploads" ada
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); // Buat direktori jika belum ada
        }

        // Upload file poster ke direktori
        if (move_uploaded_file($poster_tmp, $poster_dir)) {
            // Menyimpan data ke dalam database
            $sql = "INSERT INTO tb_event (event_name, organizer_name, event_date, event_time, ticket_quantity, ticket_price, event_poster, location, description) 
                    VALUES ('$event_name', '$organizer_name', '$event_date', '$event_time', '$ticket_quantity', '$ticket_price', '$event_poster', '$location', '$description')";

            if ($conn->query($sql) === TRUE) {
                echo "Event berhasil dibuat!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Gagal mengupload poster. Periksa izin direktori 'uploads'.";
        }
    } else {
        echo "Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>GigSeats</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/logogs.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->
	
	<!-- Header -->
	<header class="header shop">
		
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="index.html"><img src="images/gigs.png" alt="logo"></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form">
									<input type="text" placeholder="Search here..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								
								<form>
									<input name="search" placeholder="Search Event Here!" type="search">
									<button class="btnn"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<div class="right-bar">
							
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
	
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.html">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="create_event.html">Create Event</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Create Your Event</h4>
									<h3>Fill out the details below</h3>
								</div>
                                <form class="form" method="post" action="create_event.php" enctype="multipart/form-data">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Event Name<span>*</span></label>
												<input name="name" type="text" placeholder="">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Organizer Name<span>*</span></label>
												<input name="company_name" type="text" placeholder="">
											</div>	
										</div>             
										<div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Event Date<span>*</span></label>
                                                <input name="date" type="date" placeholder="">
                                            </div>
                                        </div>  
										                         
										<div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Event Hour<span>*</span></label>
                                                <input name="time" type="time" placeholder="">
                                            </div>
                                        </div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Ticket Quantity<span>*</span></label>
												<input id="ticketAmount" name="ticket_amount" type="number" min="1" placeholder="Enter the number of available tickets">
											</div>
										</div>																		
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Ticket Price<span>*</span></label>
												<input id="ticketPrice" name="ticket_price" type="text" min="0" placeholder="Enter the price per ticket">
											</div>
										</div>										
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Event Poster<span>*</span></label>
                                                <input name="photo" type="file" accept="image/*">
                                            </div>
                                        </div>   
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label>Location<span>*</span></label>
                                                <input id="locationInput" name="location" type="text" placeholder="Enter location or click button to select">
                                            </div>
                                        </div>
										<div class="col-12">
											<div class="form-group message">
												<label>Description Event<span>*</span></label>
												<textarea name="message" placeholder=""></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Confirm</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Call us Now:</h4>
									<ul>
										<li>+62 89510457258</li>
										<li>+62 89510457258</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">kautsaraksay424@gmail.com</a></li>
										<li><a href="mailto:info@yourwebsite.com">gigseats@gmai.com</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Our Address:</h4>
									<ul>
										<li>Jl Penamas Tirta 3 , Malang</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							
							<p class="text">Find and buy tickets to your favorite events easily here! Get exclusive offers and the latest event updates directly in your inbox. Join us for an unforgettable event experience!</p>
							<p class="call">Got Question? Call us 24/7<span><a href="contact.php">+6289510457258</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Information</h4>
							<ul>
								<li><a href="#">About Us</a></li>
								<li><a href="#">Faq</a></li>
								<li><a href="#">Terms & Conditions</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Help</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Customer Service</h4>
							<ul>
								<li><a href="#">Payment Methods</a></li>
								<li><a href="#">Money-back</a></li>
								<li><a href="#">Returns</a></li>
								<li><a href="#">Shipping</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Get In Tuch</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>Jl.Penamas Tirta 3</li>
									<li>Kota Malang</li>
									<li>gigseat@gmail.com</li>
									<li>+032 3456 7890</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<ul>
								<li><a href="#"><i class="ti-facebook"></i></a></li>
								<li><a href="#"><i class="ti-twitter"></i></a></li>
								<li><a href="#"><i class="ti-flickr"></i></a></li>
								<li><a href="#"><i class="ti-instagram"></i></a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © 2024 <a href="" target="_blank">GigSeats</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
	<!-- Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Color JS -->
	<script src="js/colors.js"></script>
	<!-- Slicknav JS -->
	<script src="js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="js/magnific-popup.js"></script>
	<!-- Fancybox JS -->
	<script src="js/facnybox.min.js"></script>
	<!-- Waypoints JS -->
	<script src="js/waypoints.min.js"></script>
	<!-- Jquery Counterup JS -->
	<script src="js/jquery-counterup.min.js"></script>
	<!-- Countdown JS -->
	<script src="js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="js/nicesellect.js"></script>
	<!-- Ytplayer JS -->
	<script src="js/ytplayer.min.js"></script>
	<!-- Flex Slider JS -->
	<script src="js/flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="js/scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="js/onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="js/easing.js"></script>
	<!-- Google Map JS -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnhgNBg6jrSuqhTeKKEFDWI0_5fZLx0vM"></script>	
	<script src="js/gmap.min.js"></script>
	<script src="js/map-script.js"></script>
	<!-- Active JS -->
	<script src="js/active.js"></script>
</body>
</html>