<html>
<head>
<title>Meal Hall</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<link rel="stylesheet" href="/iui/iui.css" type="text/css" />
<link rel="stylesheet" href="/iui/t/default/default-theme.css" type="text/css"/>
<link rel="alternate"  type="application/rss+xml" title="Meal Hall RSS" href="http://peng.elpenguino.net/mealhall/rss" />
<script type="application/x-javascript" src="/iui/iui.js"></script>
<link rel="apple-touch-icon" href="/burg.png"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
<div class="toolbar">
      <h1 id="pageTitle"></h1>
      <a id="backButton" class="button" href="#"></a>
</div>
<ul id="screen1" title="Menu" selected="true">
{loop $meals}
	<li><a href="#{$}">{$}</a></li>
{/loop}	{if $latenight}<li>Late Night: {$latenight}</li>
{/if}</ul>
{loop $foods}
<ul id="{$_key}" title="{$_key}">
{loop $}<li class="group">{$_key}</li>
{loop $}
	<li><a href="#{str_replace(array(',',' '), '', $_key)}">{$_key}</a></li>
{/loop}{/loop}</ul>
{/loop}
{loop $foods}{loop $}{loop $}
<ul id="{str_replace(array(',',' '), '', $_key)}" title="{$_key}">
{if $ == null}	<li>No nutritional data available</li>
{else}
{loop $}{if is_array($)}	<li class="group">{$_key}</li>
{loop $}		<li>{$_key}: {$}</li>{/loop}
{else}	<li>{$_key}: {$}</li>{/if}{/loop}
{/if}
</ul>
{/loop}{/loop}{/loop}
</body>
</html>
