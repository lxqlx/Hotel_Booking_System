<?php

  include("../common/process_DB.php");
  if (session_status() == PHP_SESSION_NONE) { 
    session_start();
  }
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
    require "../common/redirect.php";
    exit;
  }

  $userEmail = $_SESSION["Email"];
  $hotelName = $_POST['HotelName'];
  $hotelAddr = $_POST['HotelAddr'];
  //can be change, before confirmation
  $roomType = $_POST['RoomType'];
  $roomQuant = $_POST['RoomQuant'];
  $roomPrice = getPrice($hotelName, $hotelAddr, $roomType);
  $startDate = $_POST['StartDate'];
  $endDate = $_POST['EndDate'];
  $oldStartDate = $_POST['OldStartDate'];
  $oldEndDate = $_POST['OldEndDate'];

  
  // if($conn){
  //   echo "deleted!!!!";
  //   $RTypes = getRoomTypes($hotelName, $hotelAddr,$conn);
  // }
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

  <body onload="Box2(0);">
    <!-- Main jumbotron for a primary marketing message or call to action -->
        <?php
          if (!isset($_SESSION["Email"])){
            printAlert("danger", "You haven't sign in yet!", "../../../index.php");
            exit;
          }
          if (!empty($_POST['SignInEmail']) || isset($_SESSION["User"])){
            if (!isset($_SESSION["User"])){
              $result = selectCustomer();
            }else{
              $result = $_SESSION["User"];
            }

            if ($result){
              if (!isset($_SESSION["User"])) {
                  $_SESSION["User"] = $result;
                  $_SESSION["Email"] = $_POST['SignInEmail'];
              }
              printNavbar($result);
              printAlert("success", "Sign In Successfully!", "index.php");
            }else{

              printNavBar($result);
              printAlert("danger", "Invalid email or password!");
            }
          }
          else{
            printNavbar($result);
            printAlert("danger", "You haven't sign in yet!","");
            exit;
          }
        print '</div>';
        // date validation
        $d1 = DateTime::createFromFormat('m/d/Y', $_POST['StartDate']);
        $d2 = DateTime::createFromFormat('m/d/Y', $_POST['EndDate']);
        if(!$d1 || !$d2 ){
          printAlert("danger", "Not Valid Date!","");
          exit;
        }
        if(strtotime($_POST['StartDate']) > strtotime($_POST['EndDate'])){
          printAlert("danger", "Check In Date shouldn't be more than Check Out Date","");
          exit;
        }
        $today = date("m/d/Y");
        $limit =date("m/d/Y", strtotime("+30 day", strtotime($today)));
        if(strtotime($_POST['EndDate']) > strtotime($limit)){
          printAlert("danger", "Not Ready to be Booked!","");
          exit;
        }
        //if(isset($_SESSION["Email"])){
        $conn = fakeDeleteBooking($userEmail,$hotelName, $hotelAddr, $roomType, $roomQuant, $oldStartDate, $oldEndDate);
        $RTypes = getRoomTypes($hotelName, $hotelAddr, $startDate, $endDate, $conn);
        
	        //left is room quantity
	    //}

        ?>
        <div class="container theme-showcase" role="main">
          <div class="jumbotron">
            <a><h4>Booking information:</h4></a>
            <hr>
            <div class="container">

	        	<form name="myform" action="editConfirm.php" class="form-signin" role="form" method="post">
              <?php
                echo "
                <input type='hidden' name='HotelAddr' value='$hotelAddr' />"
              ?>
		            <div class="row">
                  <div class="col-md-12">
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
                    <?php echo "($oldStartDate)"; ?>
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
                    <?php echo "($oldEndDate)"; ?>
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
                    <label>Room Type:</label>
                    <?php echo "($roomType)";?>
                      <select class="form-control" name="RoomType" id="RoomType" onchange="Box2(this.selectedIndex)">
                        <?php
                          foreach ($RTypes as $RType){  
                            $t = $RType[0];
                            $p = $RType[1];
                            $i = $t.":".$p;
                            echo "<option>$i</option>";
                          }
                        ?>
                      </select>
                  </div>
                  <div class='col-md-4'> 
                    <label>Room Quantity:</label>
                    <?php echo "($roomQuant)";?>
                      <select class="form-control" name="RoomQuant" id="RoomQuant">

                      </select>
                  </div>
                  <div class='col-md-4'>
                    <label>&nbsp;</label>
                    <?php
                      echo "<input type='hidden' name='oldStartDate' value='$oldStartDate' />";
                      echo "<input type='hidden' name='oldEndDate' value='$oldEndDate' />";
                      echo "<input type='hidden' name='oldRoomType' value='$roomType' />";
                      echo "<input type='hidden' name='oldRoomQuant' value='$roomQuant' />";
                    ?>
                    <button class="btn btn-primary btn-block" type="submit">Confirm Update</button>
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
    <script type="text/javascript">
      <?php
        echo "var varieties=[";
        foreach ($RTypes as $RType) {
          echo "[";
          $i = 1;
          while($i < $RType[2]){
            echo "'$i',";
            $i += 1;
          }
          if($RType !== end($RTypes)) echo "'$i'],";
          else echo "'$i']";
        }
        echo "];";
      ?>

      function Box2(idx) {
        var f=document.myform;
        f.RoomQuant.options.length=null;
        for(var i=0; i<varieties[idx].length; i++) {
            f.RoomQuant.options[i]=new Option(varieties[idx][i], i+1); 
            }
      }
    </script>

    
    <script type="text/javascript" src="holder.js"></script>
  </body>
</html>
