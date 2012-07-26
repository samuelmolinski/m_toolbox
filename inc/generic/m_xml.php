<?php
	include_once ('m_super_dump.php');

	function mLoadXml($url, $simplexml = true, $loadAsSimpleXML = FALSE) {
		/*
		 * try to get it the easy way.
		 * if not, we use curl
		 */
		if (!($cache = file_get_contents($url))) {
			//echo 'fail';
			try {
				$ch = curl_init();
				$timeout = 5;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$cache = curl_exec($ch);
				curl_close($ch);
			} catch (Exception $e) {
			//	echo 'Caught exception: ', $e -> getMessage(), "\n";
			//	echo 'Unable to load ' . $url . ' at this time.';
			//	return FALSE;
			}
		
		}
		//d($cache);
		if ($loadAsSimpleXML) {
			$xml = simplexml_load_string($cache);
		} else {
			// disable PHP errors
			$old = libxml_use_internal_errors(true);
	
			$dom = new DOMDocument;
			$dom -> loadHTML($cache);
	
			// restore the old behaviour
			libxml_use_internal_errors($old);
			$xml = simplexml_import_dom($dom);
		}

		//d($xml);
		// returns simplexml obj
		if ($simplexml) {
			return $xml;
			// else return DOMDocument
		} else {
			return $dom;
		}
	}
