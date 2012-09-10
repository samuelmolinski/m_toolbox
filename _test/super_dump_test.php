<?php
    require_once ('../inc/generic/m_class-YouTubeChannel.php');
    require_once ('../inc/generic/m_super_dump.php');

	$Youtube = new YouTubeChannel();	
	$Youtube -> author = 'UCqAv9shn1FV316tmGI-Tzkg';	
	$Youtube -> orderFix = TRUE;
	$Youtube -> enablePages = TRUE;
	$Youtube -> orderby = 'published';
	$Youtube -> page = 0; 
	$Youtube -> maxResult = 16;
	$Youtube -> get_channel();
	
	$other = 'akjsd ´noaweniva woenvapkvair vnrib ~re';
	$attr = array('category'=>NULL, 'startIndex'=>NULL, 'maxResult'=>10, 'author'=>NULL, 'orderby'=>'', 'orderFix'=>FALSE, 'enablePages'=>NULL, 'page'=>NULL, 'curPage'=>0, 'numPages'=>NULL, 'key'=>NULL, 'alt'=>'json', 'strict'=>'true', 'version'=>2, 'channel'=>NULL, 'numVideos'=>NULL, 'videos'=>array());
	
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>new_file</title>
		<meta name="description" content="" />
		<meta name="author" content="Cabana Criacão" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and
		delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<script src="../js/jquery-1.7.2.js"></script>
		<script src="../js/m_super_dump_format.js"></script>
		<script>
			$(document).ready(function(){
				$('.m_inspect').d();
				$('.m_expandButton').click(function() {
					$(this).toggleClass('open');
					$(this).parent().find('>.m_expandWin').slideToggle();
				});
			});
		</script>
	</head>
	<body>
		<div>
			<header>
				<h1>new_file</h1>
			</header>
			<nav>
				<p><a href="/">Home</a></p>
				<p><a href="/contact">Contact</a></p>
			</nav>
			<div>
				<?php d($attr); ?>
				<?php d($other); ?>
				<?php d($Youtube); ?>
				<?php d($Youtube); ?>
			</div>
			<footer>
				<p> &copy; Copyright  by Samuel </p>
			</footer>
		</div>
	</body>
</html>