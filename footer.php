<?php
/**
 * The footer template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
					<?php do_action( 'avada_after_main_content' ); ?>

				</div>  <!-- fusion-row -->
			</main>  <!-- #main -->
			<?php do_action( 'avada_after_main_container' ); ?>

			<?php global $social_icons; ?>

			<?php
			/**
			 * Get the correct page ID.
			 */
			$c_page_id = Avada()->fusion_library->get_page_id();
			?>

			<?php
			/**
			 * Only include the footer.
			 */
			?>
			<?php if ( ! is_page_template( 'blank.php' ) ) : ?>
				<?php $footer_parallax_class = ( 'footer_parallax_effect' === Avada()->settings->get( 'footer_special_effects' ) ) ? ' fusion-footer-parallax' : ''; ?>

				<div class="fusion-footer<?php echo esc_attr( $footer_parallax_class ); ?>">
					<?php get_template_part( 'templates/footer-content' ); ?>
				</div> <!-- fusion-footer -->

				<?php
				/**
				 * Add sliding bar.
				 */
				if ( Avada()->settings->get( 'slidingbar_widgets' ) ) {
					get_template_part( 'sliding_bar' );
				}
				?>
			<?php endif; // End is not blank page check. ?>
		</div> <!-- wrapper -->

		<?php
		/**
		 * Check if boxed side header layout is used; if so close the #boxed-wrapper container.
		 */
		$page_bg_layout = 'default';
		if ( $c_page_id && is_numeric( $c_page_id ) ) {
			$fpo_page_bg_layout = get_post_meta( $c_page_id, 'pyre_page_bg_layout', true );
			$page_bg_layout     = ( $fpo_page_bg_layout ) ? $fpo_page_bg_layout : $page_bg_layout;
		}
		?>
		<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'Top' !== Avada()->settings->get( 'header_position' ) ) : ?>
			</div> <!-- #boxed-wrapper -->
		<?php endif; ?>
		<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'framed' === Avada()->settings->get( 'scroll_offset' ) && 0 !== intval( Avada()->settings->get( 'margin_offset', 'top' ) ) ) : ?>
			<div class="fusion-top-frame"></div>
			<div class="fusion-bottom-frame"></div>
			<?php if ( 'None' !== Avada()->settings->get( 'boxed_modal_shadow' ) ) : ?>
				<div class="fusion-boxed-shadow"></div>
			<?php endif; ?>
		<?php endif; ?>
		<a class="fusion-one-page-text-link fusion-page-load-link"></a>

		<?php wp_footer(); ?>
	</body>
<script>
	document.addEventListener('readystatechange', event => {
		if (event.target.readyState === "complete") {
			var elLog = document.querySelector("a[title='login']");
			
			addEvent(elLog, "click", function(event){
				//alert('testing');
				if(event.preventDefault){
					event.preventDefault;
				}
				if (event.stopPropagation) {
					event.stopPropagation();
				}
				return false;
			});
		}
	});
		
	
    
	jQuery("#yn-login").click(function(event){ 
		if(event.target.id=="yn-login"){
			if(jQuery("#yn-login").hasClass("yn-login")){  
				jQuery("#yn-login").removeClass("yn-login");
			} 
		}
	});
</script>


<script src="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/main.js?v=1.15"></script>

</html>
