<?php
if($_GET['type'] == 'image' && $_GET['id']) {
	header ('Content-Type: image/png');
	$r = $a->videohash($_GET['id']);
	ob_clean();
	if($_GET['size'] == 'small')
	echo file_get_contents($r['small_poster']);
	if($_GET['size'] == 'big')
	echo file_get_contents($r['big_poster']);
	die();
}