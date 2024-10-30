<?php
/*
Plugin Name: Clubhouse Tags
Plugin URI: http://mynetx.net/go/clubhousetags/
Description: Adds <a href="http://clubhouse.microsoft.com/">Clubhouse</a> Tags to the blog feed automatically.
Author: mynetx Creations
Version: 1.0.4
Author URI: http://mynetx.net/
*/

function mynetx_clubhouse_tags_rss2_head() {
	define('MYN_CHT_ISFEED', 1);
}

function mynetx_clubhouse_tags_rss2_item($strText) {

	global $id;

	if(!defined('MYN_CHT_ISFEED'))
		return $strText;
	if(isset($GLOBALS['sitepress'])) {
		$strLanguage = $GLOBALS['sitepress']->get_current_language();
		if($strLanguage != 'en')
			return $strText;
	}
	$arrTags = get_the_tags();
	if(is_array($arrTags)) {
		$strText .= '<div style="display:none">';
		$intTags = count($arrTags);
		foreach($arrTags as $arrTag) {
			$strText .= '<a href="http://clubhouse.microsoft.com/posts/tag/'.rawurlencode($arrTag->name).
				'" rel="clubhouseTag">'.$arrTag->name.'</a>';
			if($i++ + 1 < $intTags)
				$strText .= ', ';
		}
		$strText .= '</div>';
	}
	return $strText;
}

function mynetx_clubhouse_tags_plugin_actions($arrLinks) {
	$arrLinks[] = '<a href="http://clubhouse.microsoft.com/">About Clubhouse</a>';
	return $arrLinks;
}

add_action('rss2_head', 'mynetx_clubhouse_tags_rss2_head');
add_action('the_content', 'mynetx_clubhouse_tags_rss2_item', 9);

global $wp_version;
if(version_compare($wp_version, '2.0', '>='))
	add_action('plugin_action_links_' . plugin_basename(__FILE__), 'mynetx_clubhouse_tags_plugin_actions');

?>