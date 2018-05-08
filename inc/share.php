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
            && ! empty( $general_options['share_on_facebook'] ) ) {

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
        $link = get_the_permalink( $post->ID );
        $message = "{$post->post_title} {$link}";

        return compartir_wp__share_on_twitter( $message );
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

        if ( isset( $general_options['share_on_facebook']['fanpages'] )
            && $general_options['share_on_facebook']['fanpages'] === 'on' ) {

            compartir_wp__share_on_facebook_in_fan_pages( $message, $link, $media );
        }

        if ( isset( $general_options['share_on_facebook']['groups'] )
            && $general_options['share_on_facebook']['groups'] === 'on' ) {

            compartir_wp__share_on_facebook_in_groups( $message, $link, $media );
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

if ( ! function_exists( 'compartir_wp__share_on_facebook_in_fan_pages' ) )
{
    /**
     * Share on Facebook in Fan Pages
     *
     * @param string $message
     * @param null|string $link
     * @param null|string $media
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_on_facebook_in_fan_pages( $message, $link = null, $media = null )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

        $requests = array();

        if ( isset( $facebook_options['fan_pages'] )
            && ! empty( $facebook_options['fan_pages'] )
            && is_array( $facebook_options['fan_pages'] ) ) {

            foreach ( $facebook_options['fan_pages'] as $fan_page_id => $status ) {

                if ( $status == 'on' ) {


                    $items = compartir_wp__get_fan_pages_facebook();

                    if (isset($items)
                        && !empty($items)
                        && is_array($items)) {

                        foreach ($items as $item) {

                            if ($fan_page_id == $item['id']) {

                                $request = array(
                                    'method'        => 'POST',
                                    'id'            => $item['id'],
                                    'token'         => $item['access_token'],
                                    'parameters'    => array(
                                        'message'   => $message
                                    )
                                );

                                if (isset($link)
                                    && !empty($link)
                                    && compartir_wp__valid_url($link)) {

                                    $request['parameters']['link'] = $link;
                                }

                                $requests[] = $request;
                            }
                        }
                    }
                }


            }
        }

        if ( ! empty( $requests )
            && is_array( $requests ) ) {

            compartir_wp__facebook_batch_request_with_keys( $requests );
        }
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_on_facebook_in_groups' ) )
{
    /**
     * Share on Facebook in Groups
     *
     * @param string $message
     * @param null|string $link
     * @param null|string $media
     *
     * @return void
     */
    function compartir_wp__share_on_facebook_in_groups( $message, $link = null, $media = null )
    {
        // TODO: Finish as soon as facebook approves access to groups
    }
}

// ----------------------------------------------------------------------------------