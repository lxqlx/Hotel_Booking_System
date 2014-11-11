<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
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
    <link href="public/css/slider.css" rel="stylesheet"> 
	  <!-- date picker -->
    <link href="public/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <style>
    #sl2 {
      width: 600px;
  	}
    </style>
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
            }else{
              $result = $_SESSION["User"];
            }

            if ($result){
              if (!isset($_SESSION["User"])) {
                  $_SESSION["User"] = $result;
              }
              printNavbar($result);
              printAlert("success", "Sign In Successfully!","index.php");
            }else{
              printNavBar(false);
              printAlert("danger", "Invalid email or password!","index.php");
            }
          }
          else{
            printNavbar(false);
          }
        print '</div>';
        ?>


    <div class="container theme-showcase" role="main">
      <div class="jumbotron">

        <hr>
        <div class="container">

          <form action="index.php" class="form-signin" role="form" method="post">
            <a>Destination:</a>
            <div class="row">
              <div class="col-md-12">
                <input type="text" name="Destination" class="form-control" placeholder="Destination Name or Hotel Name e.g. Singapore" autofocus>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class='col-md-6'>
                  <i>Check In Date:</i>
                  <div class='input-group date' id='datetimepicker9'>
                    <input type='text' name="checkInDate" placeholder="mm/dd/yyyy" class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class='col-md-6'>
                  <i>Check Out Date:</i>
                  <div class='input-group date' id='datetimepicker10'>
                      <input type='text' name="checkOutDate" placeholder="mm/dd/yyyy" class="form-control" />
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
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
        			  <i>Rating</i>
        			  <div class="checkbox">
        			    <label>
        			      <input type="checkbox" name="threeStar"> 3 <span class="glyphicon glyphicon-star"></span>
        			    </label>
        			    <label>
        			      <input type="checkbox" name="fourStar"> 4 <span class="glyphicon glyphicon-star"></span>
        			    </label>
        			    <label>
        			      <input type="checkbox" name="fiveStar"> 5 <span class="glyphicon glyphicon-star"></span>
        			    </label>
        			  </div>
        			</li>

                  <li class="list-group-item">
                    <i>Rating</i>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="threeStar"> 3 <span class="glyphicon glyphicon-star"></span>
                      </label>
                      <label>
                        <input type="checkbox" name="fourStar"> 4 <span class="glyphicon glyphicon-star"></span>
                      </label>
                      <label>
                        <input type="checkbox" name="fiveStar"> 5 <span class="glyphicon glyphicon-star"></span>
                      </label>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <i>Facilities</i>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="swimming"> Restaurant
                      </label>
                      <label>
                        <input type="checkbox" name="swimming"> Airport Shuttle
                      </label>
                      <label>
                        <input type="checkbox" name="swimming"> Parking
                      </label>
                      <label>
                        <input type="checkbox" name="swimming"> Wi-Fi
                      </label>
                      <label>
                        <input type="checkbox" name="swimming"> Swimming Pool
                      </label>
                      <label>
                        <input type="checkbox" name="fitness"> Fitness Club
                      </label>
                      <label>
                        <input type='text' name="otherFacility" placeholder="others" class="form-control"/>
                      </label>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <i>Price Range</i>
                    <br>
                    <b>$SGD 10</b> <input type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]" id="sl2" > <b>$SGD 1000</b>
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
    <script type="text/javascript" src="public/js/bootstrap-slider.js"></script>
    <script type="text/javascript" src="public/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript">
        $("#sl2").slider({});
        $(function () {
            $('#datetimepicker9').datetimepicker({
              pickTime: false
            });
            $('#datetimepicker10').datetimepicker({
              pickTime: false
            });
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
