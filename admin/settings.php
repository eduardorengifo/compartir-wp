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
        $general_section_id = 'compartir_wp__register_general_settings';
        $general_section_field = 'compartir_wp__general_field';
        $general_section_page = 'compartir-wp__general';
        $general_section_option_name = COMPARTIR_WP__OPTIONS . '_general';

        register_setting( $general_section_page, $general_section_option_name );

        // Register a new section in the "compatir-wp" page
        add_settings_section(
            $general_section_id,
            __( 'General Settings', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_section',
            $general_section_page
        );

        // Register "Auto Publish" field for "General Settings"
        add_settings_field(
            "{$general_section_field}_auto_publish",
            __( 'Auto Publish', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_checkbox',
            $general_section_page,
            $general_section_id,
            array(
                'option_name'   => $general_section_option_name,
                'label_for'     => "{$general_section_field}_auto_publish",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Activate to share each new post that is published in future.', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__register_facebook_settings' ) )
{
    function compartir_wp__register_facebook_settings()
    {
        $facebook_section_id = 'compartir_wp__section_facebook_settings';
        $facebook_section_field = 'compartir_wp__facebook_field';
        $facebook_section_page = 'compartir-wp__facebook';

        $facebook_section_option_name = COMPARTIR_WP__OPTIONS . '_facebook';

        register_setting( $facebook_section_page, $facebook_section_option_name );

        // Register a new section in the "compartir-wp" page
        add_settings_section(
            $facebook_section_id,
            __( 'Facebook Settings', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_section',
            $facebook_section_page
        );

        // Register "Facebook App ID" field for "Facebook Settings"
        add_settings_field(
            "{$facebook_section_field}_app_id",
            __( 'App ID', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $facebook_section_page,
            $facebook_section_id,
            array(
                'option_name'   => $facebook_section_option_name,
                'label_for'     => "{$facebook_section_field}_app_id",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'You can get it in the configuration of your facebook application. <a href="https://developers.facebook.com/apps" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Facebook App Secret" field for "Facebook Settings"
        add_settings_field(
            "{$facebook_section_field}_app_secret",
            __( 'App Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $facebook_section_page,
            $facebook_section_id,
            array(
                'option_name'  => $facebook_section_option_name,
                'label_for'     => "{$facebook_section_field}_app_secret",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'You can get it in the configuration of your facebook application. <a href="https://developers.facebook.com/apps" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Facebook Long Access Token" field for "Facebook Settings"
        add_settings_field(
            "{$facebook_section_field}_long_access_token",
            __( 'Long Access Token', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $facebook_section_page,
            $facebook_section_id,
            array(
                'option_name'   => $facebook_section_option_name,
                'label_for'     => "{$facebook_section_field}_long_access_token",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Use the tools of facebook. <a href="https://developers.facebook.com/tools/explorer/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Facebook Fan Pages IDs" field for "Facebook Settings"
        add_settings_field(
            "{$facebook_section_field}_fan_pages_ids",
            __( 'FanPages IDs', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_textarea',
            $facebook_section_page,
            $facebook_section_id,
            array(
                'option_name'   => $facebook_section_option_name,
                'label_for'     => "{$facebook_section_field}_fans_pages_ids",
                'class'         => 'compartir_wp__row',
                'description'   => __( 'Add the ID of each Fan Page where you are the administrator separated by commas. Example: xxxxxxxx, yyyyyyyy, zzzzzzzz', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Facebook Groups IDs" field for "Facebook Settings"
        add_settings_field(
            "{$facebook_section_field}_groups_ids",
            __( 'Groups IDs', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_textarea',
            $facebook_section_page,
            $facebook_section_id,
            array(
                'option_name'   => $facebook_section_option_name,
                'label_for'     => "{$facebook_section_field}_groups_ids",
                'class'         => 'compartir_wp__row',
                'description'   => __( 'Add the ID of each group where you are the administrator separated by commas. Example: xxxxxxxx, yyyyyyyy, zzzzzzzz', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__register_twitter_settings') )
{
    function compartir_wp__register_twitter_settings()
    {
        $twitter_section_id = 'compartir_wp__section_twitter_settings';
        $twitter_section_field = 'compartir_wp__twitter_field';
        $twitter_section_page = 'compartir-wp__twitter';

        $twitter_section_option_name = COMPARTIR_WP__OPTIONS . '_twitter';

        register_setting( $twitter_section_page, $twitter_section_option_name );

        // Register "Twitter Settings" section in "compartir-wp" page
        add_settings_section(
            $twitter_section_id,
            __( 'Twitter Settings', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_section',
            $twitter_section_page
        );


        // Register Twitter Access Token field for "Twitter Settings"
        add_settings_field(
            "{$twitter_section_field}_access_token",
            __( 'Access Token', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $twitter_section_page,
            $twitter_section_id,
            array(
                'option_name'  => $twitter_section_option_name,
                'label_for'     => "{$twitter_section_field}_access_token",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Twitter Access Token Secret" field for "Twitter Settings"
        add_settings_field(
            "{$twitter_section_field}_access_token_secret",
            __( 'Access Token Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $twitter_section_page,
            $twitter_section_id,
            array(
                'option_name'  => $twitter_section_option_name,
                'label_for'     => "{$twitter_section_field}_access_token_secret",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Twitter Consumer Key" field for "Twitter Settings"
        add_settings_field(
            "{$twitter_section_field}_consumer_key",
            __( 'Consumer Key', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $twitter_section_page,
            $twitter_section_id,
            array(
                'option_name'  => $twitter_section_option_name,
                'label_for'     => "{$twitter_section_field}_consumer_key",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );

        // Register "Twitter Consumer Secret" field for "Twitter Settings"
        add_settings_field(
            "{$twitter_section_field}_consumer_secret",
            __( 'Consumer Secret', COMPARTIR_WP__TEXT_DOMAIN ),
            'compartir_wp__field_text',
            $twitter_section_page,
            $twitter_section_id,
            array(
                'option_name'  => $twitter_section_option_name,
                'label_for'     => "{$twitter_section_field}_consumer_secret",
                'class'         => 'compartir_wp__row',
                'text'          => __( 'Required', COMPARTIR_WP__TEXT_DOMAIN ),
                'description'   => __( 'Create your twitter application and get the keys. <a href="https://apps.twitter.com/app/" target="_blank">Link</a>', COMPARTIR_WP__TEXT_DOMAIN )
            )
        );
    }
}

// ----------------------------------------------------------------------------------