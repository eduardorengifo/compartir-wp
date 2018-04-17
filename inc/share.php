<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post' ) )
{
    /**
     * Share Post
     *
     * @param $post
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
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

            compartir_wp__share_post_on_facebook( $post );
        }

        compartir_wp__save_post_meta_auto_publish( $post->ID );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_on_twitter' ) )
{
    /**
     * Share on Twitter
     *
     * @param string $message
     * @param null|array $media
     *
     * @return array|object
     */
    function compartir_wp__share_on_twitter( $message, $media = null )
    {
        $parameters = array(
            'status'    => $message
        );

        return compartir_wp__publish_on_twitter_with_keys( $parameters, $media );
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

        return compartir_wp__share_on_twitter( $post->post_title, $media );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_on_facebook' ) )
{
    /**
     * Share on Facebook
     *
     * @param string $message
     * @param null|string $link
     * @param null|string $media
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_on_facebook( $message, $link = null, $media = null )
    {
        $general_options = get_option( COMPARTIR_WP__OPTIONS_GENERAL );

        if ( isset( $general_options['share_on_facebook']['user'] )
            && $general_options['share_on_facebook']['user'] === 'on' ) {

            compartir_wp__share_on_facebook_by_user( $message, $link, $media );
        }
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_post_on_facebook' ) )
{
    /**
     * Share post on Facebook
     *
     * @param  WP_Post $post
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_post_on_facebook( $post )
    {
        compartir_wp__share_on_facebook( $post->post_title, get_the_permalink( $post->ID ) );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_on_facebook_by_user' ) )
{
    /**
     * Share post on Facebook for user
     *
     * @param string $message
     * @param null|string $link
     * @param null|string $media
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_on_facebook_by_user( $message, $link = null, $media = null )
    {
        $parameters = array(
            'message'   => $message
        );

        if ( isset( $link ) && ! empty( $link ) && compartir_wp__valid_url( $link ) ) {
            $parameters['link'] = $link;
        }

        return compartir_wp__publish_on_facebook_with_keys( 'me', $parameters, $media );
    }
}

// ----------------------------------------------------------------------------------