<?php

// load medoo for database object
// configure medoo.min.php for proper database connection
require_once 'movies_script.php';

if (isset($_POST['search'])) {

    // some sanitizing of the user input
    $user_date = strip_tags(trim($_POST['date']));

    // make sure date is in the right format for the query
    $convert_date   = strtotime($user_date);
    $converted_date = date("Y-m-d", $convert_date);
    unset($top10Movies);

    $query = $db->select("movies", [

            "imdb_id",
            "rank",
            "rating",
            "title",
            "year",
            "number_of_votes"

        ], [
            "date_added" => $converted_date
        ]);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>IMDb Parser - Top 10 Movies</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">IMDb.com Top 10 Database</a>
        </div>
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
      <div class="row">
      <div class="col-lg-12">
        <h1>Welcome.</h1>
        <p>Simple PHP that parses http://www.imdb.com/chart/top for the top 10 movies.</p>
        <p>Below you can search the database by date. Enter in any format - example: 1990-12-12, september 10 2014, 12-12-2014</p>
        <form class="form" role="search" method="post" action="" id="searchform">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="date">
            <div class="input-group-btn">
                <input class="btn btn-default" value="search" name="search" type="submit"/>
            </div>
        </div>
        </form>
      </div>

      </div>

      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->

      <div class="row">
      <div class="col-lg-12">

          <table class="table">
                <thead>
                    <tr>
                        <th>
                            Rank
                        </th>
                        <th>
                            Rating
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Year
                        </th>
                        <th>
                            Votes
                        </th>
                    </tr>
                </thead>

                <tbody>
                      <?php
                      if (isset($_POST['search']) && count($query) > 0) {
                        foreach ($query as $result) {

                                echo '
                                                          <tr class=\"active\">
                                                          <td>
                                                             '.$result['rank'].'
                                                          </td>
                                                          <td>
                                                           '.$result['rating'].'
                                                          </td>
                                                          <td>
                                                           '.$result['title'].'
                                                          </td>
                                                          <td>
                                                           '.$result['year'].'
                                                          </td>
                                                          <td>
                                                          '.$result['number_of_votes'].'
                                                          </td>
                                                          </tr>
                                                          ';
                        }

                      } elseif (isset($_POST['search']) && count($query) == 0) {

                                echo '

                                                    <div class="alert alert-warning">
                                                    No data found, check back in a few days.
                                                    </div>

                                                    ';
                      } else {
                        if (!isset($_POST['search'])) {
                            foreach ($top10Movies as $movie) {
                                
                                echo '
                                                                <tr class=\"active\">
                                                                <td>
                                                                   '.$movie->getRank().'
                                                                </td>
                                                                <td>
                                                                 '.$movie->getRating().'
                                                                </td>
                                                                <td>
                                                                 '.$movie->getTitle().'
                                                                </td>
                                                                <td>
                                                                 '.$movie->getYear().'
                                                                </td>
                                                                <td>
                                                                '.$movie->getVotes().'
                                                                </td>
                                                                </tr>
                                                                ';
                            }
                        }
                      }
                      ?>
                </tbody>
            </table>

      </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Anton Bacaj - 2014</p>
      </footer>
    </div> <!-- /container -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
