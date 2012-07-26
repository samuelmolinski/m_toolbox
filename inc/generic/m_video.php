<?php

	function cleanVideoURL($videoURL) {

		$strip = explode('/', $videoURL);
		//inspect($strip);
		$strip = explode('v=', $strip[count($strip) - 1]);
		//inspect($strip);
		count($strip) > 1 ? $strip = explode('&', $strip[1]) : $strip = explode('&', $strip[0]);
		//inspect($strip);
		$strip = explode('?', $strip[0]);
		//inspect($strip);
		$url = $strip[0];

		return $url;
	}

	function getYoutubeThumb($code) {
		//return "http://img.youtube.com/vi/$code/maxresdefault.jpg";
		return "http://img.youtube.com/vi/$code/hqdefault.jpg";
	}

	function youtubeIframe($url, $width = '418', $height = '200', $params = 'wmode=transparent&rel=0') {
		$url = addParamToURL($url, $params);
		return "<iframe title='YouTube video player' style='width:$width; height:$height' src='$url' frameborder='0' allowfullscreen></iframe>";
	}

	/*
	function megavideoCode() {
			return <<<MEGAVIDEO
			<object width="{$this->_width[self::MEGAVIDEO][$this->size]}" height="{$this->_height[self::MEGAVIDEO][$this->size]}">
				<param name="movie" value="http://www.megavideo.com/v/{$this->v}"></param>
				<param name="allowFullScreen" value="true"></param>
				<embed src="http://www.megavideo.com/v/{$this->v}" type="application/x-shockwave-flash" allowfullscreen="true" width="{$this->_width[self::MEGAVIDEO][$this->size]}" height="{$this->_height[self::MEGAVIDEO][$this->size]}"></embed>
			</object>
	MEGAVIDEO;
		}
	
		function vimeoCode() {
			return <<<VIMEO
			<iframe src="http://player.vimeo.com/video/21339058?byline=0&amp;portrait=0" width="{$this->_width[self::VIMEO][$this->size]}" height="{$this->_height[self::VIMEO][$this->size]}" frameborder="0"></iframe>
	VIMEO;
		}
	
		function veohCode() {
			return <<<VEOH
			<object width="{$this->_width[self::VEOH][$this->size]}" height="{$this->_height[self::VEOH][$this->size]}" id="veohFlashPlayer" name="veohFlashPlayer">
				<param name="movie" value="http://www.veoh.com/static/swf/veoh/MediaPlayerWrapper.swf?version=&permalinkId={$this->v}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed src="http://www.veoh.com/static/swf/veoh/MediaPlayerWrapper.swf?version=&permalinkId={$this->v}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="{$this->_width[self::VEOH][$this->size]}" height="{$this->_height[self::VEOH][$this->size]}" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed>
			</object>
	VEOH;
		}*/
	

	function youtubeVideoURL($code, $hd = False) {
		$url = "http://www.youtube.com/embed/$code";
		if ($hd)
			$url .= '&amp;hd=1';
		return $url;
	}

	function getVideoCode($url, $player = 'youtube') {
		switch (strtolower($player)) {
			case 'vimeo' :
				$video_code = substr(parse_url($url, PHP_URL_PATH), 1);
				if ($video_code)
					return $video_code;
				break;
			case 'veoh' :
				$video_code = substr(parse_url($url, PHP_URL_PATH), 7);
				if ($video_code)
					return $video_code;
				break;
			default :
				//  for links like this http://youtu.be/u6yUo89SaYM
				//	http://youtu.be/PACiNEbzcNg
				//   http://youtu.be/u6yUo89SaYM
				if ((FALSE !== stripos($url, 'youtu.be/') && (FALSE === stripos($url, 'v=')))) {
					$get_var = explode('youtu.be/', $url);
					return $get_var[1];
				} elseif (FALSE !== stripos($url, 'v=')) {
					$get_vars = explode('&', html_entity_decode(parse_url($url, PHP_URL_QUERY)));
					foreach ($get_vars as $var) {
						$exploded_var = explode('=', $var);
						if ($exploded_var[0] === 'v')
							return $exploded_var[1];
					}
					break;
				} elseif (FALSE !== stripos($url, 'embed')) {
					//http://www.youtube.com/embed/9yjI4UZmnAc?wmode=transparent				
					$get_vars = explode("/", $url);
					$c = $get_vars[count($get_vars)-1];
					$e = explode('?', $c);
					return $e[0];
				}
		}
		return false;
	}
