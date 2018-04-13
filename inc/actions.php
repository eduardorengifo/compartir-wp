<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__load_textdomain' ) )
{
    /**
     * Load text domain
     *
     * @return void
     */
    function compartir_wp__load_textdomain()
    {
        load_plugin_textdomain( COMPARTIR_WP__TEXT_DOMAIN, false, COMPARTIR_WP__PLUGIN_REL_PATH  . '/languages' );
    }
}

add_action( 'init', 'compartir_wp__load_textdomain' );

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
        // TODO: Your code
    }
}

add_action(  'draft_to_publish',  'compartir_wp__on_publish_draft_post', 10, 1 );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__on_update_post' ) )
{
    /**
     * Share Update Post
     *
     * @param WP_Post $post
     *
     * @return void
     * @throws Exception
     */
    function compartir_wp__on_update_post( $post )
    {
        // TODO: Your code
    }
}

add_action( 'publish_to_publish', 'compartir_wp__on_update_post', 10, 1 );

// ----------------------------------------------------------------------------------