<?php

  include "../common/process_DB.php";
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
    require "../common/redirect_home.php";
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="favicon.ico">-->

    <title>Hotel Booking System</title>

    <!-- Bootstrap core CSS --> 
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- date picker -->
    <link href="../../public/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Main jumbotron for a primary marketing message or call to action -->
        <?php
          if (!isset($_SESSION["Email"])){
            printAlert("danger", "You haven't sign in yet!", "../../../index.php");
            exit;
          }
          if (!empty($_POST['SignInEmail']) || isset($_SESSION["User"])){
            if (!isset($_SESSION["User"])){
              $result = selectCustomer();
              $_SESSION["User"] = $result;
              $_SESSION["Email"] = $_POST['SignInEmail'];
              if($result) {
                printNavbar($result);
                printAlert("success", "Sign In Successfully!", "index.php");
              }
              else{
                printNavbar($result);
                printAlert("danger", "Invalid email or password!","index.php");
              }
            }else{
              $result = $_SESSION["User"];
              printNavbar($result);
            }
          }else{
            printNavbar(false);
          }
          print '</div>';
        //if(isset($_SESSION["Email"])){
        	$userEmail = $_SESSION["Email"];
	        $hotelName = $_GET['HotelName'];
	        $hotelAddr = $_GET['HotelAddr'];
	        //can be change, before confirmation
	        $roomTypes = $_GET['RoomType'];
          $values = explode(" ",$roomTypes);
          $quantLeft = $values[2];
          $roomType = $values[0];
          $roomPrice = getPrice($hotelName, $hotelAddr, $roomType);
	        $startDate = $_GET['StartDate'];
	        $endDate = $_GET['EndDate'];
	        //left is room quantity
	    //}

        ?>
        <div class="container theme-showcase" role="main">
          <div class="jumbotron">
            <a><h4>Booking information:</h4></a>
            <hr>
            <div class="container">

	        	<form action="confirm.php" class="form-signin" role="form" method="post">
              <?php
                echo "
                <input type='hidden' name='HotelAddr' value='$hotelAddr' />"
              ?>
		            <div class="row">
		              <div class="col-md-4">
                    <label>Hotel Name:</label>
                    <?php
		                  echo "<input type=\"text\" name=\"HotelName\" class=\"form-control input-lg\" value=\"$hotelName\" readonly>";
		                ?>
                  </div>
                  <div class="col-md-4">
                    <label>Roon Type:</label>
                    <?php
                      echo "<input type=\"text\" name=\"RoomType\" class=\"form-control input-lg\" value=\"$roomType\" readonly>";
                    ?>
                  </div>
                  <div class="col-md-4">
                    <label>Price ($SGD/day):</label>
                    <?php
                      echo "<input type=\"text\" name=\"RoomPrice\" class=\"form-control input-lg\" value=\"$roomPrice\" readonly>";
                    ?>
                  </div>
		            </div>

                <div class="row">
                  <div class="col-md-12">
                    <label>Hotel Address:</label>
                    <div class="well"><?php echo $hotelAddr; ?></div>
                  </div>
                </div>

		            <div class="row">
	                <div class='col-md-6'>
	                  <label>Check In Date:</label>
	                  <div class='input-group date' id='datetimepicker9'>
                      <?php
                        echo "<input type=\"text\" name=\"StartDate\" value=\"$startDate\" class=\"form-control\" readonly/>";
                      ?>
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                  </div>
	                </div>
	                <div class='col-md-6'>
	                  <label>Check Out Date:</label>
	                  <div class='input-group date' id='datetimepicker10'>
                      <?php
                        echo "<input type=\"text\" name=\"EndDate\" value=\"$endDate\" class=\"form-control\" readonly/>";
                      ?>
	                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
	                      </span>
	                  </div>
	                </div>
  		          </div>
                <hr>

                <div class="row">
                  <div class='col-md-4'>
                    <label>Room Quantity:</label>
                    <select class="form-control" name="Quantity">
                      <?php
                        $i = 1;
                        while($i <= (int)$quantLeft){
                  echo "<option>$i</option>";
                          $i += 1;
                        }
                      ?>
                    </select>
                  </div>
                  <div class='col-md-4'>
                  </div>
                  <div class='col-md-4'>
                    <label>&nbsp;</label>
                    <button class="btn btn-primary btn-block" type="submit">Confirm</button>
                  </div>
                </div>




            </div>
          </div>
        </div>

   	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="../../public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../public/js/moment.js"></script>
    <script type="text/javascript" src="../../public/js/transition.js"></script>
    <script type="text/javascript" src="../../public/js/collapse.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker9').datetimepicker({
              pickTime: false,
              pickDate: false
            });
            $('#datetimepicker10').datetimepicker({
              pickTime: false,
              pickDate: false
            });
            $('#datetimepicker9').data("DateTimePicker").setMinDate(new Date());
            $('#datetimepicker9').data("DateTimePicker").setMaxDate(new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000));
            $('#datetimepicker10').data("DateTimePicker").setMinDate(new Date());
            $('#datetimepicker10').data("DateTimePicker").setMaxDate(new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000));
            
            $("#datetimepicker9").on("dp.change",function (e) {
               $('#datetimepicker10').data("DateTimePicker").setMinDate(e.date);
            });
            $("#datetimepicker10").on("dp.change",function (e) {
               $('#datetimepicker9').data("DateTimePicker").setMaxDate(e.date);
            });

        });
    </script>
    <script type="text/javascript" src="holder.js"></script>
  </body>
</html>
