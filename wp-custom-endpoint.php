<?php

// The followin EndPoint will render the news posts:
// http://localhost:8888/wp-json/parent-theme/v1/latest-posts/5

add_action('rest_api_init', function () {
	register_rest_route( 'blockchain_mastermind/v1', 'latest-posts/(?P<category_id>\d+)' ,array(
				  'methods'  => 'GET',
				  'args' => array(),
				  'callback' => 'get_latest_posts_by_category',
				  'permission_callback' => function () {
					return true;
				  } 
		));
  });

function get_latest_posts_by_category(WP_REST_Request $request) {

    $args = array(
			'post_type' => 'market',
            'numberposts' => 10,
            'category' => $request['category_id']
    );

    $posts = get_posts($args);
    if (empty($posts)) {
        return new WP_Error( 'empty_category', 'There are no posts to display', array('status' => 404) );
    }

    $response = new WP_REST_Response($posts);
    $response->set_status(200);

    // Gets the latest 10
    return $response;

    // Gets specific object in the result
    // foreach ($response as $a) {
    //     return $a[0]->ID;
    // }
}