<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__submitbox_post_field' ) )
{
    /**
     * @return void
     */
    function compartir_wp__submitbox_post_field()
    {
        global $post;

        $value = compartir_wp__get_post_meta_auto_publish( $post->ID );

        printf( '<div class="misc-pub-section">%s <span id="post-visibility-display">%s</span></div>',
            esc_attr__( 'Number of shares:', COMPARTIR_WP__TEXT_DOMAIN ),
            $value );

        printf( '<div class="misc-pub-section"><label><input type="checkbox" name="%s" value="1"/> %s</label></div>',
            'compartir_wp__auto_publish_count',
            esc_html__( 'Share with Compartir WP', COMPARTIR_WP__TEXT_DOMAIN ) );
    }
}

add_action( 'post_submitbox_misc_actions', 'compartir_wp__submitbox_post_field' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__submitbox_save_auto_publish_count' ) )
{
    function compartir_wp__submitbox_save_auto_publish_count( $post_id )
    {
        /* check if this is an autosave */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;

        /* check if the user can edit this page */
        if ( ! current_user_can( 'edit_page', $post_id ) ) return false;

        /* check if there's a post id and check if this is a post */
        /* make sure this is the same post type as above */
        // TODO: por terminar ya que se tiene que configurar para tipo post y page

        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        // create a log channel
        $log = new \Monolog\Logger('name');
        $log->pushHandler(new \Monolog\Handler\StreamHandler(COMPARTIR_WP__PLUGIN_DIR . 'compartir-wp.log', \Monolog\Logger::INFO));

        // add records to the log
        $log->info( 'Post', $_POST );

        if(empty($post_id) || $_POST['post_type'] != 'post' ) return false;

        /* if you are going to use text fields, then you should change the part below */
        /* use add_post_meta, update_post_meta and delete_post_meta, to control the stored value */

        /* check if the custom field is submitted (checkboxes that aren't marked, aren't submitted) */
        if( isset( $_POST['compartir_wp__auto_publish_count'] ) && $_POST['compartir_wp__auto_publish_count'] == '1' ) {

            $value = get_post_meta( $post_id, 'compartir_wp__auto_publish_count', true );
            $value = ( is_numeric( $value ) ) ? $value + 1 : 0;

            /* store the value in the database */
            compartir_wp__add_or_update_post_meta( $post_id, 'compartir_wp__auto_publish_count', $value );
        }
    }
}

// add_action( 'save_post', 'compartir_wp__submitbox_save_auto_publish_count' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__transition' ) )
{
    /**
     * @param WP_Post $post
     * @throws Exception
     */
    function compartir_wp__transition( $post )
    {
        // Your code transition
        // TODO: Listo para remplazar a compartir_wp__submitbox_save_auto_publish_count
        require_once( COMPARTIR_WP__PLUGIN_DIR . 'vendor/autoload.php' );

        $log = new \Monolog\Logger('name');
        $log->pushHandler(new \Monolog\Handler\StreamHandler(COMPARTIR_WP__PLUGIN_DIR . 'compartir-wp.log', \Monolog\Logger::INFO));

        $data = array(
            'post_id'       => $post->ID,
            'post_title'    => $post->post_title,
            'post_type'     => $post->post_type,
            'post_date'     => $post->post_date
        );

        // add records to the log
        $log->info( 'Post New: ', $_POST );
    }
}

add_action( 'publish_to_publish', 'compartir_wp__transition', 10, 1 );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__set_custom_edit_columns' ) )
{
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
                $shared_times = get_post_meta($post_id, 'compartir_wp__auto_publish_count', true);
                $shared_times = ( is_numeric( $shared_times ) ) ? $shared_times : '0';
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