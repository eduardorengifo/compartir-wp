<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__field_multi_checkbox' ) )
{
    /**
     * Field Checkbox
     *
     * @param array $args
     *
     * @return void
     */
    function compartir_wp__field_multi_checkbox( $args )
    {
        $options = get_option( $args['option_name'] );

        $value = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '';

        if ( isset( $args['items'] )
            && ! empty( $args['items'] )
            && is_array( $args['items'] ) ) {

            foreach ($args['items'] as $item) {

                $checked = ( isset( $value[ $item['id'] ] ) && $value[ $item['id'] ] === 'on') ? 'checked' : '';
                $label_for = "{$args['label_for']}_{$item['id']}";

                $html = sprintf('<legend class="screen-reader-text"><span>%s</span></legend>',
                    $label_for
                );

                $html .= sprintf('<label for="%s"><input id="%s" name="%s" type="checkbox" %s/><span>%s</span></label>',
                    $label_for,
                    $label_for,
                    "{$args['option_name']}[{$args['label_for']}][{$item['id']}]",
                    $checked,
                    $item['text']
                );

                if ( isset( $item['description'] ) ) {
                    $html .= sprintf( '<p class="description">%s</p>', $item['description'] );
                }

                printf('<fieldset>%s</fieldset>', $html);
            }

            if ( isset( $args['description'] ) ) {
                printf( '<p class="description">%s</p>', $args['description'] );
            }

        } elseif ( isset( $args['error'] )
            && ! empty( $args['error'] ) ) {

            printf( '<p class="error">%s</p>', $args['error'] );
        }
    }
}

// ----------------------------------------------------------------------------------