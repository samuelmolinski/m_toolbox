<?php

	require_once ('m_class-Utility.php');
	//require_once ('super_dump.php');

	class YouTubeVideo {
		
		private $id; //(string)
		private $date; //(int)
		private $dateMod; //(int)
		private $title; //(string)
		private $keywords; //(bool)
		private $description; //(int) the first page is zero
		private $cat; //(string)
		private $css; //(string)
		private $key; //(int) the version of the youtube API
		private $attr = array('id'=>NULL, 'date'=>NULL, 'dateMod'=>NULL, 'title'=>NULL, 'keywords'=>NULL, 'description'=>NULL, 'cat'=>NULL, 'css'=>NULL, 'key'=>NULL);

		public function __construct($param = NULL) {			
			$this->put($param);
		}
		
		public function __destruct() {
	        //requires PHP version 5.3.6 or higher
	        foreach ($this as $key => $value) {
	            unset($this->$key);
	        }
	    }

		public function __set($name, $value) {
			$this->attr[$name] = $this->validate($name, $value);
		}

		public function __get($name) {
			//echo "Getting '$name'\n";
			if (array_key_exists($name, $this->attr)) {
				return $this->attr[$name];
			}

			$trace = debug_backtrace();
			trigger_error(
				'Undefined property via __get(): ' . $name .
				' in ' . $trace[0]['file'] .
				' on line ' . $trace[0]['line'], E_USER_NOTICE);
			return null;
		}

		public function __isset($name) {
			//echo "Is '$name' set?\n";
			return isset($this->attr[$name]);
		}

		public function __unset($name) {
			//echo "Unsetting '$name'\n";
			unset($this->$attr[$name]);
		}
		
		private function validate($name, $value) {
			//add validation based on $name
			switch ($name) {
//				case 'id' :
//					//exception, data filter
//					break;
				default:					
					return $value;

			}

		}
		
		public function put($param = NULL) {
			//set a group of property based on an array input
			$semID = FALSE;
			//QUICK SKIP if ID is ommited
			if (count($param) == count($this->attr)-1) {
				$semID = TRUE;
			}
			
			if (is_array($param)) {
				//if the array passes by object by association or index
				if (Utility::isAssoc($param)){ 
					foreach ($param as $key => $item) {
						//Preserve data integrity and filter out non-attributes
						if (key_exists($key, $this->attr)) {
							$this->attr[$key] = $this->validate($key, $item);
						}
					}				
				} else {
					
					foreach ($this->attr as $key => $val) {
						if (($key == 'id')&&($semID)) {continue;}//skipping id update
						$this->attr[$key] = $this->validate($key, array_shift($param));
					}
					
				}
			}
		}
		/* This is used this to quicky compare if two obj are
		 * by using array_diff() to compare them as strings. Ideally json encode
		 * should produce unique strings with the obj variables
		 */
		public function __toString() {
			return json_encode(get_object_vars($this));
		}		
		
		public function prepEntry($v) {
			//d($v);
			//$exp = explode('/', (string)$simpleXMLObj->id);
			//grab youtube code and construct friendly obj
			$this->attr['id'] = $v->{'media$group'}->{'yt$videoid'}->{'$t'};
			$this->attr['date'] = $v->published->{'$t'};
			$this->attr['dateMod'] = $v->updated->{'$t'};
			$this->attr['title'] = $v->title->{'$t'};
			//$entry['content'] = $v->content->{'$t'};
			$this->attr['keywords'] = @$v->{'media$group'}->{'media$keywords'}->{'$t'};
			$this->attr['description'] = @$v->{'media$group'}->{'media$description'}->{'$t'};
			//$entry['veiws'] = (string)$simpleXMLObj->statistics->attributes()->viewcount;
			$this->attr['cat'] = array();
			$this->attr['css'] = array();
			
			//get Catagories
			$cats = $v->{'media$group'}->{'media$category'};
			//d($cats);
			// adding Catagories
			
			foreach($cats as $cat) {
				$this->attr['cat'][$cat->{'$t'}] = $cat->label;
				$this->attr['css'][] = Utility::cssSafeName($cat->{'$t'});
			}
			
			
			$keywds = $v->category;
			//d($keywds);
			// adding keys
			
			foreach($keywds as $key) {
				//d($key);
				if(FALSE !== stripos($key->scheme, 'keywords')){
					$this->attr['key'][] = $key->term;
					$this->attr['css'][] = $key->term;
				}
			}
			return $this;
		}
	}
?>