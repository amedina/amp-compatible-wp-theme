<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AMP_Compatible_Theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

        <nav class="social-menu">
            <?php wp_nav_menu( array( 'theme_location' => 'social') ); ?>
        </nav>

		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'amp' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'amp' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'amp' ), 'amp', '<a href="https://automattic.com/" rel="designer">Alberto Medina</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
