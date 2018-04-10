<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__settings_init' ) )
{
    /**
     * Custom option and settings
     *
     * @return void
     */
    function compartir_wp__settings_init()
    {
        compartir_wp__register_general_settings();
        compartir_wp__register_facebook_settings();
        compartir_wp__register_twitter_settings();
        compartir_wp__register_fast_publisher_settings();
    }
}

// Register our compartir_wp__settings_init to the admin_init action hook
add_action( 'admin_init', 'compartir_wp__settings_init' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__register_general_settings' ) )
{
    /**
     * Register General Settings
     *
     * @return void
     */
    function compartir_wp__register_general_settings()
    {
        $page = 'general';

        // Register General Settings
        compartir_wp__register_settings( $page, COMPARTIR_WP__OPTIONS_GENERAL );

        // Add General Settings Section
        compartir_wp__add_settings_section(
            $page,
            __( "General Settings", COMPARTIR_WP__TEXT_DOMAIN ),
            'section'
        );

        // Add Auto Publish Field
        compartir_wp__add_settings_field(
            'auto_publish',
            __( 'Auto Publish', COMPARTIR_WP__TEXT_DOMAIN ),
            'checkbox',
            $page,
            array(
                'text'  => __( 'Activate to share each new post that is published in future.', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__register_facebook_settings' ) )
{
    /**
     * Register Facebook Settings
     *
     * @return void
     */
    function compartir_wp__register_facebook_settings()
    {
        $page = 'facebook';

        // Register Facebook Settings
        compartir_wp__register_settings( $page, COMPARTIR_WP__OPTIONS_FACEBOOK );

        // Add Facebook Settings Section
        compartir_wp__add_settings_section(
            $page,
            __( 'Facebook Settings', COMPARTIR_WP__TEXT_DOMAIN ),
            'section'
        );

        // Add App ID Field
        compartir_wp__add_settings_field(
            'app_id',
            __( 'App ID', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'You can get it in the configuration of your facebook application. <a href="https://developers.facebook.com/apps" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add App Secret Field
        compartir_wp__add_settings_field(
            'app_secret',
            __( 'App Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'You can get it in the configuration of your facebook application. <a href="https://developers.facebook.com/apps" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add Long Access Token Field
        compartir_wp__add_settings_field(
            'long_access_token',
            __( 'Long Access Token', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Use the tools of facebook. <a href="https://developers.facebook.com/tools/explorer/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add FanPages IDs Field
        compartir_wp__add_settings_field(
            'fan_pages_ids',
            __( 'FanPages IDs', COMPARTIR_WP__TEXT_DOMAIN ),
            'textarea',
            $page,
            array(
                'description'   => __( 'Add the ID of each Fan Page where you are the administrator separated by commas. Example: xxxxxxxx, yyyyyyyy, zzzzzzzz', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add Groups IDs Field
        compartir_wp__add_settings_field(
            'groups_ids',
            __( 'Groups IDs', COMPARTIR_WP__TEXT_DOMAIN ),
            'textarea',
            $page,
            array(
                'description'   => __( 'Add the ID of each group where you are the administrator separated by commas. Example: xxxxxxxx, yyyyyyyy, zzzzzzzz', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__register_twitter_settings') )
{
    /**
     * Register Twitter Settings
     *
     * @return void
     */
    function compartir_wp__register_twitter_settings()
    {
        $page = 'twitter';

        // Register Twitter Settings
        compartir_wp__register_settings( $page, COMPARTIR_WP__OPTIONS_TWITTER );

        // Add Twitter Settings Section
        compartir_wp__add_settings_section(
            $page,
            __( 'Twitter Settings', COMPARTIR_WP__TEXT_DOMAIN ),
            'section'
        );

        // Add Access Token Field
        compartir_wp__add_settings_field(
            'access_token',
            __( 'Access Token', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add Access Token Secret Field
        compartir_wp__add_settings_field(
            'access_token_secret',
            __( 'Access Token Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add Consumer Key Field
        compartir_wp__add_settings_field(
            'consumer_key',
            __( 'Consumer Key', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Add Consumer Secret Field
        compartir_wp__add_settings_field(
            'consumer_secret',
            __( 'Consumer Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'text',
            $page,
            array(
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__register_fast_publisher_settings' ) )
{
    /**
     * Register Fast Publisher Settings
     *
     * @return void
     */
    function compartir_wp__register_fast_publisher_settings()
    {

        //$section = 'fast-publisher_settings';
        $page = 'fast-publisher';

        // Register Settings
        compartir_wp__register_settings( $page, COMPARTIR_WP__OPTIONS_FAST_PUBLISHER );

        // Register "Fast Publisher Settings" section in "compartir-wp" page
       compartir_wp__add_settings_section(
           $page,
           __( 'Fast Settings', COMPARTIR_WP__TEXT_DOMAIN ),
           'section'
       );

       // Add field
        compartir_wp__add_settings_field(
            'message',
            __( 'Message', COMPARTIR_WP__TEXT_DOMAIN ),
            'textarea',
            $page,
            array(
                'description'   => esc_html__( 'Description', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------