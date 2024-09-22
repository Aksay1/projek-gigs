<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GigSeats Login</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<!-- Modal for User Not Found -->
<div class="modal fade" id="userNotFoundModal" tabindex="-1" role="dialog" aria-labelledby="userNotFoundModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userNotFoundModalLabel">User Not Found</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                The email or password you entered is incorrect. Please try again.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<a href="https://front.codes/" class="logo" target="_blank">		
	</a>

	<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <h6 class="mb-0 pb-3"><span>Sign In </span><span>Sign Up</span></h6>
                    <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                    <label for="reg-log"></label>
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            <div class="card-front">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <form action="proses_login.php" method="post">
                                            <h4 class="mb-4 pb-3">Sign In</h4>
                                            <div class="form-group">
                                                <input type="email" name="logmail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off" required>
                                                <i class="input-icon uil uil-at"></i>
                                            </div>  
                                            <div class="form-group mt-2">
                                                <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off" required>
                                                <i class="input-icon uil uil-lock-alt"></i>
                                            </div>
                                            <input type="submit" class="btn mt-4" name="kirim" value="Submit">
                                            <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
                                        </form>  
                                    </div>
                                </div>
                            </div>

                            <div class="card-back">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <form action="proses_register.php" method="post" onsubmit="return validateForm()">
                                            <h4 class="mb-4 pb-3">Sign Up</h4>
                                            <div class="form-group"> 
                                                <input type="text" name="username" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off" required>
                                                <i class="input-icon uil uil-user"></i>
                                            </div>  
                                            <div class="form-group mt-2">
                                                <input type="email" name="email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off" required>
                                                <i class="input-icon uil uil-at"></i>
                                            </div>  
                                            <div class="form-group mt-2">
                                                <input type="password" name="password" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off" required>
                                                <i class="input-icon uil uil-lock-alt"></i>
                                            </div>
                                            <div class="form-group mt-2">
                                                <input type="text" name="no_hp" class="form-style" placeholder="Number phone" id="logphone" autocomplete="off" required>
                                                <i class="input-icon uil uil-phone"></i>
                                            </div>
                                            <input type="submit" class="btn mt-4" name="kirim" value="Submit">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validasi Form Menggunakan JavaScript -->
<script>
    function validateForm() {
        let name = document.getElementById('logname').value;
        let email = document.getElementById('logemail').value;
        let password = document.getElementById('logpass').value;
        let phone = document.getElementById('logphone').value;

        

        // Optional: validasi format email atau nomor telepon bisa ditambahkan di sini
        return true; // Lanjutkan submit jika semua field terisi
    }
</script>
  <script  src="login.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
  // Function to get parameters from URL
  function getParameterByName(name) {
      let url = window.location.href;
      name = name.replace(/[\[\]]/g, '\\$&');
      let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
      let results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }

  // Check if there is an error parameter
  let error = getParameterByName('error');
  if (error === 'notfound') {
      // Show the user not found modal
      $('#userNotFoundModal').modal('show');
  }
</script>

</body>
</html>