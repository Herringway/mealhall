<?php
require_once('Dwoo/dwooAutoload.php');
require_once('common.php');
$data = loaddata();
if (!isset($_GET['dumpyaml'])) {
	$dwoo = new Dwoo();
	$dwoo->output('mealhall.tpl', $data);
} else {
	echo '<pre>'.yaml_emit($data).'</pre>';
}
?>
