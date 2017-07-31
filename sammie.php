<!DOCTYPE html>
<html>
<head>
  <title>Sammie</title>
  <style type="text/css">
    
    .item {
      border: 2px solid #222;
      padding: 10px;
      margin-bottom: 5px;
    }

    #loading {
      padding: 20px 0;
      font-weight: 700;
      color: red;
    }

  </style>
</head>
<body>

<?php 
  session_start(); 
  $_SESSION["incrementURL"] = ((isset($_SESSION["incrementURL"])) ? $_SESSION["incrementURL"] : 0);
?>

<?php

    $incrementURL = $_SESSION["incrementURL"];
    $json = file_get_contents("https://www.gov.uk/api/search.json?q=regeneration&start=$incrementURL");

    $json_decoded = json_decode($json);
    //var_dump($json_decoded);

    $info = array();
    
    foreach($json_decoded->results as $value){
      $info[] = $value;
    }
    
    for ($i = 0; $i < count($info); $i++) {
      //var_dump($a)

      date_default_timezone_set("Europe/London");
      $time = (!empty($info[$i]->public_timestamp)) ? $info[$i]->public_timestamp : "" ;
      if ($time != "") {
        $dateInfo = date_parse($info[$i]->public_timestamp);
      } else {
        $dateInfo = "";
      }

      $decriptionI = (!empty($info[$i]->description)) ? $info[$i]->description : "" ;
      if ($decriptionI != "") {
        $a = $info[$i]->description;
      } else {
        $a = "";
      }
      $strLength = strlen($a);
      $pos = strpos(strtolower($a), "regeneration");
      #$pos2 = strpos(strtolower($a), " ");

      if ($pos !== false) {

        echo '<div class="item">';

        if ($a != "") {
          echo "<p>" . $a . "</h1>";
        } else {
          echo "<p> no description";
        }
        $dateStr = (!empty($info[$i]->public_timestamp)) ? $info[$i]->public_timestamp : "";
        echo "<p>Link is <a href='https://gov.uk" . $info[$i]->link . "'>here</a>";

        if ($dateInfo != "") {
          echo "<p> Published Date: " . $dateInfo['day'] . " " . date("F", strtotime($dateStr)) . " " . $dateInfo['year'] . "</p>";
                
        } else {
          echo "<p> ";
        }

        echo '</div>';

      } else {
        echo '<div class="item"><p> </p></div>';

      }
    }

  ?>
<div id="container" class="container">
  
</div>
<p id="loading" style="display: none">Loading More...</p>
    
<!-- Javascript Libraries, loaded Via CDN (JQUERY && INFINITE-SCROLL) -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script> -->
<script type="text/javascript">

  // Wrapper content
  var container = document.getElementById('container');
  var loading = document.getElementById('loading');
  var start = 20;

  // Prevent sending ajax multiple requests
  var requesting = false;

  
  function loadMore(city){

    requesting = true;
    toggleProgress();

    if(window.XMLHttpRequest){
        var xmlhttp = new XMLHttpRequest();
    } else {
      var xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    xmlhttp.onreadystatechange = function(){

      if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

        var response = JSON.parse(xmlhttp.responseText);

        if(response.success){

          if(response.message.length > 0){
             container.innerHTML += response.message;
           } else {
            //container.innerHTML += '<div class="item"><p>Still no result</p></div>';

               loadMore("regeneration");

           }

          start = response.end;

        } else {
          
        }

        requesting = false;
        toggleProgress();
      }
    }

    var data = new FormData();
    data.append("start", start);
    data.append("city", city);

    xmlhttp.open('POST', 'sammie-curl.php', true);
    xmlhttp.send(data);
  } 
  
  //toggle loading
  function toggleProgress() {
    if(loading.style.display == 'none'){
      loading.style.display = 'block';
    } else {
      loading.style.display = 'none';
    }
  }

 // window.onload = function(){
  //   if(!requesting){
 //       loadMore("southwark");
//      }
//  }

  // Listening for the scroll event as its being scrolled
  window.onscroll = function(){

    // Height of content
    var containerHeight = container.offsetHeight;

    // User vertical scroll position on page
    var verticalScroll = window.pageYOffset;

    var yAxis = verticalScroll + window.innerHeight;

    if( yAxis >= containerHeight){

      if(!requesting){
        loadMore("regeneration");
      }
    }
  }

</script>
</body>
</html>