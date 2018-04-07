<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__field_checkbox' ) )
{
    /**
     * Field Checkbox
     *
     * @param array $args
     *
     * @return void
     */
    function compartir_wp__field_checkbox( $args )
    {
        $options = get_option( $args['option_name'] );

        $value = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '';

        $checked = ( $value === 'on' ) ? 'checked' : '';

        $html = sprintf( '<legend class="screen-reader-text"><span>%s</span></legend>',
            $args['label_for']
        );

        $html .= sprintf( '<label for="%s"><input id="%s" name="%s" type="checkbox" %s/><span>%s</span></label>',
            $args['label_for'],
            $args['label_for'],
            "{$args['option_name']}[{$args['label_for']}]",
            $checked,
            $args['text']
        );

        if ( isset( $args['description'] ) ) {
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );
        }

        printf( '<fieldset>%s</fieldset>', $html );
    }
}

// ----------------------------------------------------------------------------------