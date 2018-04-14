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
        $general_options = get_option( COMPARTIR_WP__OPTIONS_GENERAL );

        if ( isset( $general_options['auto_publish'] )
            && $general_options['auto_publish'] === 'on' ) {

            compartir_wp__share_post( $post );

        } elseif ( isset( $_POST['compartir_wp__auto_publish_count'] )
            && $_POST['compartir_wp__auto_publish_count'] === '1' ) {

            compartir_wp__share_post( $post );

        }
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
        if( isset( $_POST['compartir_wp__auto_publish_count'] )
            && $_POST['compartir_wp__auto_publish_count'] === '1' ) {

            compartir_wp__share_post( $post );
        }
    }
}

add_action( 'publish_to_publish', 'compartir_wp__on_update_post', 10, 1 );

// ----------------------------------------------------------------------------------