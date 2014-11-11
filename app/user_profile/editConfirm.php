<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
          include("../common/process_DB.php");
          if (!isset($_SESSION["Email"])){
            printAlert("danger", "You haven't sign in yet!", "../../../index.php");
            exit;
          }
        	$userEmail = $_SESSION["Email"];
	        $hotelName = $_POST['HotelName'];
          $hotelAddr = $_POST['HotelAddr'];
          $value = $_POST['RoomType'];
          $value = explode(":", $value);
	        $roomType = $value[0];
          $roomPrice = $value[1];
	        $startDate = $_POST['StartDate'];
	        $endDate = $_POST['EndDate'];
          //old information
          $oldRoomType = $_POST['oldRoomType'];
          $oldRoomQuant = $_POST['oldRoomQuant'];
          $oldStartDate = $_POST['oldStartDate'];
          $oldEndDate = $_POST['oldEndDate'];

          $oldDays = abs(strtotime($oldStartDate) - strtotime($oldEndDate))/(60*60*24) + 1;
          $days = abs(strtotime($startDate) - strtotime($endDate))/(60*60*24) + 1;
          $bookingID = sha1($startDate.$endDate);
          $quantity = $_POST['RoomQuant'];
          $total = (int)$roomPrice * (int)$quantity * (int)$days;
          $oldTotal = (int)$roomPrice * (int)$oldRoomQuant * (int)$oldDays;
          $conn = fakeDeleteBooking($userEmail,$hotelName, $hotelAddr, $oldRoomType, $oldRoomQuant, $oldStartDate, $oldEndDate);
          $result = fakeInsertBooking($userEmail,$hotelName, $hotelAddr, $roomType, $startDate, $endDate, $quantity, $total, $conn);
          if ($result) printAlert("success", "Booking Confirmed!!!", "../user_profile/index.php");
          else printAlert("danger", "Booking Failed!!!", "../../../index.php");
        ?>

        <div class="container">
          <table class='table'>
            <tr>
              <td>hotel name</td>
              <td><?php echo $hotelName;?></td>
            </tr>
            <tr>
              <td>room type</td>
              <td><?php echo "$oldRoomType => $roomType";?></td>
            </tr>
            <tr>
              <td>room quantity</td>
              <td><?php echo "$oldRoomQuant => $quantity";?></td>
            </tr>
            <tr>
              <td>price</td>
              <td><?php echo $roomPrice;?></td>
            </tr>
            <tr>
              <td>check in date</td>
              <td><?php echo "$oldStartDate => $startDate";?></td>
            </tr>
            <tr>
              <td>check out date</td>
              <td><?php echo "$oldEndDate => $endDate";?></td>
            </tr>
            <tr>
              <td>days </td>
              <td><?php echo "$oldDays=>$days";?></td>
            </tr>
            <tr>
              <td>total</td>
              <td><?php echo "$oldTotal=>$total";?></td>
            </tr>
            <tr>
              <td>booking ID</td>
              <td><?php echo $bookingID;?></td>
            </tr>
          </table>
        </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="../../public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="holder.js"></script>
  </body>
</html>

