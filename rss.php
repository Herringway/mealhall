<?php
require_once('Dwoo/dwooAutoload.php');
require_once('common.php');
$data = loaddata();
$weekdaytimes = array('Breakfast' => array('7:45AM', '9:30AM'), 'Lunch' => array('11:45AM', '1:30PM'), 'Dinner' => array('4:45PM', '8PM'));
$weekendtimes = array('Continental' => array('9AM', '11:15AM'), 'Brunch' => array('11:15AM', '1:15PM'), 'Dinner' => array('4:45PM', '7PM'));
$items = null;
foreach ($data['foods'] as $name=>$mealarea) {
	foreach ($mealarea as $meal=>$nutrition) {
		if (date('N') >= 6) {
			$btime = strtotime($weekendtimes[$name][0]);
			$etime = strtotime($weekendtimes[$name][1]);
		} else {
			$btime = strtotime($weekdaytimes[$name][0]);
			$etime = strtotime($weekdaytimes[$name][1]);
		}
		if (($btime <= time()) && ($etime >= time()))
			$items[] = array('meal' => $name, 'subject' => $name, 'body' => implode(', ',$meal), 'time' => $btime);
	}
}
$dwoo = new Dwoo();
$dwoo->output('rss.tpl', array('items' => $items));
?>
