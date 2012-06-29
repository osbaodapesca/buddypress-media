<?php

/**
 * 
 */
function bp_media_activity_permalink_filter($link, $activity_obj) {
	if ('media_upload' == $activity_obj->type) {
		add_shortcode('bp_media_url', 'bp_media_shortcode_url');
		$link = do_shortcode($activity_obj->primary_link);
		remove_shortcode('bp_media_url');
	}
	$comment_id = bp_activity_add(array(
		'id' => $id,
		'action' => apply_filters('bp_activity_comment_action', sprintf(__('%s posted a new activity comment', 'buddypress'), bp_core_get_userlink($user_id))),
		'content' => apply_filters('bp_activity_comment_content', $content),
		'component' => $bp->activity->id,
		'type' => 'activity_comment',
		'user_id' => $user_id,
		'item_id' => $activity_id,
		'secondary_item_id' => $parent_id,
		'hide_sitewide' => $is_hidden
		));
	if ('activity_comment' == $activity_obj->type) {
		$parent = bp_activity_get_meta($activity_obj->item_id, 'bp_media_parent_post');
		if ($parent) {
			$parent = new BP_Media_Host_Wordpress($parent);
			$link = $parent->get_url();
		}
	}
	return $link;
}

add_filter('bp_activity_get_permalink', 'bp_media_activity_permalink_filter', 10, 2);

function bp_media_activity_action_filter($activity_action, $activity_obj) {

	if ('media_upload' == $activity_obj->type) {
		add_shortcode('bp_media_action', 'bp_media_shortcode_action');
		$activity_action = do_shortcode($activity_action);
		remove_shortcode('bp_media_action');
	}
	return $activity_action;
}

add_filter('bp_get_activity_action', 'bp_media_activity_action_filter', 10, 2);

function bp_media_activity_content_filter($activity_content, $activity_obj) {
	if ('media_upload' == $activity_obj->type) {
		add_shortcode('bp_media_content', 'bp_media_shortcode_content');
		$activity_content = do_shortcode($activity_content);
		remove_shortcode('bp_media_content');
	}
	return $activity_content;
}

add_filter('bp_get_activity_content_body', 'bp_media_activity_content_filter', 10, 2);

function bp_media_activity_parent_content_filter($content) {
	add_shortcode('bp_media_action', 'bp_media_shortcode_action');
	add_shortcode('bp_media_content', 'bp_media_shortcode_content');
	$content=do_shortcode($content);
	remove_shortcode('bp_media_action');
	remove_shortcode('bp_media_content');
	return $content;
}

add_filter('bp_get_activity_parent_content', 'bp_media_activity_parent_content_filter');
?>