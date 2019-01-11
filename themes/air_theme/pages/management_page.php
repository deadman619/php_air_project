<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tables </title>

    <!-- Bootstrap -->
    <link href="management/themes/management_theme/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="management/themes/management_theme/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="management/themes/management_theme/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
   <link href="management/themes/management_theme/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="management/themes/management_theme/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Database Tables</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <!-- FLIGHTS TABLE -->

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Flights<small>Edit the flight database</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="table-responsive">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Flight</th>
                          <th>Description</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Delete</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php displayFlights($conn); ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
                  </div>
                </div>

                <!-- CATEGORY TABLE --> 


            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Categories<small>A list of available flight categories</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="table-responsive">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Category Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php displayCategories($conn); ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="management/themes/management_theme/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="management/themes/management_theme/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="management/themes/management_theme/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="management/themes/management_theme/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="management/themes/management_theme/vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="management/themes/management_theme/build/js/custom.min.js"></script>
  </body>
</html>