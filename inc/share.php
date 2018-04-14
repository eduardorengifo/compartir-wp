<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post' ) )
{
    /**
     * Share Post
     *
     * @param WP_Post $post
     *
     * @return void
     */
    function compartir_wp__share_post( $post )
    {
        $general_options = get_option( COMPARTIR_WP__OPTIONS_GENERAL );

        if ( isset( $general_options['share_on_twitter'] )
            && $general_options['share_on_twitter'] === 'on' ) {
            compartir_wp__share_post_on_twitter( $post );
        }

        if ( isset( $general_options['share_on_facebook'] )
            && $general_options['share_on_facebook'] === 'on' ) {
            //  TODO: For finishing the part of facebook
        }

        compartir_wp__save_post_meta_auto_publish( $post->ID );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post_on_twitter' ) )
{
    /**
     * Share post on Twitter
     *
     * @param  WP_Post $post
     *
     * @return array|object
     */
    function compartir_wp__share_post_on_twitter( $post )
    {
        $media = null;

        if ( has_post_thumbnail( $post ) ) {
            $attached_file = get_attached_file( get_post_thumbnail_id( $post ) );
            $media = array( $attached_file );
        }

        return compartir_wp__publish_on_twitter_with_keys( $post->post_title, $media );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post_on_facebook' ) )
{
    /**
     * Share post on Facebook
     *
     * @param string $id User id, example: me
     * @param WP_Post $post
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_post_on_facebook( $id , $post )
    {
        $data = array(
            'link'  => get_the_permalink( $post )
        );

        return compartir_wp__publish_on_facebook_with_keys( $id, $data );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post_on_facebook_user' ) )
{
    /**
     * Share post on Facebook for user
     *
     * @param WP_Post $post
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_post_on_facebook_user(  $post )
    {
        return compartir_wp__share_post_on_facebook( 'me', $post );
    }
}

// ----------------------------------------------------------------------------------