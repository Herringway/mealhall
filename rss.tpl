<?xml version="1.0"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
        <channel>
                <title>MTA Meal Hall</title>
                <link>{$fullurl}</link>
                <description>Mount Allison's Meal Hall Menu</description>
                <language>en-us</language>
                <generator>Whatever</generator>
                <managingEditor>cpross@mta.ca (Rocco)</managingEditor>
                <webMaster>cpross@mta.ca (Rocco)</webMaster>
                <atom:link href="{$fullurl}" rel="self" type="application/rss+xml" />{loop $items}

		<item>
			<title>{xmlentities($subject)}</title>
			<link>http://peng.elpenguino.net/mealhall#_{$meal}</link>
			<description>{xmlentities($body)}</description>
			<pubDate>{date('D, d M Y H:i:s O',$time)}</pubDate>
			<guid isPermaLink="false">{md5($body)}</guid>
			<author>cpross@mta.ca (Rocco)</author>
		</item>{/loop}
	</channel>
</rss>
