<?php

// Include the database configuration file
include 'db/dbconfig.php';

//get email and title from formdata
$email = $_POST['email'];

$title = $_POST['title'];

//upload file
if(isset($_FILES['file'])){
    $errors= '';
    
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp =$_FILES['file']['tmp_name'];
    $file_type=$_FILES['file']['type'];
    $tmp = explode('.', $file_name);
$file_ext = end($tmp);
    $file_ext=strtolower($file_ext);
//echo $file_ext;
    $expensions= array("pdf");

    if(in_array($file_ext,$expensions)=== false){
        $errors="extension not allowed, please choose a PDF file.";
    }
    //chec if file size is greater than 20mb
    if($file_size > 20971520){
        $errors='File size must be excately 20 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"manuscripts/".$file_name);
        $file_name = "manuscripts/".$file_name;
        //update database
        $sql = "UPDATE `manuscripts` SET `file` = '$file_name' WHERE `email` = '$email' AND `title` = '$title'";
        $result = mysqli_query($conn, $sql) or die("Something went wrong with the file upload ".mysqli_error($conn));
        if($result){
            echo "success";
        }

    }else{
        echo $errors;
    }
}


?>