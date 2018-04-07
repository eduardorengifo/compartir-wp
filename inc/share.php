<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

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
        $twitter_options = get_option( COMPARTIR_WP__OPTIONS_TWITTER );

        $keys = array(
            'access_token'          => $twitter_options['access_token'],
            'access_token_secret'   => $twitter_options['access_token_secret'],
            'consumer_key'          => $twitter_options['customer_key'],
            'consumer_secret'       => $twitter_options['customer_secret']
        );

        $media = null;

        if ( has_post_thumbnail( $post ) ) {
            $attached_file = get_attached_file( get_post_thumbnail_id( $post ) );
            $media = array( $attached_file );
        }

        return compartir_wp__publish_on_twitter( $keys, $post->post_title, $media );
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
        $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

        $keys = array(
            'app_id'        => $facebook_options['app_id'],
            'app_secret'    => $facebook_options['app_secret'],
            'tocken'        => $facebook_options['tocken']
        );

        $data = array(
            'link'  => get_the_permalink( $post )
        );

        return compartir_wp__publish_on_facebook( $keys, $id, $data );
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