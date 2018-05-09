<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__options_page') )
{
    /**
     * Compartir WP options page
     *
     * @return void
     */
    function compartir_wp__options_page()
    {
        // Add sub menu settings
        add_submenu_page(
            'options-general.php',
            COMPARTIR_WP__NAME,
            COMPARTIR_WP__NAME,
            'manage_options',
            COMPARTIR_WP__TEXT_DOMAIN,
            'compartir_wp__options_page_html'
        );
    }
}

// Register our compartir_wp__options_page to the admin_menu action hook
add_action( 'admin_menu', 'compartir_wp__options_page' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_list_admin_menu' ) )
{
    /**
     * Get list admin menu
     *
     * @return array
     */
    function compartir_wp__get_list_admin_menu()
    {
        return array( 'general', 'facebook', 'twitter', 'fast-publisher' );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_default_item_admin_menu' ) )
{
    /**
     * Get default item admin menu
     *
     * @return string
     */
    function compartir_wp__get_default_item_admin_menu()
    {
        return compartir_wp__get_list_admin_menu()[0];
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__get_tab_admin_nav') )
{
    /**
     * Get tab admin nav
     *
     * @return mixed|string
     */
    function compartir_wp__get_tab_admin_nav()
    {
        $item_default = compartir_wp__get_default_item_admin_menu();
        $items = compartir_wp__get_list_admin_menu();
        $tab = compatir_wp__get_query_var( 'tab', $item_default );
        return ( in_array( $tab, $items ) ) ? $tab : $item_default;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compatir_wp__tab_nav_html' ) )
{
    /**
     * Tab nav html
     *
     * @return void
     */
    function compatir_wp__admin_tab_nav_html()
    {
        $items = compartir_wp__get_list_admin_menu();

        $tab = compartir_wp__get_tab_admin_nav();

        $links = array_map( function ( $item ) use ( $tab ) {
            $tab_active = ( $item === $tab ) ? 'nav-tab-active' : '';

            return sprintf('<a href="./options-general.php?page=%s&tab=%s" class="nav-tab %s">%s</a>',
                COMPARTIR_WP__TEXT_DOMAIN,
                $item,
                $tab_active,
                compartir_wp__filter_title_admin_menu( $item )
            );
        }, $items );

        $links = implode( '', $links );

        printf( '<h2 class="nav-tab-wrapper">%s</h2>', $links );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__admin_form_html' ) )
{
    /**
     * Admin form html
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__admin_form_html()
    {
        $tab = compartir_wp__get_tab_admin_nav();
        $group = COMPARTIR_WP__TEXT_DOMAIN . "__{$tab}";

        switch ( $tab ) {
            case 'fast-publisher':
                $action = sprintf( 'options-general.php?page=%s&tab=%s',
                    COMPARTIR_WP__TEXT_DOMAIN,
                    'fast-publisher'
                );

                $text_submit_button = __( 'Publish', COMPARTIR_WP__TEXT_DOMAIN );

                compartir_wp__share_fast_publisher();
                break;
            default:
                $action = 'options.php';

                $text_submit_button = __( 'Save Settings', COMPARTIR_WP__TEXT_DOMAIN );
                break;
        }

        printf( '<form id="%s__form" action="%s" method="post">',
            COMPARTIR_WP__TEXT_DOMAIN,
            $action );

        // output security fields for the registered setting "compartir-wp"
        settings_fields( $group );
        // output setting sections and their fields
        // (sections are registered for "compartir-wp", each field is registered to a specific section)
        do_settings_sections( $group );
        // output save settings button
        submit_button( $text_submit_button );

        compartir_wp__e( '</form>' );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__admin_sidebar' ) )
{
    /**
     * Admin Sidebar
     *
     * @return void
     */
    function compartir_wp__admin_sidebar()
    {
        $html_doc = sprintf(
            '<h2><span>%s</span></h2>',
            esc_html__( 'Documentation', COMPARTIR_WP__TEXT_DOMAIN )
        );

        $links_doc = compartir_wp__array_to_html( array(
            array(
                'text'  => esc_html__( '1. Configure your Facebook application', COMPARTIR_WP__TEXT_DOMAIN ),
                'url'   => '#'
            ),
            array(
                'text'  => esc_html__( '2. Configure your Twitter application', COMPARTIR_WP__TEXT_DOMAIN ),
                'url'   => '#'
            ),
            array(
                'text'  => esc_html__( '3. Publish with Compartir WP plugin', COMPARTIR_WP__TEXT_DOMAIN ),
                'url'   => '#'
            )
        ) );

        $html_doc .= sprintf( '<div class="inside">%s</div><!-- .inside -->', $links_doc );

        printf( '<div class="postbox">%s</div><!-- .postbox -->', $html_doc );


        $html_shop = sprintf(
            '<h2><span>%s</span></h2>',
            esc_html__( 'Desarrolla.tech', COMPARTIR_WP__TEXT_DOMAIN )
        );

        $links_shop = compartir_wp__array_to_html( array(
            array(
                'text'  => esc_html__( 'Shop', COMPARTIR_WP__TEXT_DOMAIN ),
                'url'   => 'https://shop.desarrolla.tech'
            ),
            array(
                'text'  => esc_html__( 'Compartir WP in store', COMPARTIR_WP__TEXT_DOMAIN ),
                'url'   => 'https://shop.desarrolla.tech/item/compartir-wp/'
            )
        ) );

        $html_shop .= sprintf( '<div class="inside">%s</div><!-- .inside -->', $links_shop );

        printf( '<div class="postbox">%s</div><!-- .postbox -->', $html_shop );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__options_page_html' ) )
{
    /**
     * Compartir WP options page html
     *
     * @link https://codex.wordpress.org/Creating_Options_Pages
     *
     * @return void
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    function compartir_wp__options_page_html() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        } ?>
        <style type="text/css">
            .wrap form#compartir-wp__form h2,
            .wrap form#compartir-wp__form .compartir-wp__spacing_field_section{
                display: none;
            }
            .compartir_wp__row input {
                margin-right: 5px;
            }
        </style>
        <div class="wrap">
            <?php
            printf( '<h1>%s</h1>', esc_html__( get_admin_page_title() ) );
            compatir_wp__admin_tab_nav_html(); ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <!-- main content -->
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <?php compartir_wp__admin_form_html(); ?>
                        </div>
                        <!-- .meta-box-sortables .ui-sortable -->
                    </div>
                    <!-- post-body-content -->
                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">
                        <div class="meta-box-sortables">
                            <?php compartir_wp__admin_sidebar(); ?>
                        </div>
                        <!-- .meta-box-sortables -->
                    </div>
                    <!-- #postbox-container-1 .postbox-container -->
                </div>
                <!-- #post-body .metabox-holder .columns-2 -->
                <br class="clear">
            </div>
            <!-- #poststuff -->
        </div>
        <?php
    }
}

// ----------------------------------------------------------------------------------