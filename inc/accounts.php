<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_fan_pages_on_facebook' ) )
{
    /**
     * Get Fan Pages on Facebook
     *
     * @param array $keys
     * @param string $id User id, example: me
     *
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__get_fan_pages_on_facebook( $keys, $id )
    {
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $fb = new Facebook\Facebook([
            'app_id'                => $keys['app_id'],
            'app_secret'            => $keys['app_secret'],
            'default_graph_version' => 'v2.12'
        ]);

        // Returns a `FacebookFacebookResponse` object
        $response = $fb->get(
            "/{$id}/accounts?fields=id,name,access_token&limit=1000",
            $keys['token']
        );

        return $response->getDecodedBody();
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_fan_pages_on_facebook_with_keys' ) )
{
    /**
     * Get Fan Pages on Facebook with Keys
     *
     * @param string $id User id, example: me
     *
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__get_fan_pages_on_facebook_with_keys( $id )
    {
        $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

        $keys = array(
            'app_id'        => $facebook_options['app_id'],
            'app_secret'    => $facebook_options['app_secret'],
            'token'         => $facebook_options['long_access_token']
        );

        return compartir_wp__get_fan_pages_on_facebook( $keys, $id );
    }
}

// ----------------------------------------------------------------------------------