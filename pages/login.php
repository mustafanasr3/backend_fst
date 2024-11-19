<?php
include_once "../shared/head.php";
include_once "../core/config.php";
$_SESSION['message']=null;
$email=null;
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $select_email = "SELECT * from users where email='$email' ";
  $s = mysqli_query($connect, $select_email);
  $rows = mysqli_num_rows($s);
  if ($rows == 1) {
    $fetch = mysqli_fetch_assoc($s);
    $ifPass =  password_verify($pass, $fetch['password']);
    if ($ifPass) {
      $_SESSION['admin']=[
        "id"=>$fetch['id'],
        "name"=>$fetch['name'],
        "email"=>$email,
        "password"=>$fetch['password'],
        "image"=>$fetch['image'],

      ];
      redirect();
    } else {
      $_SESSION['message'] = "Wrong Password";
    }
  } else {
    $_SESSION['message'] = "Wrong Email";
  }
}
if(isset($_GET['logout'])){
  session_unset();
  session_destroy();
}

?>

<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="<?=url('assets/img/logo.png')?>" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">
            <?php if(isset($_SESSION['message'])):?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="text-danger"><?=$_SESSION['message']?></div>
                    <form action="<?=url('core/functions.php')?>" method="post">
                    <input type="hidden" name="old_path" value="<?="http://". $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']?>" >
                     <button type="submit" name="delete_message" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </form>
                    </div>
                    <?php endif;?>
              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <p class="text-center small">Enter your username & password to login</p>
                </div>

                <form class="row g-3 needs-validation" method="post">

                  <div class="col-12">
                    <label for="yourEmail" class="form-label">Email</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="email" name="email" value="<?=$email?>" class="form-control" id="yourEmail" required>

                    </div>

                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="yourPassword" required>

                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Don't have account? <a href="<?= url("pages/register.php") ?>">Create an account</a></p>
                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->

<?php

include_once "../shared/script.php";
?>