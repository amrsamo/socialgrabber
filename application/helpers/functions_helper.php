<?php 
	
	function printme($x)
	{
		echo '<pre>'.print_r($x,true).'</pre>';
	}


	function exportUsers($users,$filename)
	{
		$date = date("Y/m/d");
		$filename = $filename.'_'.$date;
		$file_ending = "xls";
		// header info for browser
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");
		/*******Start of Formatting for Excel*******/   
		//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
		//start of printing column names as names of MySQL fields

		$keys = array();

		foreach ($users as $user) {
			$user = (array) $user;
			foreach ($user as $key => $value) {
				$keys[] = $key;
			}
			break;
		}

		foreach ($keys as $key) {
			if($key == 'conner')
				continue;
			echo $key. "\t";
		}
		print("\n");    


		foreach ($users as $user) {

			$schema_insert = "";
			foreach ($user as $key => $value) {
				if($key == 'conner')
					continue;
				$value = clean($value);
				$schema_insert .= "$value".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
	        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	        $schema_insert .= "\t";
	        print(trim($schema_insert));
	        print "\n";
		}
		
		exit();
	}


	function clean($string) 
	{
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	function getCoordinates($address){
	    $address = urlencode($address);
	    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
	    $response = file_get_contents($url);
	    $json = json_decode($response,true);
	 
	    $lat = $json['results'][0]['geometry']['location']['lat'];
	    $lng = $json['results'][0]['geometry']['location']['lng'];
	 
	    return array($lat, $lng);
	}

	function getLocationByCoords($lat,$long)
    {

        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        $curlData = curl_exec($curl);
        curl_close($curl);

        $address = json_decode($curlData);
        $address = $address->results[0]->address_components;
        foreach ($address as $x) {
        	
        	if($x->types[0] == 'administrative_area_level_1')
        		$city = $x->long_name;
        	if($x->types[0] == 'country')
        		$country = $x->long_name;
        	
        }

        $output = array();
        $output['city'] = $city;
        $output['country'] = $country;
        
        return $output;
    }

	function get_hashtags($string, $str = 1) {
		 preg_match_all('/#(\w+)/',$string,$matches);
		  $i = 0;
		  if ($str) {
		   foreach ($matches[1] as $match) {
		   $count = count($matches[1]);
		   $keywords .= "$match";
		    $i++;
		    if ($count > $i) $keywords .= ", ";
		   }
		  } else {
		  foreach ($matches[1] as $match) {
		  $keyword[] = $match;
		  }
		  if(isset($keyword))
		  	$keywords = $keyword;
		  else
		  	return false;
		 }
		return $keywords;
		}

	function handleUpload($video_id,$filename)
	{

		$target_dir = base_url().'public/upload/videos';
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$videoFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$imageFileType = pathinfo($_FILES["fileToUpload_image"]["name"],PATHINFO_EXTENSION);

		// Allow certain file formats
		if($videoFileType != "flv" && $videoFileType != "mp4") {
		    return false;
		}

		// Allow certain file formats
		if($imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpg") {
		    return false;
		}

    $source_file = $_FILES["fileToUpload"]["tmp_name"];
		$destination_path = 's3://life_is_big/'.$video_id.'/'.$filename;
		$cmd = 's3cmd put --debug --acl-public --config=/home/amrbakr/.s3cfg ' . $source_file . ' ' . $destination_path;
		exec($cmd . ' >> file.log 2>&1', $out, $ret);

		if ($ret)
		{
			return false;
		}

		$source_file = $_FILES["fileToUpload_image"]["tmp_name"];
		$destination_path = 's3://life_is_big/'.$video_id.'/image/'.$filename;
		$cmd = 's3cmd put --debug --acl-public --config=/home/amrbakr/.s3cfg ' . $source_file . ' ' . $destination_path;
		exec($cmd . ' >> file.log 2>&1', $out, $ret);

		if ($ret)
		{
			return false;
		}

		return true;
	}

	
 ?>