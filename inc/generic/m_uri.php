<?php

	function shortenURL($longUrl) {

		// initialize the cURL connection
		$ch = curl_init(sprintf('%s/url?key=%s', GOOGLE_ENDPOINT, GOOGLE_API_KEY));

		// tell cURL to return the data rather than outputting it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// create the data to be encoded into JSON
		$requestData = array('longUrl' => $longUrl);

		// change the request type to POST
		curl_setopt($ch, CURLOPT_POST, true);

		// set the form content type for JSON data
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

		// set the post body to encoded JSON data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

		// perform the request
		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result, true);
	}

	function currentURI() {
		return hostURI() . $_SERVER["REQUEST_URI"];
	}
	
	function currentBaseURI() {
		$base = $_SERVER["REQUEST_URI"];
		$base = explode('?', $base);
		return hostURI() . $base[0];
	}
	
	function currenURIDir() {
		$base = $_SERVER["REQUEST_URI"];
		$base = explode('?', $base);
		$base = explode('/',  $base[0]);
		$last = $base[count($base)-1];
		if (FALSE === strpos($last, '.')) {
			$base = implode('/', $base);
		} else {
			array_pop($base);
			$base = implode('/', $base);			
		}
		return hostURI() . $base;
	}
	
	function hostURI() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"];
		}
		return $pageURL;
	}

	function addParamToURL($url, $param) {
		//add support for arrays
		$p = strpos($url, '?');
		if (FALSE === $p) {
			return $url = $url.'?'.$param;
		} else {
			return $url = $url.'&'.$param;
		}
	}
