<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>

<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Customer Bookings</div>
<?php
          include("../app/common/process_DB.php");
          if (!isset($_SESSION["email"]) or $_SESSION["email"] !== 'admin@hotelbooking'){
            printAlert("danger", "Permission Denied!!!", "../../index.php");
            exit;
          }

          if(isset($_POST['Delete'])){
            $suc = deleteBooking($_POST["UserEmail"],$_POST['HotelName'],$_POST['HotelAddr'],$_POST['RoomType'],$_POST['RoomQuant'],$_POST['StartDate'],$_POST['EndDate']);
            if($suc){
              printAlert("success", "Deleted", "index.php");
            }else{
              printAlert("failure", "Failed", "index.php");
            }
          }
        	$userEmail = $_SESSION["email"];
          $userName = $_SESSION["user"];
          $userArray = getUsers();
        ?>
      <label>
        Booking History >>
        </a>
      </label>
      <table class='table'>
        <tr class='active'>
          <td>User Email</td>
          <td>Hotel Name</td>
          <td>Address</td>
          <td>Room Type</td>
          <td>Total Price</td>
          <td>Quantity</td>
          <td>Check In Date</td>
          <td>Check Out Date</td>
          <td></td>
          <td></td>
        </tr>
        <?php
            adminPrintBookingHistory();
        ?>
      </table>

      <label class='sucess'>On Going Booking</label>
      <table class='table'>
        <tr class='success'>
          <td>User Email</td>
          <td>Hotel Name</td>
          <td>Address</td>
          <td>Room Type</td>
          <td>Total Price</td>
          <td>Quantity</td>
          <td>Check In Date</td>
          <td>Check Out Date</td>
          <td></td>
          <td></td>
        </tr>
        <?php
            adminPrintBookingCurrent();
        ?>
      </table>
</div>
