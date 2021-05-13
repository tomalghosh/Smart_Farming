<?php
    include('functions.php');
    if(isAdmin()){
        header('location: admin.php');
    }
    elseif(isLoggedIn()){
        header('location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>
                    <?php if (isset($_SESSION['msg'])) : ?>
                        <!-- <div class="alert alert-danger" > -->
                            <!-- <h3> -->
                                <?php 
                                    echo $_SESSION['msg']; 
                                    unset($_SESSION['msg']);
                                ?>
                            <!-- </h3> -->
                        <!-- </div> -->
                    <?php endif ?>
    <img src="../images/sflogo2.png" class="logo">
    <img src="../images/plant.svg" class="ill1">
    <img src="../images/person.svg" class="ill2">
    <p class="line1">Your handy smart tool</p>
    <p class="line2">Monitor your Farm with Ease</p>
    <div class="card undercard"></div>
    <div class="card logincard">
        <h1>Login</h1><br><br>
        <form method="post" action="login.php">
        <?php echo display_error(); ?>
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Enter Email-Id">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btngreen" name="login_btn">Login</button>
        </form>
        <p class="new">New Here? <a style="color: white; text-decoration: underline;" href="./register.php">Sign Up</a></p>
    </div>
</body>

</html>