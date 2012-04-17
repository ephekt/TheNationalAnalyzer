<?php
header('X-Frame-Options: GOFORIT');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The National</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 10px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .hero-unit {
        padding: 10px;
      }
      #tab {
        margin-bottom: 5px;
      }
      #show_more_info.alert {
        margin-bottom:5px;
      }
      #words {
        font-size:130%;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!-- <link rel="shortcut icon" href="ico/favicon.ico"> -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-30976415-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>

  <body onload="generate_page()">
    <div class="container-fluid">
      <div id="quick_stats" class="alert alert-info">
        The National...
      </div>
      
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav" style="overflow:auto; max-height:400px;">
            <ul id="songs_analyzed" class="nav nav-list" id="sidebar">
              <li class="nav-header">Songs Analyzed</li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        
        <div class="span9">
            <ul id="tab" class="nav nav-tabs">
              <li class="active"><a href="#home" data-toggle="tab">Freq. Analysis</a></li>
              <li class=""><a href="#playing" data-toggle="tab">Now Playing</a></li>
              <li class=""><a href="#generator" data-toggle="tab">Generator</a></li>
            </ul>
          <div id="word_table_container" class="hero-unit">
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade active in" id="home">
                 <table class="table-striped" id="words">
                  <THEAD>
                    <tr>
                      <th>Word</th>
                      <th>Count</th>
                    </tr>
                  </THEAD>
                  <TBODY>
                  </TBODY>
                </table>
              </div>
              <div class="tab-pane fade" id="playing">
                You have to pick a song from the <------ Sidebar first!
              </div>
              <div class="tab-pane fade" id="generator">
                Ready to generate a random song? <a href='#' onClick='generate_verse(); return false;' class='btn'>Generate!</a>
                <br /><br />
                <div id='generated_song'></div>
              </div>
            </div>
          </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; The National Discovery 2012</p>
        <p style="font-size:60%">All content purely here for informational purposes!</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
    <?php    
      if(isset($_GET['tab'])) {
        echo("var SELECTED_TAB='".$_GET['tab']."';");
      }
    ?>
    </script>
    <script src="js/report.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/general.js" type="text/javascript"></script>
    <!-- 
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>

    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    -->
  </body>
</html>

