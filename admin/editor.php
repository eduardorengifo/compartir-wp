<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__submitbox_post_field' ) )
{
    /**
     * Submitbox Post Field
     *
     * @return void
     */
    function compartir_wp__submitbox_post_field()
    {
        global $post;

        $value = compartir_wp__get_post_meta_auto_publish( $post->ID );

        printf( '<div class="misc-pub-section">%s: <span id="post-visibility-display">%s %s</span></div>',
            COMPARTIR_WP__NAME,
            $value,
            esc_attr__( 'times shared', COMPARTIR_WP__TEXT_DOMAIN )
        );

        printf( '<div class="misc-pub-section"><label><input type="checkbox" name="%s" value="1"/> %s</label></div>',
            'compartir_wp__auto_publish_count',
            esc_html__( 'Share with Compartir WP', COMPARTIR_WP__TEXT_DOMAIN )
        );
    }
}

add_action( 'post_submitbox_misc_actions', 'compartir_wp__submitbox_post_field' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__set_custom_edit_columns' ) )
{
    /**
     * Custom edit columns by Compartir WP
     *
     * @param $columns
     *
     * @return mixed
     */
    function compartir_wp__set_custom_edit_columns( $columns )
    {
        $share_html = '<span class="dashicons dashicons-share"><span class="screen-reader-text">%s</span></span>';
        $columns[COMPARTIR_WP__TEXT_DOMAIN] = sprintf( $share_html, COMPARTIR_WP__NAME );

        return $columns;
    }
}

add_filter( 'manage_posts_columns', 'compartir_wp__set_custom_edit_columns' );
add_filter( 'manage_pages_columns', 'compartir_wp__set_custom_edit_columns' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__custom_column' ) )
{
    /**
     * Custon Column by Compartir WP
     *
     * @param $column
     * @param $post_id
     *
     * @return void
     */
    function compartir_wp__custom_column( $column, $post_id )
    {
        switch ( $column ) {
            case COMPARTIR_WP__TEXT_DOMAIN: ?>
                <style>
                    th#compartir-wp {
                        width: 3em;
                        padding: 8px 10px;
                        text-align: left;
                    }
                    .compartir-wp_icon_circle {
                        display: inline-block;
                        width: 12px;
                        height: 12px;
                        margin-left: 5px;
                        border-radius: 50%;
                        background-color: #888;
                        line-height: 16px;
                        margin-top: 3px;
                    }
                    .compartir-wp_icon_circle.active  {
                        background-color: #79d03a;
                    }
                </style>
                <?php
                $shared_times = compartir_wp__get_post_meta_auto_publish( $post_id );
                $active = ( $shared_times > 0 ) ? 'active' : '';

                printf( '<div aria-hidden="true" title="%s %s" class="compartir-wp_icon_circle %s"></div>',
                    esc_attr__( 'Number of shares:', COMPARTIR_WP__TEXT_DOMAIN ),
                    $shared_times,
                    $active );
                break;
        }
    }
}

add_action( 'manage_posts_custom_column' , 'compartir_wp__custom_column', 10, 2 );
add_action( 'manage_pages_custom_column' , 'compartir_wp__custom_column', 10, 2 );

// ----------------------------------------------------------------------------------