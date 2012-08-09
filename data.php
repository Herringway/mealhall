<?php
define('CACHEFILE', 'cache.yml');
define('LATENIGHTFILE', 'latenight.yml');
define('MEALHALLURL', 'http://www.campusdish.com/en-US/CA/MountAllison');
//define('MEALHALLURL', 'mealhall.html');
define('DEVMODE', false);
date_default_timezone_set('America/Halifax');
function baddata($msg) {
	header("Status: 503 Service Unavailable");
	die ($msg);
}
function loaddata() {
	$lnight = null;
	if (!file_exists(LATENIGHTFILE))
		file_put_contents(LATENIGHTFILE, yaml_emit(array()));
	$latenight = yaml_parse_file(LATENIGHTFILE);
	if (isset($latenight[date('j')]))
		$lnight = $latenight[date('j')];
	if (!file_exists(CACHEFILE))
		file_put_contents(CACHEFILE, yaml_emit(array('cachedate' => 0)));
	$data = yaml_parse_file(CACHEFILE);
	if (DEVMODE || (($data['cachedate'] != date('j')) && (date('G') >= 2))) {
		require_once('simple_html_dom.php');
		$file = file_get_html(MEALHALLURL);
		$table = $file->find('div#WCChalkboard_NewMenu', 0);
		if ($table === null)
			baddata('No menu data available');
		$i = 1;
		foreach ($table->find('img[alt]') as $img)
			$meals['menu'.$i++] = $img->alt;

		foreach ($table->find('td') as $data) {
			$partable = $data->parent()->parent()->id;
			if (!$partable)
				continue;

			$type = '';
			$food = '';
			foreach($data->find('div.section b,div.section a,div.section xml') as $tag) {
				if ($tag->tag == 'b')
					$type = ucfirst(strtolower(html_entity_decode(trim($tag->plaintext))));
				else if ($tag->tag == 'a') {
					$str = ucfirst(strtolower(html_entity_decode(trim($tag->plaintext))));
					$food = strstr($str, ' (', true) ?: $str;
				} else if ($tag->tag == 'xml') {
					$tmp = array();
					$p1 = null; $p2 = null;
					foreach ($tag->find('item') as $item) {
						if ($item->v != "") {
							if ($item->n != "")
								$tmp[html_entity_decode(trim($item->n))] = ucfirst(strtolower(str_replace('  ', ' ',preg_replace('/[^a-zA-Z0-9\s\.]/', ' ', html_entity_decode(trim($item->v))))));
							else
								if ($item->id == "PortionSize2")
									$p1 = $item->v;
								else if ($item->id == "PortionUnit1")
									$p2 = $item->v;
						}
					}
					$meallist[$meals[$partable]][$type][] = $food;
					$foodlist[$food] = ($p1 && $p2 ? array(' Portion Size' => $p1.' '.$p2) : array()) + $tmp;
				}
			}
		}
		$data = array('cachedate' => date('j'), 'meallist' => $meallist, 'foodlist' => $foodlist, 'latenight' => $lnight);
		file_put_contents(CACHEFILE, yaml_emit($data));
	}
	return $data;
}
function xmlentities($string) {
	if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50400)
		return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $string );
	return htmlentities($string, ENT_XML1);
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode(loaddata(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT); 
?>
