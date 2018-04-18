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
        $title = str_replace( '-', ' ', $str );
        return ucwords( $title );
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

if ( ! function_exists( 'compartir_wp__get_groups_facebook' ) )
{
    /**
     * Get Groups Facebook
     *
     * @param string $id
     *
     * @return array|bool|null
     */
    function compartir_wp__get_groups_facebook( $id = 'me' )
    {
        try {
            $response_body_decode = compartir_wp__get_fan_pages_on_facebook_with_keys( $id );

            if ( isset( $response_body_decode['data'] )
                && ! empty( $response_body_decode['data'] ) ) {

                return array_map( function ( $item ) {
                    return array(
                        'id'            => $item['id'],
                        'name'          => $item['name'],
                        'text'          => $item['name'],
                        'access_token'  => $item['access_token']
                    );
                }, $response_body_decode['data'] );
            }

            return null;
        } catch ( Exception $e ) {
            return false;
        }
    }
}

// ----------------------------------------------------------------------------------