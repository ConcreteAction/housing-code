<?php

date_default_timezone_set("Europe/London");
$response = [];
$results = [];
$start = null;
$city = null;

if(isset($_POST['start'], $_POST['city']) && !empty($_POST['start']) && !empty($_POST['city']) && is_numeric($_POST['start'])){

	$start = $_POST['start'];
	$city = $_POST['city'];

	$curl = file_get_contents("https://www.gov.uk/api/search.json?q=$city&start=$start");
	
	$response_decode = json_decode($curl);
	#var_dump($curl);
	for($i = 0; $i < count($response_decode->results); $i++){

		//Build your results here

		if (!empty($response_decode->results[$i]->title)){
			$title = $response_decode->results[$i]->title;
		} else {
			$title = 'No Title';
		}

		
	    $item = '<div class="item"><p> ' .$title. ' </p></div>';

	    // Find city occurence in description before adding to results array

	    $strLength = strlen($description);
      	$pos = strpos(strtolower($description), "regeneration");
      	#$pos2 = strpos(strtolower($description), "southwark");
	    #$occurence2 = strpos(strtolower($description), strtolower($keyword));
	    if($pos !== false) {
	    	$results[] = $item;
	    }
	    
	   
	}

	$start = $start + 20;

	$response = ["success" => true, "message" => $results, "end" => $start];
} else {
	$response = ["success" => false, "message" => "Couldn't fetch data"];
}

echo json_encode($response);

?>