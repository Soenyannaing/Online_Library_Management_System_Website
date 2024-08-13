<?php 
session_start();

# If the admin is logged in
if (!isset($_SESSION['user_id']) &&
    !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div    class="login-form">
        <form   class=""
                method="POST"
                action="php/auth.php">
                
                <!-- <?php
                    # first let's insert the admin
                    # have to encrypt the password using password_hash
                    echo password_hash("204999", PASSWORD_DEFAULT)
                ?> -->
                
                <h1>Login</h1>
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert" role="alert">
                      <?= htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>
                <div class="input-box">
                    <label for="exampleInputEmail1" 
                    class="form-label"></label>
                    <input type="email" 
                    class="form-control"
                    name="email" 
                    id="exampleInputEmail1" 
                    placeholder="Username" 
                    aria-describedby="emailHelp">
                </div>
                <div class="input-box">
                    <label for="exampleInputPassword1" 
                    class="form-label"></label>
                    <input  type="password" 
                            class="form-control"
                            name="password" 
                            id="exampleInputPassword1"
                            placeholder="Password">
                </div>
                <button type="submit" 
                        class="btn btn-primary">Login
                </button>
                <div class="back-link">
                    <p>Don't have an account?
                        <a href="index.php">Back to library</a>
                    </p>
                </div>
        </form>
    </div>
</body>
</html>
<?php }else{
  header("Location: admin.php");
  exit;
} ?>