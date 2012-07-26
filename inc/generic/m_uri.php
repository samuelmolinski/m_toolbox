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
		$base = explode('/', $base[0]);
		$last = $base[count($base) - 1];
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
		if (isset($_SERVER["HTTPS"])) {
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";
			}
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
		// support for arrays
		$p = strpos($url, '?');
		
		if (FALSE === $p) {
			if (is_array($pa)) {				
				return $url = $url . '?' . http_build_query($param);
			} else {
				return $url = $url . '?' . $param;
			}
		} else {
			if (is_array($pa)) {				
				return $url = $url . '&' . http_build_query($param);
			} else {
				return $url = $url . '&' . $param;
			}
		}
	}


	function rest_helper($url, $params = null, $verb = 'GET', $format = 'json') {
		$cparams = array('http' => array('method' => $verb, 'ignore_errors' => true));
		if ($params !== null) {
			$params = http_build_query($params);
			if ($verb == 'POST') {
				$cparams['http']['content'] = $params;
			} else {
				$url .= '?' . $params;
			}
		}

		$context = stream_context_create($cparams);
		$fp = fopen($url, 'rb', false, $context);
		if (!$fp) {
			$res = false;
		} else {
			// If you're trying to troubleshoot problems, try uncommenting the
			// next two lines; it will show you the HTTP response headers across
			// all the redirects:
			// $meta = stream_get_meta_data($fp);
			// var_dump($meta['wrapper_data']);
			$res = stream_get_contents($fp);
		}

		if ($res === false) {
			throw new Exception("$verb $url failed: $php_errormsg");
		}

		switch ($format) {
			case 'json' :
				$r = json_decode($res);
				if ($r === null) {
					throw new Exception("failed to decode $res as json");
				}
				return $r;

			case 'xml' :
				$r = simplexml_load_string($res);
				if ($r === null) {
					throw new Exception("failed to decode $res as xml");
				}
				return $r;
		}
		return $res;
	}

	// This lists projects by Ed Finkler on GitHub:
	// foreach (rest_helper('http://github.com/api/v2/json/repos/show/funkatron')
	// ->repositories as $repo) {
		// echo $repo -> name, "<br>\n";
		// echo htmlentities($repo -> description), "<br>\n";
		// echo "<hr>\n";
	// }

	// This incomplete snippet demonstrates using POST with the Disqus API
	///var_dump(rest_helper("http://disqus.com/api/thread_by_identifier/", array('api_version' => '1.1', 'user_api_key' => $my_disqus_api_key, 'identifier' => $thread_unique_id, 'forum_api_key' => $forum_api_key, 'title' => 'HTTP POST from PHP, without cURL', ), 'POST'));
