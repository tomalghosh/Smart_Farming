<?php
// session_start();
include('functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">

</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="../images/sflogo.png" width="250px" height="50px" alt="Smart Farming">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!--<li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>-->
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item active logout">
                    <a class="nav-link" href="login.php?logout='1'">Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br>
    <div class="card weathercard">
        <b><p id="date"></p></b>
        <span>23-27°C&nbsp;<i class="fa fa-thermometer-half" style="color: red;" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;58%&nbsp;<i class="fa fa-tint" style="color: blue;" aria-hidden="true"></i></span>
    </div>
    <!--Add Plant-->
    <div class="card plantscard">
        <a href="#" id="addbutton" class="greenlink"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Plant</a>
    </div>
    <!--Popup Add-->
    <div id="popupadd" class="modal">
        <!--Content-->
        <div class="modal-content">
            <span class="closebutton">&times;</span>
            <form class="form-inline my-2 my-lg-0 searchfield">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    <!--Parameter Card-->
    <div class="card valcard">
        <h4 style="color:black; margin-bottom: 40px;">Plant Name</h3>
        
        <!-- <h4 style="color:black; margin-bottom: 40px;"><?php //echo $_SESSION['admin_username']; ?></h3> -->      <!-- variable name print karne ke liye -->
        

            <span>
            <div class="circle1"><br><br><span style="font-size: 20px;"><b>Moisture</b><br>14%</span></div>
    <div class="circle2"><br><br><span style="font-size: 20px;"><b>pH</b><br>5.3</span></div>
    </span>
    <div class="circle3"><br><br><span style="font-size: 20px;"><b>Nutrients</b><br>Nitrogen: 29%<br>Phosphorus: 19%</span></div>
    <div class="row" style="margin-top: 20px;">
        <div class="col"><button class="btngreen">Demand</button></div>
        <div class="col"><button class="btngreen">Pesticide</button></div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script>
        n = new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        document.getElementById("date").innerHTML = "Date: " + d + "/" + m + "/" + y;
    </script>
    <script>
        var modal = document.getElementById("popupadd");
        var btn = document.getElementById("addbutton");
        var span = document.getElementsByClassName("closebutton")[0];
        // When the user clicks add plant button, open the popup 
        btn.onclick = function() {
                modal.style.display = "block";
            }
            // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
                modal.style.display = "none";
            }
            // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>