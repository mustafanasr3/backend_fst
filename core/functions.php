<?php
session_start();
// For Functionalty
define("BASE_URL" ,"http://localhost/start/");
// Base URL
function url($const=null){
  return BASE_URL . $const;
};
// redirect Function
function redirect($const=null){
  echo "
  <script>
  window.location.replace('http://localhost/start/$const');
</script>
  ";
}
function auth(){
  if(!$_SESSION['admin']) {
    redirect("pages/login.php");
  }
}
if(isset($_POST['delete_message'])){
  $old_path=$_POST['old_path'];

  unset($_SESSION['message']);
  echo "  <script>
  window.location.replace('$old_path');
</script>";
}