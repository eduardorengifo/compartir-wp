<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists('compartir_wp__field_textarea') )
{
    /**
     * Field Textarea
     *
     * @param $args
     *
     * @return void
     */
    function compartir_wp__field_textarea( $args )
    {
        $options = get_option( $args['option_name'] );

        $value = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '';

        // output the field
        printf( '<textarea id="%s" data-custom="%s" name="%s" cols="80" rows="10" class="all-options">%s</textarea>',
            esc_attr__( $args['label_for'] ),
            esc_attr__( $args['compartir_wp__custom_data'] ),
            esc_attr__( "{$args['option_name']}[{$args['label_for']}]" ),
            esc_html__( $value )
        );

        if ( isset( $args['description'] ) ) {
            printf( '<p class="description">%s</p>', $args['description'] );
        }
    }
}

// ----------------------------------------------------------------------------------