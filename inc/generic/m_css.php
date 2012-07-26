<?php
    
	function cssSafeName($string) {		
			$css_id = strtolower(str_replace(' ', '-', strip_tags($string)));
			$css_id = preg_replace('/[^a-z0-9]+/i', '-', $css_id);
			return $css_id;
	}
	
	function the_date_tag() {
		global $post;
		$d = get_the_date('d'); //day
		$m = get_the_date('n'); //month
		//$y = get_the_date('Y'); //year
		//['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
		$month = array(__('jan'),__('fev'),__('mar'),__('abr'),__('mai'),__('jun'),__('jul'),__('ago'),__('set'),__('out'),__('nov'),__('dez'));
		$m = $m -1; // must mod for use with the array
		//inspect($m);
		//inspect($month);
		echo ("<div class='dateTag'><div class='day'>$d</div><div class='month'>$month[$m]</div></div>");
	}