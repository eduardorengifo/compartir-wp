<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compatir_wp__get_query_var' ) )
{
    /**
     * Get Query Var
     *
     * @param string $var
     * @param mixed $default
     *
     * @return mixed
     */
    function compatir_wp__get_query_var( $var, $default = '' )
    {
        $value = @$_GET[$var];
        return ( isset( $value ) && ! empty( $value ) ) ? $value : $default;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__add_or_update_post_meta' ) )
{
    /**
     * Add or Update post meta
     *
     * @param int $post_id
     * @param string $meta_key
     * @param string $meta_value
     *
     * @return void
     */
    function compartir_wp__add_or_update_post_meta( $post_id, $meta_key, $meta_value )
    {
        if ( ! add_post_meta( $post_id, $meta_key, $meta_value, true ) )
        {
            update_post_meta( $post_id, $meta_key, $meta_value );
        }
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_post_meta_auto_publish' ) )
{
    /**
     * Post meta auto publish
     *
     * @param string|int $post_id
     *
     * @return int
     */
    function compartir_wp__get_post_meta_auto_publish( $post_id )
    {
        $value = get_post_meta( $post_id, 'compartir_wp__auto_publish_count', true );
        $value = ( is_numeric( $value ) ) ? $value : 0;
        return (int) $value;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__save_post_meta_auto_publish' ) )
{
    /**
     * Save post meta auto publish
     *
     * @param string|int $post_id
     *
     * @return void
     */
    function compartir_wp__save_post_meta_auto_publish( $post_id )
    {
        $value = get_post_meta( $post_id, 'compartir_wp__auto_publish_count', true );
        $value = ( is_numeric( $value ) ) ? $value + 1 : 1;

        compartir_wp__add_or_update_post_meta( $post_id, 'compartir_wp__auto_publish_count', $value );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__e' ) )
{
    /**
     * Print value
     *
     * @param string|int $value
     *
     * @return void
     */
    function compartir_wp__e( $value ) {
        echo $value;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__sanetize_title_admin_menu' ) )
{
    /**
     * Filter title admin menu
     *
     * @param string $str
     *
     * @return string
     */
    function compartir_wp__filter_title_admin_menu( $str )
    {
        switch ( $str ) {
            case 'fast-publisher':
                $title = esc_html__( 'Fast Publisher', COMPARTIR_WP__TEXT_DOMAIN );

                break;
            default:
                $title = str_replace( '-', ' ', $str );
                $title = ucwords( $title );
                break;
        }

        return $title;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__valid_url' ) )
{
    /**
     * Valid URL
     *
     * @param string $url
     * @return bool
     */
    function compartir_wp__valid_url( $url )
    {
        return filter_var( $url, FILTER_VALIDATE_URL );
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_fan_pages_facebook' ) )
{
    /**
     * Get Fans Page Facebook
     *
     * @param string $id
     *
     * @return array|bool|null
     */
    function compartir_wp__get_fan_pages_facebook( $id = 'me' )
    {
        try {

            $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

            if ( isset( $facebook_options['app_id'], $facebook_options['app_secret'], $facebook_options['long_access_token'] ) ) {
                $response_body_decode = compartir_wp__get_fan_pages_on_facebook_with_keys( $id );

                if ( isset( $response_body_decode['data'] )
                    && ! empty( $response_body_decode['data'] ) ) {

                    return array_map(function ($item) {
                        return array(
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'text' => $item['name'],
                            'access_token' => $item['access_token']
                        );
                    }, $response_body_decode['data'] );
                }
            }

            return null;
        } catch ( Exception $e ) {
            return false;
        }
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_groups_facebook' ) )
{
    /**
     * Get Groups facebook
     *
     * @param string $id
     *
     * @return array|bool|null
     */
    function compartir_wp__get_groups_facebook( $id = 'me' )
    {
        try {

            $facebook_options = get_option( COMPARTIR_WP__OPTIONS_FACEBOOK );

            if ( isset( $facebook_options['app_id'], $facebook_options['app_secret'], $facebook_options['long_access_token'] ) ) {
                $response_body_decode = compartir_wp__get_groups_on_facebook_with_keys( $id );

                if ( isset( $response_body_decode['data'] )
                    && ! empty( $response_body_decode['data'] ) ) {

                    return array_map(function ($item) {
                        return array(
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'text' => $item['name']
                        );
                    }, $response_body_decode['data'] );
                }
            }

            return null;

        } catch ( Exception $e ) {
            return false;
        }
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__get_post_hashtags_by_tags' ) )
{
    /**
     * Get post hashtags by tags
     *
     * @param int $post_id
     *
     * @return null|string
     */
    function compartir_wp__get_post_hashtags_by_tags( $post_id = 0 )
    {
        $tags_list = wp_get_post_tags( $post_id, array( 'fields' => 'names' ) );

        if ( ! empty( $tags_list ) && is_array( $tags_list ) ) {

            $tags_list = array_map( function ( $tag ) {
                $tag = trim( $tag );
                $tag = sanitize_title( $tag );
                $tag = str_replace( array( '-', ' ' ), '', $tag );
                $tag = "#{$tag}";

                return $tag;
            }, $tags_list );

            if ( ! empty( $tags_list ) && is_array( $tags_list ) )
            {
                return implode( ' ', $tags_list );
            }

            return null;
        }

        return null;
    }
}

// ----------------------------------------------------------------------------------