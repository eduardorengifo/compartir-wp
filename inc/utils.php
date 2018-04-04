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

if (! function_exists('compartir_wp__add_or_update_post_meta'))
{
    /**
     * @param int $post_id
     * @param string $meta_key
     * @param string $meta_value
     *
     * @return void
     */
    function compartir_wp__add_or_update_post_meta($post_id, $meta_key, $meta_value)
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
     * @param string|int $post_id
     * @return int
     */
    function compartir_wp__get_post_meta_auto_publish( $post_id )
    {
        $value = get_post_meta($post_id, 'compartir_wp__auto_publish_count', true);
        $value = ( is_numeric( $value ) ) ? $value : 0;
        return (int) $value;
    }
}

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__save_post_meta_auto_publish' ) )
{
    /**
     * @param string|int $post_id
     *
     * @return void
     */
    function compartir_wp__save_post_meta_auto_publish( $post_id )
    {
        $value = get_post_meta( $post_id, 'compartir_wp__auto_publish_count', true );
        $value = ( is_numeric( $value ) ) ? $value + 1 : 0;

        compartir_wp__add_or_update_post_meta( $post_id, 'compartir_wp__auto_publish_count', $value );
    }
}

// ----------------------------------------------------------------------------------