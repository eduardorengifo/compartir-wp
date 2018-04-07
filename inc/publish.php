<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__publish_on_twitter' ) )
{
    /**
     * Publish on Twitter
     *
     * @param array[string] $keys
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