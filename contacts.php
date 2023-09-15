<?php 

session_start();

include_once 'includes/header.php'; 

?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/happy.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-0">Contact Us</h2>
              <p>BAZE Journal Office, Baze University, Abuja.</p>
           </div>
          </div>
        </div>
      </div> 
    
    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="index.html">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Contact Us</span>
      </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" class="form-control form-control-lg">
                </div>
                <div class="col-md-6 form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" class="form-control form-control-lg">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="eaddress">Email Address</label>
                    <input type="text" id="eaddress" class="form-control form-control-lg">
                </div>
                <div class="col-md-6 form-group">
                    <label for="tel">Tel. Number</label>
                    <input type="text" id="tel" class="form-control form-control-lg">
                </div>
                        </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="message">Message</label>
                    <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
             
                    </div>
                  <div class="row">
                    <div class="col-12">
                        <input type="submit" value="Send" class="btn btn-primary btn-lg px-5">
                </div>
            </div>
        </div>
    </div>

   <div class="section-bg style-1" style="background-image: url('images/hero_1.jpg');">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-mortarboard"></span>
              <h3>Peer-Review Process</h3>
              <p>The Chief Editor assigns the manuscript to one of the Field Editors. When judging for it qualified refereeing process, the Field Editor will identify</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-school-material"></span>
              <h3>Aim and Scope</h3>
              <p>This journal will serve the interests of Professionals, academics and research organizations working in the field of computing engineering,</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
              <span class="icon flaticon-library"></span>
              <h3>Publication Frequency</h3>
              <p>The journal will be published bi-annual (February and August). Submissions for the first issue should be received in August.</p>
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
<?php include_once 'includes/scripts.php'; ?>
</body>
</html>