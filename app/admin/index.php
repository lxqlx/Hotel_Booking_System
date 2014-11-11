<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
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

          if(isset($_POST['Delete'])){
            $suc = deleteBooking($_POST["UserEmail"],$_POST['HotelName'],$_POST['HotelAddr'],$_POST['RoomType'],$_POST['RoomQuant'],$_POST['StartDate'],$_POST['EndDate']);
            if($suc){
              printAlert("success", "Deleted", "index.php");
            }else{
              printAlert("failure", "Failed", "index.php");
            }
          }

          $userArray = getUsers();
        ?>
        <div class="container theme-showcase" role="main">
          <div class="jumbotron">
            <div class="container">
              <form action="../../index.php" class-"form-signin" role="form" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <button class="btn btn-primary btn-block" type="submit">Add booking For</button>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="Customer">
                      <?php
                        foreach ($userArray as $user){
                          echo "<option>$user</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>

            </form>
            <hr>

              <div class="panel-group" role="tablist">
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
                </div>
              </div>
            </div>
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

