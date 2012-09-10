<?php

	require_once ('m_class-Utility.php');
	require_once ('m_class-YouTubeVideo.php');
	//require_once ('super_dump.php');

	class YouTubeChannel {
		
		private $category; //(string)
		private $orderFix; //(string)
		private $startIndex; //(int)
		private $maxResult; //(int)
		private $author; //(string)
		private $orderby ; //(string)
		private $pageCode; //(string)
		private $enablePages; //(bool)
		private $page; //(int) the first page is zero
		private $curPage; //(int)
		private $numPages; //(int) 
		private $key; //(string)
		private $alt; //(string)
		private $version; //(int) the version of the youtube API
		private $strict; //(int) the version of the youtube API
		private $channel; //(obj) json converted obj
		private $numVideos; //(int)
		private $videos; //array of videos
		private $attr = array('category'=>NULL, 'startIndex'=>NULL, 'maxResult'=>10, 'author'=>NULL, 'orderby'=>'', 'orderFix'=>FALSE, 'enablePages'=>NULL, 'page'=>NULL, 'curPage'=>0, 'numPages'=>NULL, 'key'=>NULL, 'alt'=>'json', 'strict'=>'true', 'version'=>2, 'channel'=>NULL, 'numVideos'=>NULL, 'videos'=>array());

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

		public function get_channel($url = NULL) {
			if(NULL === $url) {
				$url = $this->build_channel_query();
			}
			//d($url);

			if (!($cache = @file_get_contents($url))) {
				try {
					$timeout = 5;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
					$cache = curl_exec($ch);
					curl_close($ch);
				} catch (Exception $e) {
					close($e, TRUE, $e -> getMessage());
				}
			}
			if(0 === $this->attr['curPage']){
				$this->post_process($cache);
			}
						
			return $cache;
		}
		private function post_process($cache){
			if(json_decode($cache)) {
				$cache = json_decode($cache);
			}
			if (!$this->attr['orderFix']) {
				$this->attr['channel'] = $cache;
				$this->attr['numVideos'] = $this->attr['channel']->feed->{'openSearch$totalResults'}->{'$t'};
				//parse videos into a usable form
				
				$this->parseVideos();
				
			} else {
				//need to query the entire data set
				$this->attr['channel'] = $cache;
				$this->attr['numVideos'] = $this->attr['channel']->feed->{'openSearch$totalResults'}->{'$t'};
				$this->attr['numPages'] = ceil($this->attr['numVideos'] / 50);
				//d($this->attr['numVideos']);
				//d($this->attr['numPages']);
				//parse videos into a usable form				
				
				$this->parseVideos();
				if($this->attr['numPages'] > 1) {						
					for($i=1; $i <= $this->attr['numPages']-1; $i++){
						$this->attr['curPage'] = $i;
						$this->attr['channel'] = json_decode($this->get_channel());
						$this->parseVideos();
					}
					$this->attr['curPage'] = 0;
				}
				$this->getCategory();
				$this->attr['numVideos'] = count($this->attr['videos']);
				$this->sortByDate();
				$this->orderFix();
				
			}
			//youtube bug doesn't sort properly so we need to do it
			$this->attr['numPages'] = ceil($this->attr['numVideos'] / $this->attr['maxResult']);
		}
		/*
		 * This function will need several revisions to accommodate all various of YouTube API
		 */
		private function build_channel_query() {
			$base = 'http://gdata.youtube.com/feeds/api/';
			if (@$this->attr['pageCode']) {
				$pageCode = $this->attr['pageCode'];
			}
			
			if (!$this->attr['orderFix']) {
				//sample: http://gdata.youtube.com/feeds/api/users/UCqAv9shn1FV316tmGI-Tzkg/uploads?start-index=1&max-results=50&alt=json
				
				if($this->attr['author']) {
					$url = $base.'users/'.$this->attr['author'].'/uploads';
				} elseif($this->attr['pageCode']) {
					$url = $base.'videos/'.$pageCode;
				}
				if ($this->attr['category'] && !$pageCode) {
					$url = Utility::addParamToURL($url, 'category='.$this->attr['category']);
				}
				/*if ($this->attr['orderby'] && !$pageCode) {
					$url = Utility::addParamToURL($url, 'orderby='.$this->attr['orderby']);
				}*/
				if ($this->attr['alt']) {
					$url = Utility::addParamToURL($url, 'alt='.$this->attr['alt']);
				}
				if ($this->attr['enablePages'] && !$pageCode) {
					if($this->attr['page']) {
						$index = $this->attr['page'] * $this->attr['maxResult'] + 1;
						$url = Utility::addParamToURL($url, 'start-index='.$index);
					} else {
						$url = Utility::addParamToURL($url, 'start-index=1');
					}
				} elseif($this->attr['start-index'] && !$pageCode) {
					$url = Utility::addParamToURL($url, 'start-index='.$this->attr['startIndex']);
				}
				if ($this->attr['maxResult'] && !$pageCode) {
					$url = Utility::addParamToURL($url, 'max-results='.$this->attr['maxResult']);
				}
				if ($this->attr['strict']) {
					$url = Utility::addParamToURL($url, 'strict='.$this->attr['strict']);
				}
				if ($this->attr['version']) {
					$url = Utility::addParamToURL($url, 'v='.$this->attr['version']);
				}
				return $url; 
			} else {
				$currentIndex = 50*$this->attr['curPage']+1;
				if($this->attr['author']) {
					$url = $base.'users/'.$this->attr['author'].'/uploads';
				} elseif($this->attr['pageCode']) {
					$url = $base.'videos/'.$pageCode;
				}
				/*if ($this->attr['category'] && !$pageCode) {
					$url = Utility::addParamToURL($url, 'category='.$this->attr['category']);
				}*/
				$url = Utility::addParamToURL($url, 'start-index='.$currentIndex);
				$url = Utility::addParamToURL($url, 'alt=json');
				$url = Utility::addParamToURL($url, 'strict=true');
				$url = Utility::addParamToURL($url, 'v=2');
				$url = Utility::addParamToURL($url, 'max-results=50');
				return $url;
			}

		}

		private function getCategory() {
			//d($this->attr['videos']);
			foreach($this->attr['videos'] as $k=>$v) {
				//d($v);
				if(!in_array($this->attr['category'], $v->key)){
					unset($this->attr['videos'][$k]);
				}
			}
			$this->attr['videos'] = array_values($this->attr['videos']);
			//d($this->attr['videos']);
			//array_unique($this->attr['videos']);
		}		
		
		private function sortByDate($order='asc') {
			//d($this->attr['videos']);
			if ('asc' == $order) {
				usort($this->attr['videos'], array($this, 'compareDatesAsc'));
			}
			if ('desc' == $order) {
				usort($this->attr['videos'], array($this, 'compareDatesDesc'));
			}
		}		
		
		private function compareDatesDesc($A, $B) {
			$a = strtotime($A->{'date'});
			$b = strtotime($B->{'date'});
			return $a-$b;
		}
		
		private function compareDatesAsc($A, $B) {
			$a = strtotime($A->{'date'});
			$b = strtotime($B->{'date'});
			return $b-$a;
		}
		/*
		 * While I was working with YouTube API i found a bug that has been repeated fixed for 4 years!
		 * This fix is simple but may slow down pages until Google/Youtube fixes the real problem.
		 */
		private function orderFix() {
			if (@$this->attr['enablePages'] && @!$pageCode) {
				if($this->attr['page']) {
					$index = $this->attr['page'] * $this->attr['maxResult'];
					//d($index);
					//d($index+$this->attr['maxResult']);
					$this->attr['videos'] = array_slice($this->attr['videos'],$index, $index+$this->attr['maxResult']);
				} else {
					$this->attr['videos'] = array_slice($this->attr['videos'],0, $this->attr['maxResult']);				
				}
			} 
		}
		
		private function parseVideos() {
			$feed = @$this->attr['channel']->feed->entry;
			$entry = @$this->attr['channel']->entry;
			if($feed){
				if(is_array($feed)) {						
					foreach ($feed as $v) {
						$video = new YouTubeVideo();
						$this->attr['videos'][] = $video->prepEntry($v);
					}
				} 
			} elseif($entry) {
				$video = new YouTubeVideo();
				$this->attr['videos'][] = $video->prepEntry($entry);
			}
		}
	}
?>