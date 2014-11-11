<?php
  if (session_status() == PHP_SESSION_NONE) { 
    session_start();
  }
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
    require "../common/redirect.php";
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

    <title>Hotel Booking Admin System</title>

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
          include("../common/process_DB.php");
          if (!isset($_SESSION["email"]) or $_SESSION["email"] !== 'admin@hotelbooking'){
            printAlert("danger", "Permission Denied!!!", "../../index.php");
            exit;
          }
          $admin = $_SESSION['email'];
          //
          print
            '
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Hotel Booking Admin</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form action="index.php" class="navbar-form navbar-right" role="form" method="post">';
        print "<a href=\"index.php\"> ".$admin."</a>";
        print
            '<a>&nbsp;</a>
            <button name="logOut" value="out" class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-log-out"></span> Log Out</button>
            </form>
          </div><!--/.navbar-collapse -->
        </div>
      </nav>
      <div class="jumbotron">
      </div>
      ';
        //if(isset($_SESSION["Email"])){
        	$userEmail = $_GET["UserEmail"];
	        $hotelName = $_GET['HotelName'];
	        $hotelAddr = $_GET['HotelAddr'];
	        //can be change, before confirmation
	        $roomType = $_GET['RoomType'];
          $roomQuant = $_GET['RoomQuant'];
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


	        	<form action="edit2.php" class="form-signin" role="form" method="post">
              <?php
                echo "
                <input type='hidden' name='HotelAddr' value='$hotelAddr' />
                <input type='hidden' name='HotelQuant' value='$hotelQuant' />
                <input type='hidden' name='OldStartDate' value='$startDate' />
                <input type='hidden' name='OldEndDate' value='$endDate' />
                <input type='hidden' name='RoomType' value='$roomType' />
                <input type='hidden' name='RoomQuant' value='$roomQuant' />";
              ?>
		            <div class="row">
                  <div class="col-md-6">
                    <label>User Email:</label>
                    <?php
                      echo "<input type=\"text\" name=\"UserEmail\" class=\"form-control input-lg\" value=\"$userEmail\" readonly>";
                    ?>
                  </div>
                  <div class="col-md-6">
                    <label>Hotel Name:</label>
                    <?php
		                  echo "<input type=\"text\" name=\"HotelName\" class=\"form-control input-lg\" value=\"$hotelName\" readonly>";
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
                        echo "<input type=\"text\" name=\"StartDate\" value=\"$startDate\" class=\"form-control\" required/>";
                      ?>
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                  </div>
	                </div>
	                <div class='col-md-6'>
	                  <label>Check Out Date:</label>
	                  <div class='input-group date' id='datetimepicker10'>
                      <?php
                        echo "<input type=\"text\" name=\"EndDate\" value=\"$endDate\" class=\"form-control\" required/>";
                      ?>
	                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
	                      </span>
	                  </div>
	                </div>
  		          </div>
                <hr>

                <div class="row">
                  <div class='col-md-4'>
                  </div>
                  <div class='col-md-4'>
                  </div>
                  <div class='col-md-4'>
                    <label>&nbsp;</label>
                  </div>
                    <button class="btn btn-primary btn-block" type="submit">Change Dates</button>
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
              pickTime: false
            });
            $('#datetimepicker10').datetimepicker({
              pickTime: false
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
