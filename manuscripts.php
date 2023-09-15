<?php
session_start();

include_once './includes/connection.php'; 

include_once 'includes/header.php';

if ( !isset( $_SESSION['loggedInUserId'])) {
  header('location: ./login.php');exit;
}

$userid = $_SESSION['loggedInUserId'];

if ( isset($_REQUEST['action']) ) {
  $action = $dbc->real_escape_string( $_REQUEST['action'] );
  switch ($action) {
    case 'upload-manuscript':
      $author = $dbc->real_escape_string( $_POST['author'] );
      $title = $dbc->real_escape_string( $_POST['title'] );
      $email = $dbc->real_escape_string( $_POST['email'] );
      $department = $dbc->real_escape_string( $_POST['department'] );
      $abstract = $dbc->real_escape_string( $_POST['abstract'] );
      $paper = $_FILES['paper'];
      $old_name = basename($paper['name']);
      $old_name_arr = explode('.', $old_name);
      $extn = end($old_name_arr);
      $path = './manuscripts/uploads/';
      $filename = "${userid}_" . time() . ".$extn";
      $new_name = "$path$filename";
    
      $save_file = move_uploaded_file($paper['tmp_name'], $new_name);
    
      if ( $save_file ) {
          $upload_sql = "INSERT INTO `manuscripts`(`uploader_id`,`author_name`,`title`,`email`,`department`,`abstract`,`file`)
          VALUES('$userid','$author','$title','$email','$department','$abstract','$filename')";
          $upload_query = $dbc->query( $upload_sql );
          FlashMessage::add('<p class="alert alert-success">Manuscripts Uploaded Successfully!</p>');
          FlashMessage::redirect('manuscripts');
      }
        
      break;
        
    case 'download':
      //get id from url
      $id = $dbc->real_escape_string( $_REQUEST['id'] );
      
      //get file name and path from database
      $sel_sql = "SELECT `reviewed_file` FROM `manuscripts` WHERE `id` = '$id'";
      $sel_result = $dbc->query( $sel_sql );
      
      if( $sel_result->num_rows > 0 ) {
        $file = $sel_result->fetch_assoc()['reviewed_file'];

        if( $file != "" ) {
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
      }else{
        FlashMessage::add('<p class="alert alert-danger">File Not Found!</p>');
        FlashMessage::redirect('manuscripts');
      }
      break;

    case 'update':
      $id = $dbc->real_escape_string( $_REQUEST['id'] );

      $manuscript = $_FILES['manuscript'];
      $old_name = basename($manuscript['name']);
      $old_name_arr = explode('.', $old_name);
      $extn = end($old_name_arr);
      $path = './manuscripts/uploads/';
      $filename = "{$userid}_" . time() . ".$extn";
      $save_path = "$path$filename";

      $save_file = move_uploaded_file($manuscript['tmp_name'], $save_path);

      if ( $save_file ) {
        $update_sql = "UPDATE `manuscripts`
        SET `file`='$filename',`status`='pending'
        WHERE `id`='$id'";
         $update_query = $dbc->query( $update_sql );
	//var_dump($dbc);exit;
         FlashMessage::add('<p class="alert alert-success">Manuscripts Updated Successfully!</p>');
         FlashMessage::redirect('manuscripts');
      }
      break;

  }
}
?>
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('images/happy.jpg')">
<div class="container">
  <div class="row align-items-end">
    <div class="col-lg-7">
      <h2 class="mb-0">Submit Manuscript</h2>
      <p>As part of the submission process, authors are required to check off their submission's compliance with all the following items, and submissions may be returned to authors that do not adhere to these guidelines.</p>
    <p>The submission has not been previously published, nor is it before another journal for consideration (or an explanation has been provided in Comments to the Editor).</p>
  <br>
  <a target="_blank" href="assets/authors guide.pdf" class="btn btn-buttons btn-outline-dark-green mr-3 mb-3">View the Authors Guideline</a>
  <a href="assets/authors guide.pdf" download class="btn btn-buttons btn-outline-dark-green mr-3 mb-3">Download the Authors Guideline</a>
  <br><br><br>
    </div>
  </div>
</div>
</div> 

<div class="custom-breadcrumns border-bottom">
  <div class="container">
    <a href="index.html">Home</a>
    <span class="mx-3 icon-keyboard_arrow_right"></span>
    <span class="current">Submit Manuscript</span>
  </div>
</div>

<div class="site-section p-5">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12">
        <?= FlashMessage::render(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <ul class="nav nav-tabs mb-3 mt-3 nav-fill" id="justifyTab" role="tablist">                    
          <li class="nav-item">
            <a class="nav-link active" id="my-manuscripts-tab" data-toggle="tab" href="#my-manuscripts" role="tab" aria-controls="my-manuscripts" aria-selected="false">My Manuscripts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="upload-manuscript-tab" data-toggle="tab" href="#upload-manuscript" role="tab" aria-controls="upload-manuscript" aria-selected="true">Manuscript Upload</a>
          </li>
        </ul>
        <div class="tab-content" id="justifyTabContent">
          <div class="tab-pane fade active show" id="my-manuscripts" role="tabpanel" aria-labelledby="my-manuscripts-tab">
            <div class="table-responsive">
              <table id="table" class="table table-bordered">
                <thead>
                    <th>S/N</th>
                    <th>Abstract</th>
                    <th>Author</th>
                    <th>Downloads</th>
                    <th>File</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                  <?php
                  $uploader_type = isset($_SESSION['loggedInEditorId'])?'admin':'user';
                  $query = "SELECT * FROM `manuscripts` WHERE `uploader_id`='$userid'";
                  $result = $dbc->query( $query );
                  if($result->num_rows > 0) {
                    $path = './manuscripts/uploads/';
                    $sn=1;
                      while($row = $result->fetch_assoc()) { 
                        $date = date('d M, Y', strtotime($row['date_uploaded']));
                        $title = $row['title'];
                        $file = $row['file'];
                        $reviewed_file = $row['reviewed_file'];
                        $abstract = $row['abstract'];
                        $author_name = $row['author_name'];
                        //slice the abstract to 25 characters
                        $abstract = substr($abstract, 0, 25).'...';
                        $status = $row['status'];
                        $downloads = $row['download_count'];
                      ?>
                      <tr>
                          <td><?= $sn++; ?></td>
                          <td><?= ucfirst($abstract); ?></td>
                          <td><?= ucwords($author_name); ?></td>
                          <td><?= $downloads ?></td>
                          <td>
                            <a target="_blank" href="./manuscripts/uploads/<?= basename($file);?>" class=""><?= basename($file);?></a>
                          </td>
                          <td><?= $date; ?></td>
                          <td>
                            <?php
                              if ($status == 'approved') {
                                ?>
                                <button type="button" class="btn btn-primary mb-2">Approved</button>
                                <?php
                              }
                              else if ($status == 'pending') {
                                ?>
                                <!-- approve button -->
                                <button type="button" class="btn btn-warning mb-2">Pending</button>
                                <?php
                              }
                              else if ($status == 'reviewed') {
                                ?>
                                <!-- reviewed button -->
                                <button type="button" class="btn btn-secondary mb-2">Reviewed</button>
                                <?php
                              }
                              else if ($status == 'rejected') {
                                ?>
                                <!-- approve button -->
                                <button type="button" class="btn btn-danger mb-2">Rejected</button>
                                <?php
                              }
                              ?>
                          </td>
                          <td>
                            <?php
                              if ($status == 'reviewed') {
                                ?>
                                <!-- review button -->
                                <button type="button" class="btn btn-warning mb-2 mr-2" data-toggle="modal" data-target="#updatemanuscript">Update&nbsp;&nbsp;<span class="icon-edit"></span></button>
                                <div class="modal fade" id="updatemanuscript" tabindex="-1" role="dialog" aria-labelledby="rejectManuscriptLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectManuscriptLabel">Update Manuscript</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                              <h3>Title: <?= ucwords($title); ?></h3>

                                                <form method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="action" value="update">
                                                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                  <div class="row">
                                                    <div class="col-md-12 form-group">
                                                      <label for="manuscript" style="margin-left: 15px ">Upload Reviewed Manuscript</label>
                                                      <input type="file" name="manuscript" class="form-control" id="manuscript" required>
                                                    </div>
                                                  </div>
                                                  <div class="row mt-4">
                                                    <div class="col-12">
                                                      <input type="submit" id='submit' value="Submit" class="btn btn-primary btn-lg px-5">
                                                    </div>
                                                  </div>
                                              </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn mr-4" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?=$path.$reviewed_file;?>" target="_blank" class="btn btn-secondary mb-2">View&nbsp;&nbsp;<span class="icon-eye"></span></a>
                                <!-- <a href="manuscripts.php?action=download&id=<?=$row['id'];?>" class="btn btn-success mb-2">Download&nbsp;&nbsp;<span class="icon-download"></span></a> -->
                                <?php
                              }
                              ?>
                          </td>
                        </tr>
                        <?php
                      }
                    }  
                      ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade p-2" id="upload-manuscript" role="tabpanel" aria-labelledby="upload-manuscript-tab">
            <form id="form" method="post" enctype="multipart/form-data" class="needs-validation">
                <div class="row">
                  <input type="hidden" name="action" value="upload-manuscript">
                  <div class="col-md-6 form-group">
                      <label for="author">Names of the Corresponding authors (Seperated with semi-colon (;))</label>
                      <input type="text" name="author" id="author" class="form-control form-control-lg" required>
                  </div>
                  <div class="col-md-6 form-group">
                      <label for="title">Title of the Paper</label>
                      <input type="text" name="title" id="title" class="form-control form-control-lg" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="email">Email Address (Corresponding author)</label>
                      <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                  </div>
                  <div class="col-md-6 form-group">
                      <label for="department">Area of Publication</label>
                      <select name="department" id="department" class="form-control form-control-lg" required>
                        <option value="">--select--</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                        <option value="Programming">Programming</option>
                        <option value="Data Analyst">Data Analyst</option>
                        <option value="Data Science">Data Science</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="abstract">Abstract (Minimum of 200 words)</label>
                    <textarea name="abstract" id="abstract" cols="10" rows="10" class="form-control" required></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="paper" style="margin-left: 15px ">Upload Complete Paper</label>
                    <input type="file" name="paper" class="form-control" id="paper" required>
                  </div>
                </div>
                <div class="form-group my-4">
                  <div class="form-check pl-0 d-flex align-items-center">
                      <div class="custom-control custom-checkbox checkbox-success">
                          <input type="checkbox" class="custom-control-input" id="invalidCheck" required>
                          <label class="custom-control-label" for="invalidCheck">Agree to terms and conditions</label>
                          <div class="invalid-feedback">
                              You must agree before submitting.
                          </div>
                      </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-12">
                    <input type="submit" id='submit' value="Submit" class="btn btn-primary btn-lg px-5">
                  </div>
                </div>
            </form>
          </div>
        </div>
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
        <p><a href="about.html">Read More</a></p>
      </div>
      <div class="col-lg-3">
        <h3 class="footer-heading"><span>Our Journal</span></h3>
        <ul class="list-unstyled">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="admissions.html">Authors Guide</a></li>
            <li><a href="journals.php">Journals</a></li>
            <li><a href="submit.php">Submit Manuscript</a></li>
            <li><a href="contacts.html">Contact Us</a></li>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="copyright">
            <p>Copyright &copy;
              <script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made <i class="icon-heart" aria-hidden="true"></i> by Datalla Muhammad Wade-Wade</a>
            </p>
        </div>
      </div>
    </div>

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
<?php include_once 'includes/scripts.php' ?>
<script>

  // Snackbar.show({
  //   text: 'Manuscript Uploaded Successfully.',
  //   pos: 'top-center',
  //   actionTextColor: '#fff',
  //   backgroundColor: '#8dbf42'
  // });

</script>
</body>
</html>