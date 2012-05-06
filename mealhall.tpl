<!DOCTYPE html>
<html>
<head>
<title>Meal Hall</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<link rel="stylesheet" href="jmtheme.css" type="text/css" />
<link rel="stylesheet" href="jmstruct.css" type="text/css" />
<link rel="alternate"  type="application/rss+xml" title="Meal Hall RSS" href="{$fullurl}/rss" />
<script type="application/x-javascript" src="jquery.js"></script>
<script type="application/x-javascript" src="jquery-mobile.js"></script>
<link rel="apple-touch-icon" href="/burg.png"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
<div id="one" data-role="page">
	<div data-role="header">
		<h1>Meals</h1>
	</div>
	<div data-role="content">
	<ul data-role="listview" data-inset="true">
{loop $meals}
		<li><a href="#{$}">{$}</a></li>
{/loop}
{if $latenight}<li>Late Night: {$latenight}</li>
{/if}</ul></div>
	</div>
{loop $foods}
<div id="{$_key}" data-role="page" data-add-back-btn="true">
	<div data-role="header">
		<h1>{$_key}</h1>
	</div>
	<div data-role="content">
	<ul data-role="listview" data-inset="true">
{loop $}<li class="group" data-role="list-divider">{$_key}</li>
{loop $}
	<li><a href="#{preg_replace('/[^a-zA-Z0-9]/', '', $_key)}">{$_key}</a></li>
{/loop}{/loop}</ul></div></div>
{/loop}
{loop $foods}{loop $}{loop $}
<div id="{preg_replace('/[^a-zA-Z0-9]/', '', $_key)}" data-role="page" data-add-back-btn="true">
	<div data-role="header">
		<h1>Nutritional Information for {$_key}</h1>
	</div>
	<div data-role="content">
	<ul data-role="listview" data-inset="true">
{if $ == null}	<li>No nutritional data available</li>
{else}{loop $}{if is_array($)}	<li class="group">{$_key}</li>
{loop $}		<li>{$_key}: {$}</li>
{/loop}{else}	<li>{$_key}: {$}</li>{/if}
{/loop}{/if}</ul></div></div>
{/loop}{/loop}{/loop}
</body>
</html>
