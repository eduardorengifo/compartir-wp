<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__register_settings' ) )
{
    /**
     * Register a setting and its data for Compartir WP.
     *
     * @param string $page
     * @param string $option_name
     * @param array $args
     *
     * @return void
     */
    function compartir_wp__register_settings( $page, $option_name, $args = array() )
    {
        $option_group = esc_html( "compartir-wp__{$page}" );
        $option_name = esc_html( $option_name );

        // Register setting
        register_setting( $option_group, $option_name, $args );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__add_settings_section' ) )
{
    /**
     * Add a new section to a settings page for Compartir WP.
     *
     * @param string $page
     * @param string $title
     * @param string $field
     *
     * @return void
     */
    function compartir_wp__add_settings_section( $page, $title, $field )
    {
        // Add settings section
        add_settings_section(
            esc_html( "compartir_wp__register_{$page}_settings" ),
            esc_html( $title ),
            esc_html( "compartir_wp__field_{$field}" ),
            esc_html( "compartir-wp__{$page}" )
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__add_settings_field' ) )
{
    /**
     * Add a new field to a section of a settings page for Compartir WP.
     *
     * @param string $id
     * @param string $title
     * @param string $field
     * @param string $page
     * @param array $params
     *
     * @return void
     */
    function compartir_wp__add_settings_field( $id, $title, $field, $page, $params = array() )
    {
        $params['option_name'] = COMPARTIR_WP__OPTIONS . "_{$page}";
        $params['label_for'] = $id;
        $params['class'] = 'compartir_wp__row';

        // Add settings field
        add_settings_field(
            esc_html( $id ),
            esc_html( $title ),
            esc_html( "compartir_wp__field_{$field}" ),
            esc_html( "compartir-wp__{$page}" ),
            esc_html( "compartir_wp__register_{$page}_settings" ),
            $params
        );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__share_fast_publisher' ) )
{
    /**
     * Share Fast Publisher
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__share_fast_publisher()
    {
        if ( empty( $_POST )
            || ! isset( $_POST['compartir_wp__options_fast-publisher'] ) ) {
            return;
        }

        $options_form = $_POST['compartir_wp__options_fast-publisher'];

        if ( ! isset( $options_form['message'] )
            || empty( $options_form['message'] ) ) {
            return;
        }

        $link = null;

        if ( isset( $options_form['link'] )
            && ! empty( $options_form['link'] )
            && compartir_wp__valid_url( $options_form['link'] ) ) {
            $link = $options_form['link'];
        }

        $general_options = get_option( COMPARTIR_WP__OPTIONS_GENERAL );

        if ( isset( $general_options['share_on_twitter'] )
            && $general_options['share_on_twitter'] === 'on' ) {

            $message = $options_form['message'];

            if ( compartir_wp__valid_url( $link ) ) {
                $message .= " {$link}";
            }

            compartir_wp__share_on_twitter( $message );
        }

        if ( isset( $general_options['share_on_facebook'] )
            && ! empty( $general_options['share_on_facebook'] ) ) {

            compartir_wp__share_on_facebook( $options_form['message'], $link );
        }
    }
}

// ----------------------------------------------------------------------------------