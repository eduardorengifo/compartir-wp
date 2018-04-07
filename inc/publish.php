<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_twitter' ) )
{
    /**
     * Publish on Twitter
     *
     * @param array $keys
     * @param string $status
     * @param array[string] $media
     *
     * @return array|object
     */
    function compartir_wp__publish_on_twitter( $keys, $status, $media = null )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $access_token = $keys['access_token'];
        $access_token_secret = $keys['access_token_secret'];
        $consumer_key = $keys['consumer_key'];
        $consumer_secret = $keys['consumer_secret'];

        $connection = new \Abraham\TwitterOAuth\TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

        $parameters = array(
            'status'    => $status
        );

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

if ( ! function_exists( 'compartir_wp__publish_on_facebook' ) )
{
    /**
     * Publish on Facebook
     *
     * @param array $keys
     * @param string $id User id, example: me
     * @param array[] $data
     *
     * @return \Facebook\GraphNodes\GraphNode
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__publish_on_facebook( $keys, $id, $data )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $fb = new \Facebook\Facebook([
            'app_id'                => $keys['app_id'],
            'app_secret'            => $keys['app_secret'],
            'default_graph_version' => 'v2.12',
        ]);

        try {
            $response = $fb->post( "/{$id}/feed", $data, $keys['tocken'] );
        } catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $response->getGraphNode();
    }
}

// ----------------------------------------------------------------------------------