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
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
   
   <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Hotel Booking</a>
        </div>
        <div class="navbar-collapse collapse">
          <form action="sign_in.php" class="navbar-form navbar-right" role="form" method="post">
            <div class="form-group">
              <input type="email" name="SignInEmail" placeholder="Email" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="password" name="SignInPassword" placeholder="Password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
      <a href="sign_up.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div> 

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <?php
          include("process_DB.php");
          if (!empty($_POST['SignInEmail'])){
            $result = selectCustomer();
      
            if ($result){
              print
              '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Hotel Booking</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form class="navbar-form navbar-right" role="form">';
                    echo "<a href=\"index.php\"> ".$result."</a>";
                print
                    '<span class="icon-bar"></span>
                    <a href="sign_up.php"><span class="glyphicon glyphicon-user"></span> Log Out</a>
                    </form>
                  </div><!--/.navbar-collapse -->
                </div>
              </div>';
              print "<div class=\"alert alert-success\" role=\"alert\">";
              print "  <a href=\"index.php\" class=\"alert-link\"> <p class=\"text-center\">Sucessful!</p></a>";
              print "</div>";
            }else{
              print 
              '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Hotel Booking</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form action="sign_in.php" class="navbar-form navbar-right" role="form" method="post">
                      <div class="form-group">
                        <input type="email" name="SignInEmail" placeholder="Email" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <input type="password" name="SignInPassword" placeholder="Password" class="form-control" required>
                      </div>
                      <button type="submit" class="btn btn-success">Sign in</button>
                <a href="sign_up.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
                    </form>
                  </div><!--/.navbar-collapse -->
                </div>
              </div>';
              print "<div class=\"alert alert-danger\" role=\"alert\">";
              print "  <a href=\"index.php\" class=\"alert-link\"> <p class=\"text-center\">Invalid email or password!</p></a>";
              print "</div>";
            }
          }
          else{
            print
            '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
              <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Hotel Booking</a>
                </div>
                <div class="navbar-collapse collapse">
                  <form action="sign_in.php" class="navbar-form navbar-right" role="form" method="post">
                    <div class="form-group">
                      <input type="email" name="SignInEmail" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="SignInPassword" placeholder="Password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
              <a href="sign_up.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
                  </form>
                </div><!--/.navbar-collapse -->
              </div>
            </div>

            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="jumbotron">
              <div class="container">
                <h1>Hello, world!</h1>
                <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
              </div>
            </div>

            <div class="container">
              <!-- Example row of columns -->
              <div class="row">
                <div class="col-md-4">
                  <h2>Heading</h2>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-md-4">
                  <h2>Heading</h2>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
               </div>
                <div class="col-md-4">
                  <h2>Heading</h2>
                  <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                  <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
                </div>
              </div>

              <hr>

              <footer>
                <p>&copy; Company 2014</p>
              </footer>
            </div> <!-- /container -->';
          }
        ?>
      </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>