<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_twitter' ) )
{
    /**
     * Publish on Twitter
     *
     * @param array $keys
     * @param array $parameters
     * @param array[string] $media
     *
     * @return array|object
     */
    function compartir_wp__publish_on_twitter( $keys, $parameters = array(), $media = null )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $access_token = $keys['access_token'];
        $access_token_secret = $keys['access_token_secret'];
        $consumer_key = $keys['consumer_key'];
        $consumer_secret = $keys['consumer_secret'];

        $connection = new \Abraham\TwitterOAuth\TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

        if ( isset( $media ) && ! empty( $media ) && is_array( $media ) ) {

            $media_ids = array();
            foreach ( $media as $media_file ) {
                $upload = $connection->upload('media/upload', ['media' => $media_file] );
                if ( isset( $upload->media_id_string ) ) {
                    $media_ids[] = $upload->media_id_string;
                }
            }

            $parameters['media_ids'] = implode(',', $media_ids);
        }

        return $connection->post('statuses/update', $parameters);
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_twitter_with_keys' ) )
{
    /**
     * Publish on Twitter with Keys
     *
     * @param array $parameters
     * @param null|array $media
     *
     * @return array|object
     */
    function compartir_wp__publish_on_twitter_with_keys( $parameters, $media = null )
    {
        $twitter_options = get_option( COMPARTIR_WP__OPTIONS_TWITTER );

        $keys = array(
            'access_token'          => $twitter_options['access_token'],
            'access_token_secret'   => $twitter_options['access_token_secret'],
            'consumer_key'          => $twitter_options['consumer_key'],
            'consumer_secret'       => $twitter_options['consumer_secret']
        );

        return compartir_wp__publish_on_twitter( $keys, $parameters, $media );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_facebook' ) )
{
    /**
     * Publish on Facebook
     *
     * @param array $keys
     * @param string $id User id, example: me
     * @param array $parameters
     * @param null|string $media
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__publish_on_facebook( $keys, $id, $parameters, $media = null )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $fb = new \Facebook\Facebook([
            'app_id'                => $keys['app_id'],
            'app_secret'            => $keys['app_secret'],
            'default_graph_version' => 'v2.12',
        ]);

        if ( isset( $media ) && ! empty( $media ) && is_string( $media ) ) {
            $parameters['source'] = $fb->fileToUpload( $media );
        }

        $response = $fb->post( "/{$id}/feed", $parameters, $keys['token'] );
        return $response->getGraphNode();
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_facebook_with_keys' ) )
{
    /**
     * Publish on Facebook with Keys
     *
     * @param string $id
     * @param array $parameters
     * @param string $media
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__publish_on_facebook_with_keys( $id, $parameters, $media = null )
    {
        $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

        $keys = array(
            'app_id'        => $facebook_options['app_id'],
            'app_secret'    => $facebook_options['app_secret'],
            'token'         => $facebook_options['long_access_token']
        );

        return compartir_wp__publish_on_facebook( $keys, $id, $parameters, $media );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__facebook_batch_request' ) )
{
    /**
     * Facebook Batch Request
     *
     * @param array $keys
     * @param array $requests
     *
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__facebook_batch_request( $keys, $requests )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $fb = new \Facebook\Facebook([
            'app_id'                => $keys['app_id'],
            'app_secret'            => $keys['app_secret'],
            'default_graph_version' => 'v3.0',
        ]);

        $fb->setDefaultAccessToken( $keys['token'] );

        $batch = array();

        if ( isset( $requests )
            && ! empty( $requests )
            && is_array( $requests ) ) {

            foreach ( $requests as $request ) {

                $id = $request['id'];
                $token = ( isset( $request['token'] ) && ! empty( $request['token'] ) ) ? $request['token'] : $keys['token'];
                $parameters = $request['parameters'];
                $media = $request['media'];
                $method = $request['method'];

                if ( isset( $media )
                    && ! empty( $media )
                    && is_string( $media ) ) {

                    $parameters['source'] = $fb->fileToUpload( $media );
                }

                $batch["post-to-feed-{$id}"] = $fb->request( $method, "/{$id}/feed", $parameters, $token );
            }
        }

        $responses = $fb->sendBatchRequest( $batch );
        return $responses->getDecodedBody();
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__facebook_batch_request_with_keys' ) )
{
    /**
     * Facebook Batch Request with Keys
     *
     * @param array $requests
     *
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__facebook_batch_request_with_keys( $requests )
    {
        $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

        $keys = array(
            'app_id'        => $facebook_options['app_id'],
            'app_secret'    => $facebook_options['app_secret'],
            'token'         => $facebook_options['long_access_token']
        );

        return compartir_wp__facebook_batch_request( $keys, $requests );
    }
}

// ----------------------------------------------------------------------------------