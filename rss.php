<?php
header('Content-type: application/rss+xml');
require_once('Dwoo/dwooAutoload.php');
require_once('common.php');
$data = loaddata();
$weekdaytimes = array('Breakfast' => array('7:45AM', '9:30AM'), 'Lunch' => array('11:45AM', '1:30PM'), 'Dinner' => array('4:45PM', '8PM'));
$weekendtimes = array('Continental' => array('9AM', '11:15AM'), 'Brunch' => array('11:15AM', '1:15PM'), 'Dinner' => array('4:45PM', '7PM'));
$items = null;
$fullmenu = isset($_GET['full']);
$fullurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
foreach ($data['foods'] as $name=>$meals) {
	foreach ($meals as $mealarea=>$meal) {
		if (date('N') >= 6) {
			$btime = strtotime($weekendtimes[$name][0]);
			$etime = strtotime($weekendtimes[$name][1]);
		} else {
			$btime = strtotime($weekdaytimes[$name][0]);
			$etime = strtotime($weekdaytimes[$name][1]);
		}
		if ($fullmenu || (($btime <= time()) && ($etime >= time())))
			$items[] = array('meal' => $name, 'subject' => "$name - $mealarea", 'body' => implode("\n", array_keys($meal)), 'time' => $btime);
	}
}
$dwoo = new Dwoo();
$dwoo->output('rss.tpl', array('items' => $items, 'fullurl' => $fullurl));
?>
