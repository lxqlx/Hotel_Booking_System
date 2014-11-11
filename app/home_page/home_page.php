<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  if (isset($_SESSION['email']) and $_SESSION['email'] === 'admin@hotelbooking'){
    if(isset($_POST['Customer'])){
      $values = explode(":",$_POST['Customer']);
      $_SESSION['User'] = "admin=>".$values[1];
      $_SESSION['Email'] = $values[0];
    }
  }
  if (isset($_POST["logOut"])){
    session_unset();
    session_destroy();
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
    <link href="public/css/bootstrap.min.css" rel="stylesheet"> 
	  <!-- date picker -->
    <link href="public/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
    <!--link href="app/home_page/home_page.css" rel="stylesheet"-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Main jumbotron for a primary marketing message or call to action -->
        <?php
          include("process_DB.php");
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
          $today = date('m/d/Y');
        ?>


    <div class="container theme-showcase" role="main">
      <div class="jumbotron">

        <hr>
        <div class="container">

          <form action="app/search_result/index.php" class="form-signin" role="form" method="get">
            <div class="row">
              <div class="col-md-6">
                <label>Location:</label>
                <input type="text" name="Location" class="form-control" placeholder="Location Name e.g. Singapore" autofocus>
              </div>
              <div class="col-md-6">
                <label>Hotel Name:</label>
                <input type="text" name="HotelName" class="form-control" placeholder="Hotel Name e.g. PGP" autofocus>
              </div>
            </div>


            <hr>
            <div class="row">
              <div class='col-md-6'>
                <label>Check In Date:</label>
                <div class='input-group date' id='datetimepicker9'>
                  <input type='text' name="StartDate" placeholder="mm/dd/yyyy" class="form-control" value=<?php echo "'$today'";?> required/>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              <div class='col-md-6'>
                <label>Check Out Date:</label>
                <div class='input-group date' id='datetimepicker10'>
                    <input type='text' name="EndDate" placeholder="mm/dd/yyyy" class="form-control" value=<?php echo "'$today'";?> required/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
          </div>
		  <hr>

		   <div class="panel-group" role="tablist">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                    Advanced Options >>
                  </a>
                </h4>
              </div>
              <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1">
                
                <ul class="list-group">
        					<li class="list-group-item">
            			  <label>Room Type</label>
            			  <div class="checkbox">
            			    <label>
            			      <input type="checkbox" name="SingleRoom" value="Single"> 1 <span class="glyphicon glyphicon-user"></span>
            			    </label>
            			    <label>
            			      <input type="checkbox" name="DoubleRoom" value="Double"> 2 <span class="glyphicon glyphicon-user"></span>
            			    </label>
            			    <label>
            			      <input type="checkbox" name="TripleRoom" value="Triple"> 3 <span class="glyphicon glyphicon-user"></span>
            			    </label>
            			  </div>
            			</li>

                  <li class="list-group-item">
                    <label>Rating</label>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="ThreeStar" value="3"> 3 <span class="glyphicon glyphicon-star"></span>
                      </label>
                      <label>
                        <input type="checkbox" name="FourStar" value="4"> 4 <span class="glyphicon glyphicon-star"></span>
                      </label>
                      <label>
                        <input type="checkbox" name="FiveStar" value="5"> 5 <span class="glyphicon glyphicon-star"></span>
                      </label>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <label>Facilities</label>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="Restaurant" value="1"> Restaurant
                      </label>
                      <label>
                        <input type="checkbox" name="Airport" value="2"> Airport Shuttle
                      </label>
                      <label>
                        <input type="checkbox" name="Parking" value="3"> Parking
                      </label>
                      <label>
                        <input type="checkbox" name="Wifi" value="4"> Wi-Fi
                      </label>
                      <label>
                        <input type="checkbox" name="Swimming" value="5"> Swimming Pool
                      </label>
                      <label>
                        <input type="checkbox" name="Fitness" value="6"> Fitness Club
                      </label>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <label>Price Range($SGD/Day):</label>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="Range1" value="0"> Below 100&nbsp;
                      </label>
                      <label>
                        <input type="checkbox" name="Range2" value="100"> 100-300
                      </label>
                      <label>
                        <input type="checkbox" name="Range3" value="300"> 300-500&nbsp;
                      </label>
                      <label>
                        <input type="checkbox" name="Range4" value="500"> 500-800&nbsp;
                      </label>
                      <label>
                        <input type="checkbox" name="Range5" value="800"> Above 800&nbsp;
                      </label>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>




          <div class="row">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
          </div>
          </form>

        </div>
      </div>
    </div>

   	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="public/js/moment.js"></script>
    <script type="text/javascript" src="public/js/transition.js"></script>
    <script type="text/javascript" src="public/js/collapse.js"></script>
    <script type="text/javascript" src="public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/js/bootstrap-datetimepicker.js"></script>
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
  </body>
</html>
