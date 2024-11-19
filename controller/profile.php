<?php
include_once "../shared/head.php";
include_once "../core/config.php";


$num_rows=null;
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $profile_id = $_SESSION['admin']['id'];
  $select = "SELECT * FROM users where id=$profile_id ";
  $s = mysqli_query($connect, $select);
  $fetch = mysqli_fetch_assoc($s);
  if ($fetch['email'] != $email) {
    $select_one = "SELECT * FROM users where email='$email' ";
    $s_one = mysqli_query($connect, $select_one);
    $num_rows = mysqli_fetch_assoc($s_one);

  }   if ($num_rows > 0) {
    $_SESSION['message'] = "Email Already Exist";
    redirect('pages/profile.php');
  }
  else {

    if (empty($_FILES['upload_img']['name'])) {
      $image_name = $fetch['image'];
    } else {
      $old_image = $fetch['image'];
      if ($old_image != "placeholder.jpg") {
        unlink("../upload/$old_image");
      }
      $image_name = time() . $_FILES['upload_img']['name'];
      $tmp_name = $_FILES['upload_img']['tmp_name'];
      $location = "../upload/$image_name";
      move_uploaded_file($tmp_name, $location);
    }

    $update = "UPDATE users Set name='$name' ,email='$email', image='$image_name' where id=$profile_id";
    $u = mysqli_query($connect, $update);
    $_SESSION["admin"]['image'] = $image_name;
    $_SESSION["admin"]['name'] = $name;
    $_SESSION["admin"]['email'] = $email;
    redirect("pages/profile.php");
  }
}
