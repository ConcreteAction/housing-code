<!DOCTYPE html>

<html>
<head>
<title>Regeneration Data Store | Pages | Sidebar Left</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="/layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">

<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
    <div class="fl_left">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-sign-in"></i> <a href="#">Login</a></li>
        <li><i class="fa fa-user"></i> <a href="#">Register</a></li>
      </ul>
    </div>
    <div class="fl_right">
      <form class="clear" method="post" action="#">
        <fieldset>
          <legend>Search:</legend>
          <input type="search" value="" placeholder="Search Here&hellip;">
          <button class="fa fa-search" type="submit" title="Search"><em>Search</em></button>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<div class="wrapper row1">
  <header id="header" class="hoc clear"> 

    <div id="logo" class="fl_left">
      <h1><a href="../../../../index.html">Regeneration Data Store</a></h1>
      <i class="fa fa-map-o"></i>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.html">Home</a></li>
        <li><a class="drop" href="#">Locations</a>
          <ul>
            <li><a href="#">Barking and Dagenham</a></li>
            <li><a href="#">Barnet</a></li>
            <li><a href="#">Bexley</a></li>
            <li><a href="#">Brent</a></li>
            <li><a href="#">Bromley</a></li>
            <li><a href="#">Camden</a></li>
            <li><a href="#">City of London</a></li>
            <li><a href="#">Croydon</a></li>
            <li><a href="#">Ealing</a></li>
            <li><a href="#">Enfield</a></li>
            <li><a href="#">Greenwich</a></li>
            <li><a href="#">Hackney</a></li>
            <li><a href="#">Hammersmith and Fulham</a></li>
            <li><a href="#">Harrow</a></li>
            <li><a href="#">Havering</a></li>
            <li><a href="#">Hillingdon</a></li>
            <li><a href="#">Hounslow</a></li>
            <li><a href="#">Islington</a></li>
            <li><a href="#">Kensington and Chelsea</a></li>
            <li><a href="#">Kingston upon Thames</a></li>
            <li><a href="#">Lambeth</a></li>
            <li><a href="#">Lewisham</a></li>
            <li><a href="#">Merton</a></li>
            <li><a href="#">Newham</a></li>
            <li><a href="#">Richmond upon Thames</a></li>
            <li><a href="#">Southwark</a></li>
            <li><a href="#">Tower Hamlets</a></li>
            <li><a href="#">Waltham Forest</a></li>
            <li><a href="#">Wandsworth</a></li>
            <li><a href="#">Westminster</a></li>
          </ul>
        </li>
        <li><a class="drop" href="#">National Data</a>
          <ul>
            <li><a href="national_data.php">Regulations</a></li>
            <li><a href="#">Example</a></li>
          </ul>
        </li>
        <li><a href="pages/upload.php">Upload Data</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>

  </header>
</div>

<div class="wrapper bgded overlay" style="background-image:url('../../../../../images/demo/backgrounds/01.png');">
  <div id="breadcrumb" class="hoc clear"> 

    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">National Data</a></li>
      <li><a href="#">Regulations</a></li>
    </ul>

  </div>
</div>

<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->


    <div class="sidebar one_quarter first"> 

      <h6>National Data</h6>
      <nav class="sdb_holder">
        <ul>
          <li><a href="mainstream.php">Main-Stream Media</a></li>
        </ul>
      </nav>

    </div>

    <div class="content three_quarter"> 

      <h1>National Data</h1>
      <h1>Regulations</h1>

      <?php
      $json = file_get_contents("https://www.gov.uk/api/search.json?q=regeneration+regulations");

      $json_decoded = json_decode($json);
      #var_dump($json_decoded);

      $info = array();
      
      foreach($json_decoded->results as $value){
        $info[] = $value;
      }
      #var_dump($info);
      for ($i = 0; $i < count($info); $i++) {
        $a = $info[$i]->description;
        #var_dump($a)
        $strLength = strlen($a);
        $pos = strpos(strtolower($a), "regulations");
        $pos2 = strpos(strtolower($a), "regeneration");

        date_default_timezone_set("Europe/London");
        $time = (!empty($info[$i]->public_timestamp)) ? $info[$i]->public_timestamp : "" ;
        if ($time != "") {
          $dateInfo = date_parse($info[$i]->public_timestamp);
        } else {
          $dateInfo = "";
        }

        if ($pos OR $pos2 == true) {
          echo "<p>" . $a . "</h1>";
          $dateStr = (!empty($info[$i]->public_timestamp)) ? $info[$i]->public_timestamp : "";
          echo "<p>Link is <a href='https://gov.uk" . $info[$i]->link . "'>here</a>";
          if ($dateInfo != "") {
            echo "<p> Published Date: " . $dateInfo['day'] . " " . date("F", strtotime($dateStr)) . " " . $dateInfo['year'] . "</p>";
                  
          } else {
            echo "<p> ";
          }
        }
      }
      ?>
    </div>


    <!-- / main body -->
    <div class="clear"></div>

    <h1>                      <h1>
  </main>
</div>

</div>

<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 

    <div class="one_third first">
      <h6 class="title">Company Name</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
          Street Name &amp; Number, Town, Postcode/Zip
          </address>
        </li>
        <li><i class="fa fa-phone"></i> +00 (123) 456 7890<br>
          +00 (123) 456 7890</li>
        <li><i class="fa fa-fax"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> info@domain.com</li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="title">News Arcticles</h6>
      <ul class="nospace linklist">
        <li><a href="#">Example</a></li>
        <li><a href="#">Example</a></li>
        <li><a href="#">Example</a></li>
        <li><a href="#">Example</a></li>
        <li><a href="#">Example</a></li>
      </ul>
    </div>
    <div class="one_third">
      <h6 class="title">Register for Information in your area</h6>
      <form method="post" action="#">
        <fieldset>
          <legend>Newsletter:</legend>
          <input class="btmspace-15" type="text" value="" placeholder="Name">
          <input class="btmspace-15" type="text" value="" placeholder="Email">
          <input class="btmspace-15" type="text" value="" placeholder="Postcode">
          <button type="submit" value="submit">Submit</button>
        </fieldset>
      </form>
    </div>

  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 

    <p class="fl_left">Copyright &copy; 2017 <a href="#">Kieran Amrane-Rendall</a></p>
  </div>
</div>


<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../../../layout/scripts/jquery.min.js"></script>
<script src="../../../layout/scripts/jquery.backtotop.js"></script>
<script src="../../../layout/scripts/jquery.mobilemenu.js"></script>

<script src="../../../layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>