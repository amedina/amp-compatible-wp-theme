<?php
/**
 * AMP Compatible Theme Theme Customizer
 *
 * @package AMP_Compatible_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function amp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Custom Customizer options
	 */
	// Background color for header and footer
	$wp_customize->add_setting('theme_bg_color', array(
		'default' => '#000',
		'transport' => 'postMessage',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	// Control for header and footer background color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_bg_color', array(
				'label' => __( 'Header/Footer background color', 'amp'),
				'section' => 'colors',
			)
		)
	);

	// Add option to select index content
	$wp_customize->add_section( 'build_mode',
		array(
			'title'			=> __( 'Build Mode', 'amp' ),
			'priority'		=> 95,
			'capability'	=> 'edit_theme_options',
			'description'	=> __( 'Define type of generated markup.', 'amp' )
		)
	);

	// Create excerpt or full content settings
	$wp_customize->add_setting(	'markup',
		array(
			'default'			=> 'Standard',
			'type'				=> 'theme_mod',
			'sanitize_callback' => 'amp_sanitize_build_mode',
			'transport'			=> 'postMessage'
		)
	);

	// Add the control
	$wp_customize->add_control(	'amp_build_mode_control',
		array(
			'type'		=> 'radio',
			'label'		=> __( 'Theme generates Markup', 'amp' ),
			'section'	=> 'build_mode',
			'choices'	=> array(
				'Standard'		=> __( 'Standard (default)', 'amp' ),
				'AMP'	=> __( 'AMP', 'amp' )
			),
			'settings'	=> 'markup' // Matches setting ID from above
		)
	);

}
add_action( 'customize_register', 'amp_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function amp_customize_preview_js() {
	wp_enqueue_script( 'amp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'amp_customize_preview_js' );

if ( ! function_exists( 'amp_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see amp_custom_header_setup().
	 */
	function amp_header_style() {
		$header_text_color = get_header_textcolor();
		$header_bg_color = get_theme_mod( 'theme_bg_color' );

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) != $header_text_color ) {

			// If we get this far, we have custom styles. Let's do this.
			?>
			<style type="text/css">
				<?php
					// Has the text been hidden?
					if ( ! display_header_text() ) :
				?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}

				<?php
					// If the user has set a custom color for the text use that.
					else :
				?>
				.site-title a,
				.site-description {
					color: #<?php echo esc_attr( $header_text_color ); ?>;
				}

				<?php endif; ?>
			</style>
			<?php
		}

		if ( '#000' != $header_bg_color ) { ?>
			<style type="text/css">
				.site-header,
				.site-footer {
					background-color: <?php echo esc_attr( $header_bg_color ); ?>
				}
			</style>
		<?php
		}
	}
endif;

/**
 * Sanitize build mode:
 * It is usually most important to set the default value of the setting as well as its
 * sanitization callback, which will ensure that no unsafe data is stored in the database.
 */
function amp_sanitize_build_mode( $value ) {
	if ( ! in_array( $value, array( 'Standard', 'AMP' ) ) ) {
		$value = 'Standard';
	}
	return $value;
}
