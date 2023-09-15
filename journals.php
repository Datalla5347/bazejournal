<?php

session_start();

include 'includes/connection.php';

$msg = "";

if ( isset($_GET['action']) AND $_GET['action'] === 'download' ) {
 
  //get id from url
  $id = $dbc->real_escape_string( $_GET['id'] );
  
  //get file name and path from database
  $sel_sql = "SELECT `file` FROM `manuscripts` WHERE `id` = '$id'";
  $sel_result = $dbc->query( $sel_sql );
  
  if( $sel_result->num_rows > 0 ) {
    $file = $sel_result->fetch_assoc()['file'];
    //update download count
    $upd_sql = "UPDATE `manuscripts` SET `download_count`=(`download_count` + 1) WHERE `id` = '$id'";
    $upd_result = $dbc->query( $upd_sql );

    if( $upd_result ) {
      //download file
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($file).'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize("./manuscripts/uploads/$file"));
      readfile("./manuscripts/uploads/$file");
      exit;
    }
    else{
      FlashMessage::add('<p class="alert alert-danger">File not found!</p>');
      FlashMessage::redirect('journals');
    }
  }
}

include_once 'includes/header.php'; 

?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/happy.jpg')">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-7">
          <h2 class="mb-0">Journals</h2>
        </div>
      </div>
    </div>
  </div> 


<div class="custom-breadcrumns border-bottom">
  <div class="container">
    <a href="index.html">Home</a>
    <span class="mx-3 icon-keyboard_arrow_right"></span>
    <span class="current">Journals</span>
  </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12">
            <?= FlashMessage::render(); ?>
          </div>
        </div>
        <div class="row">
          <?php
          // Include the database configuration file
          //get manuscripts from database where status is approved
          $query = "SELECT * FROM manuscripts WHERE `status`='approved'";
          $result = $dbc->query($query);
          if($dbc->affected_rows > 0){
            while( $row = $result->fetch_assoc() ) {
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="course-1-item">
                <div class="course-1-content pb-4">
                  <h2><?php echo $row['title'] ?></h2>
                  <p class="desc mb-4">Uploaded On: <?php echo $row['date_uploaded'] ?></p>
                  <p>Downloaded <?php echo $row['download_count'] ?> times</p>
                  <p>Author: <?php echo $row['author_name'] ?></p>
                  <p><a href="journals.php?action=download&id=<?php echo $row['id'] ?>" class="btn btn-primary rounded-0 px-4">Download</a></p>
                </div>
              </div>
            </div>
            <?php
            }
          }else{
            echo '<p class="text text-danger">No manuscript found</p>';
          }
          ?>
        </div>
    </div>
</div>

<div class="section-bg style-1" style="background-image: url('images/happy.jpg');">
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