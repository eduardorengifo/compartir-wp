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
        return array( 'general', 'facebook', 'twitter' );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_default_item_admin_menu' ) )
{
    /**
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
     * @return void
     */
    function compatir_wp__tab_nav_html()
    {
        $items = compartir_wp__get_list_admin_menu();
        $tab = compartir_wp__get_tab_admin_nav();
        $links = array_map( function ( $item ) use ( $tab ) {
            $tab_active = ( $item === $tab ) ? 'nav-tab-active' : '';
            return sprintf('<a href="./options-general.php?page=compartir-wp&tab=%s" class="nav-tab %s">%s</a>', $item, $tab_active, ucfirst( $item ) );
        }, $items );
        $links = implode( '', $links );
        printf( '<h2 class="nav-tab-wrapper">%s</h2>', $links );
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
        $html = sprintf( '<h2><span>%s</span></h2>',
            esc_attr__( 'Sidebar Content Header', COMPARTIR_WP__TEXT_DOMAIN ) );

        $html .= sprintf( '<div class="inside"><p>%s</p></div><!-- .inside -->',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' );

        printf( '<div class="postbox">%s</div><!-- .postbox -->', $html );
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
     */
    function compartir_wp__options_page_html() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = compartir_wp__get_tab_admin_nav();
        $group = "compartir-wp__{$tab}"; ?>
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
            compatir_wp__tab_nav_html(); ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <!-- main content -->
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form id="compartir-wp__form" action="options.php" method="post">
                                <?php
                                // output security fields for the registered setting "compartir-wp"
                                settings_fields( $group );
                                // output setting sections and their fields
                                // (sections are registered for "compartir-wp", each field is registered to a specific section)
                                do_settings_sections( $group );
                                // output save settings button
                                submit_button( __( 'Save Settings', COMPARTIR_WP__TEXT_DOMAIN ) );
                                ?>
                            </form>
                        </div>
                        <!-- .meta-box-sortables .ui-sortable -->
                    </div>
                    <!-- post-body-content -->
                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">
                        <div class="meta-box-sortables">
                            <?php // TODO: Sidebar pending to activate compartir_wp__admin_sidebar(); ?>
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