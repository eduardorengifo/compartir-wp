<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// ----------------------------------------------------------------------------------

if ( ! function_exists( 'compartir_wp__field_text' ) )
{
	/**
     * Field Text
     *
	 * @param $args
     *
     * @return void
	 */
	function compartir_wp__field_text( $args )
    {
		$options = get_option( $args['option_name'] );
		$value = isset($options[ $args['label_for'] ]) ? $options[ $args['label_for'] ] : '';

		// output the field
        printf('<input id="%s" data-custom="%s" name="%s" type="text" value="%s" class="regular-text" />',
            esc_attr__($args['label_for']),
            esc_attr__($args['compartir_wp__custom_data']),
            esc_attr__("{$args['option_name']}[{$args['label_for']}]"),
            esc_attr__($value) );

        if ( isset( $args['text'] ) ) {
            _e( $args['text'] );
        }

		if ( isset( $args['description'] ) ) {
			printf('<p class="description">%s</p>', $args['description']);
		}
	}
}

// ----------------------------------------------------------------------------------