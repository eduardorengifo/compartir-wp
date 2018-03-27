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