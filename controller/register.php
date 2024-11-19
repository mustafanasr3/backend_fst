<?php
include_once '../core/config.php';
include_once '../core/functions.php';
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 $selectEm="SELECT *  from users where email='$email'";
 $s=mysqli_query($connect ,$selectEm);
 $numR=mysqli_num_rows($s);
 if($numR >0){
  $_SESSION['message']="The Email Already Exist Please Enter Another Email";
  redirect("pages/register.php");
 }
  else {

    if (empty($_FILES['image']['name'])) {
      $image_name = 'placeholder.jpg';
    } else {
      $image_name = time() . $_FILES['image']['name'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $location = "../upload/$image_name";
      move_uploaded_file($tmp_name, $location);
    }
    $insert = "INSERT INTO users VALUES(Null, '$name' , '$email', '$hash_password' ,'$image_name')";
    $i = mysqli_query($connect, $insert);
    redirect('pages/login.php');
  }

}
