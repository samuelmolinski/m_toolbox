<?php

function get_facebook_count($url) {
	$fql  = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
	$fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
	$fql .= "link_stat WHERE url = '$url'";
	
	$apifql="http://api.facebook.com/method/fql.query?format=json&query=".urlencode($fql);
	$json=file_get_contents($apifql);
	$data = json_decode($json);
	
	
	if (is_array($data)) {
		return $data[0];
	} else {
		return FALSE;
	}
}

function socialMediaStrip($url) { ?>
	<div class="socialMediaStrip">
	<div class="sm-face">	
		<div class="fb-like" data-href="<?php echo $url ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true" data-font="arial"></div>
	</div>
	<div class="sm-twitter">
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url ?>" data-via="DepRodrigoMaia">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
	<div class="sm-gplus">
		<g:plusone></g:plusone>
		<script type="text/javascript">
		  window.___gcfg = {lang: 'pt-BR'};	
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	</div>
	</div>
<?php }

function FB_OG($imgURL = '', $title = '', $description = '', $URL = '', $type = '') {
	/* The OG/FB settings should be set in the config.php of m_toolbox.
	 * empty quotes are used instead of 'null' because the default values of 
	 * m_toolbox config.php are blank, this way they match.
	 * 
	 */
	if('' != FB_ID) {echo "<meta property='fb:admins' content='".FB_ADMINS."'/>";}
	if('' != FB_ADMINS) {echo "<meta property='fb:app_id' content='".FB_ID."'/>";}
	if('' != $type) {echo "<meta property='og:type' content='$type'/>";}
	if('' != $title) {echo "<meta property='og:title' content='$title'/>";}
	if('' != $imgURL) {echo "<meta property='og:image' content='$imgURL'/>";}
	if('' != $URL) {echo "<meta property='og:url' content='$URL'/>";}
	if('' != $description) {echo "<meta property='og:description' content='$description'/>";}
	
}
