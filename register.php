<?php

include 'includes/connection.php';

if( isset($_POST['action']) AND isset($_POST['action']) == 'register'){

    $name = $dbc->real_escape_string( $_POST['name'] );
    $email = $dbc->real_escape_string( $_POST['email'] );
    $password = $dbc->real_escape_string( $_POST['password'] );
    $cpassword = $dbc->real_escape_string( $_POST['cpassword'] );

    //check if email exits
    $sql = "SELECT * FROM `users` WHERE `email`='$email'";
    
    $result = $dbc->query($sql);

    if( $password !== $cpassword ){
      $error = "Passwords mismatch!";
    }
    else if( $dbc->affected_rows > 0 ){
      $error = "Email already exists, please login";
    }
    else{
    //insert to users table
      $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name', '$email', '$password')";
      $result =$dbc->query($sql);
      if( $dbc->affected_rows > 0 ) {
        $_SESSION['user_id'] = $dbc->insert_id;
        //redirect to dashboard
        header("Location: login.php");
        exit();
    }else{
        $error = "An error occured";
    }
  }
}
?>
<?php include_once 'includes/header.php'; ?>

    <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end justify-content-center text-center">
            <div class="col-lg-7">
              <h2 class="mb-0">Register</h2>
              <p>Register if you don't have an account.</p>
            </div>
          </div>
        </div>
      </div> 
    
      <div class="custom-breadcrumns border-bottom">
        <div class="container">
          <a href="index.html">Home</a>
          <span class="mx-3 icon-keyboard_arrow_right"></span>
          <span class="current">Register</span>
        </div>
      </div>

      <div class="site-section">
        <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-5">
                <form method="post">
                  <p class="text text-danger text-center"><?php echo @$error ?></p>
                  <input type="hidden" name="action" value="register">

                  <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="username">Name</label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required class="form-control form-control-lg">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required class="form-control form-control-lg">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" required class="form-control form-control-lg">
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-12">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                  </div>
                  <div class="col-12">
                    <input type="submit" name="register" value="Register" class="btn btn-primary btn-lg px-5">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
                      <p>Baze University Journal is a peer-reviewed, jointly published by Baze University, Abuja.</p>  
              <p><a href="about.php">Read More</a></p>
            </div>
                          <div class="col-lg-3">
                          <h3 class="footer-heading"><span>Our Journal</span></h3>
                          <ul class="list-unstyled">
                              <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="guide.php">Authors Guide</a></li>
                            <li><a href="journals.php">Journals</a></li>
                            <li><a href="contacts.php">Contact Us</a></li>
                
              
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="copyright">
                  <p>
                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made <i class="icon-heart" aria-hidden="true"></i> by Datalla Muhammad Wade-Wade</a>
                        </p>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
  <!-- .site-wrap -->


  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>
  <?php include_once 'includes/scripts.php' ?>
</body>
</html>