<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  if (isset($_SESSION['email']) and $_SESSION['email'] === 'admin@hotelbooking'){
    unset($_SESSION['Email']);
    unset($_SESSION['User']);
    echo "<script>location.href='../admin/index.php'</script>";
    exit;
  }
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
    require '../common/redirect_home.php';
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
          include("../common/process_DB.php");
          if (!isset($_SESSION["User"])){
            printAlert("danger", "You haven't sign in yet!", "index.php");
            exit;
          }
          $result=$_SESSION["User"];
          printNavbar($result);
          print '</div>';

          if(isset($_POST['Delete'])){
            $suc = deleteBooking($_SESSION["Email"],$_POST['HotelName'],$_POST['HotelAddr'],$_POST['RoomType'],$_POST['RoomQuant'],$_POST['StartDate'],$_POST['EndDate']);
            if($suc){
              printAlert("success", "Deleted", "index.php");
            }else{
              printAlert("failure", "Failed", "index.php");
            }
          }
        	$userEmail = $_SESSION["Email"];
          $userName = $_SESSION["User"];
        ?>
        <div class="container theme-showcase" role="main">
          <div class="jumbotron">
            <div class="container"><div class="panel-group" role="tablist">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                  <label>
                    <a class="collapsed" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                      Booking History >>
                    </a>
                  </label>
                </div>
                <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1">
                  <table class='table'>
                    <tr class='active'>
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
                        printBookingHistory($userEmail);
                    ?>
                  </table>
                </div>
              </div>
            </div>
              <label class='sucess'>On Going Booking</label>
              <table class='table'>
                <tr class='success'>
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
                    printBookingCurrent($userEmail);
                ?>
              </table>


            </div>

          </div>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="../../public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="holder.js"></script>
  </body>
</html>

