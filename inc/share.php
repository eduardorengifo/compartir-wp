<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__on_publish_draft_post' ) )
{
    /**
     * Share New Post
     *
     * @param WP_Post $post
     *
     * @link https://codex.wordpress.org/Post_Status_Transitions
     *
     * @return void
     */
    function compartir_wp__on_publish_draft_post( $post )
    {
        // TODO: Code for publish draft on publish post
    }
}

add_action(  'draft_to_publish',  'compartir_wp__on_publish_draft_post', 10, 1 );

// ----------------------------------------------------------------------------------