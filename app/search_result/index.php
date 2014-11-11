<?php
  include 'search.php';
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
    require "../common/redirect_home.php";
    exit();
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
          }
          else{
            printNavbar(false);
          }
          print '</div>';
      if (!empty($_GET['StartDate']) and !empty($_GET['EndDate'])){
        $d1 = DateTime::createFromFormat('m/d/Y', $_GET['StartDate']);
        $d2 = DateTime::createFromFormat('m/d/Y', $_GET['EndDate']);
        if(!$d1 || !$d2 ){
          printAlert("danger", "Not Valid Date!","");
          exit;
        }
        if(strtotime($_GET['StartDate']) > strtotime($_GET['EndDate'])){
          printAlert("danger", "Check In Date shouldn't be more than Check Out Date","");
          exit;
        }
        $today = date("m/d/Y");
        $limit =date("m/d/Y", strtotime("+30 day", strtotime($today)));
        if(strtotime($_GET['EndDate']) > strtotime($limit)){
          printAlert("danger", "Not Ready to be Booked!","");
          exit;
        }
      }
        $Hsql = "";
        $Tsql = "";
        $startDate = "";
        $endDate = "";
        $startDate = $_GET['StartDate'];
        $endDate = $_GET['EndDate'];
        if(!empty($_POST['StartDate'])){
          $startDate = $_POST['StartDate'];
          $endDate = $_POST['EndDate'];
        }
        $hotelArray = array();
        if(!empty($_POST['Query'])){
          $Hsql = $_POST['Query'];
          $Tsql = $_POST['TQuery'];
          $Newsql = $_POST['Query'];
          $Newsql .=" order by";
          $Newsql .= getOrderStr($_POST['a']);
          $Newsql .= getOrderStr($_POST['b']);
          $Newsql .= getOrderStr($_POST['c']);
          $Newsql .= getOrderStr($_POST['d']);
          $Newsql .= getOrderStr($_POST['e']);
          $Newsql = rtrim($Newsql, ",");
          $hotelArray = selectHotels2($Newsql,$Tsql);
        }else{
          $Hsql = genHotelQuery();
          $Tsql = genRoomTypeQuery('###','***');
          //echo $Hsql;
          $hotelArray = selectHotels($Hsql);
        }
        
        //echo "Here: $Hsql<hr>";
        //echo "Here: $Tsql";
        //echo "$startDate,$endDate";
        // $types = array(
        //     array('A' ,'180','60'),
        //     array('B' ,'280','60'),
        //     array('C' ,'380','60')
        //     );
        // $hotel = array(
        //   'name' =>'Bohua Hotel' , 
        //   'addr' =>'Prince George Park' , 
        //   'ph' => '123-45678',
        //   'rating' =>'3' , 
        //   'types' => $types
        //   );
        // $hotelArray = array($hotel);
        // $Location = $_GET['Location'];
        // $HotelName = $_GET['HotelName'];
        // $StartDate = $_GET['StartDate'];
        // $EndDate = $_GET['EndDate'];
        // $SingleRoom = $_GET['SingleRoom'];
        // $DoubleRoom = $_GET['DoubleRoom'];
        // $TripleRoom = $_GET['TripleRoom'];
        // $location = $_GET['threeStar'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        // $location = $_GET['Location'];
        ?>
        <div class="container theme-showcase" role="main">
          <div class="jumbotron">
            <div class="container">
            <form action="index.php" class="form-signin" role="form" method="post">
              <?php
                
                echo "<input type='hidden' name='Query' value=\"$Hsql\" />";
                echo "<input type='hidden' name='TQuery' value=\"$Tsql\" />";
                echo "<input type='hidden' name='StartDate' value=\"$startDate\"/> ";
                echo "<input type='hidden' name='EndDate' value=\"$endDate\" />";

              ?>
              <div class="row">
                <div class="col-md-3"
                  <a href="index.php"><h3>Search Result:</h3></a>
                </div>
                  <div class="col-md-9">
                    <div class="col-md-2">
                      1.
                      <select class="form-control" name="a">
                        <option>Name</option>
                        <option>Address</option>
                        <option>Rating</option>
                        <option>Price</option>
                        <option>Facility</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      2.
                      <select class="form-control" name="b">
                        <option>--</option>
                        <option>Name</option>
                        <option>Address</option>
                        <option>Rating</option>
                        <option>Price</option>
                        <option>Facility</option>
                      </select>
                    </div>

                    <div class="col-md-2">
                      3.
                      <select class="form-control" name="c">
                        <option>--</option>
                        <option>Name</option>
                        <option>Address</option>
                        <option>Rating</option>
                        <option>Price</option>
                        <option>Facility</option>
                      </select>
                    </div>

                    <div class="col-md-2">
                      4.
                      <select class="form-control" name="d">
                        <option>--</option>
                        <option>Name</option>
                        <option>Address</option>
                        <option>Rating</option>
                        <option>Price</option>
                        <option>Facility</option>
                      </select>
                    </div>

                    <div class="col-md-2">
                      5.
                      <select class="form-control" name="e">
                        <option>--</option>
                        <option>Name</option>
                        <option>Address</option>
                        <option>Rating</option>
                        <option>Price</option>
                        <option>Facility</option>
                      </select>
                    </div>
                  <div class="col-md-2">
                    &nbsp;
                    <button class="btn btn-success btn-block" type="submit">Rank</button>
                  </div>
                </div>
              </div>
              </form>
              <div class="list-group">
                <?php
                  $imgSrc = rand(0,19);
                  foreach ($hotelArray as $hotelInfo) {
                    printListHotel(
                      $hotelInfo['name'],
                      $hotelInfo['addr'],
                      $hotelInfo['ph'],
                      "img/".$imgSrc.".jpg", //img src
                      $hotelInfo['rating'],
                      $hotelInfo['facility'],
                      $hotelInfo['types'],
                      $startDate,
                      $endDate
                      );
                      $imgSrc = ($imgSrc+1)%19;
                  }
                ?>
              </div>


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
