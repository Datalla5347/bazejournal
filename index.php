<?php 

session_start();

include_once 'includes/header.php'; 

?>

    <div class="hero-slide owl-carousel site-blocks-cover">
      <div class="intro-section" style="background-image: url('images/front.jpg');">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-30 mx-auto text-center" data-aos="fade-up">
             
              <h1> BAZE University Online Journal Processing System</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="intro-section" style="background-image: url('images/rear.jpg');">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
              <h1>Baze University, Abuja</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div></div>

    <div class="site-section">
      <div class="container">
        <div class="row mb-5 justify-content-center text-center">
          <div class="col-lg-4 mb-5">
            <h2 class="section-title-underline mb-5">
              <span>Our Journal Works</span>
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-primary">
                <span class="flaticon-mortarboard text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2>Peer-Review Process</h2>
                <p>The Chief Editor assigns the manuscript to one of the Field Editors. When judging for it qualified refereeing process, the Field Editor will identify </p>
                <p><a href="about.php" class="btn btn-primary px-4 rounded-0">Read More</a></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-primary">
                <span class="flaticon-school-material text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2>Aim and Scope</h2>
                <p>This journal will serve the interests of Professionals, academics and research organizations working in the field of computing engineering,</p>
                <p><a href="about.php" class="btn btn-primary px-4 rounded-0">Read More</a></p>
              </div>
            </div> 
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="feature-1 border">
              <div class="icon-wrapper bg-primary">
                <span class="flaticon-library text-white"></span>
              </div>
              <div class="feature-1-content">
                <h2>Publication Frequency</h2>
                <p>The journal will be published bi-annual (February and August). Submissions for the first issue should be received in August.</p>
                <p><a href="about.php" class="btn btn-primary px-4 rounded-0">Read More</a></p>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div>


   
        </div>
      </div>
    </div>

    <div class="site-section ftco-subscribe-1" style="background-image: url('images/bazes.jpg')">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <h2>Subscribe to us!</h2>
            <p>Get e-mail updates about our latest update and special offers</p>
          </div>
          <div class="col-lg-5">
            <form action="" class="d-flex">
              <input type="text" class="rounded form-control mr-2 py-3" placeholder="Enter your email">
              <button class="btn btn-primary rounded py-3 px-4" type="submit">Send</button>
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
        </ul>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="copyright">
          <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made <i class="icon-heart" aria-hidden="true"></i> by Datalla Muhammad Wade-Wade</a>
          </p>          
      </div>
    </div>
  </div>
 
  <!-- .site-wrap -->
  <!-- loader -->
  <div id="loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/>
    </svg>
  </div>
  <?php include 'includes/scripts.php' ?>
</body>
</html>