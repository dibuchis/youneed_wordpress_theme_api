<?php
header('Access-Control-Allow-Origin: *'); 
/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php avada_the_html_class(); ?>" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<script>
	function addEvent(elm, evType, fn) {
		// try {
			if (elm.addEventListener) {
				elm.addEventListener(evType, fn, false);
				return true;
			}
			else if (elm.attachEvent) {
				var r = elm.attachEvent('on' + evType, fn);
				return r;
			}
			else {
				elm['on' + evType] = fn;
			}
		// } catch (error) {
			
		// }
    }

	</script>
	
	<?php Avada()->head->the_viewport(); ?>

	<?php wp_head(); ?>

	<?php $object_id = get_queried_object_id(); ?>
	<?php $c_page_id = Avada()->fusion_library->get_page_id(); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>

	<script type="text/javascript">
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>
	
	<script type="text/javascript" src="https://youneed.com.ec/app/js/spin.js'; ?>" ></script>
	<script type="text/javascript" src="https://youneed.com.ec/app/js/main.js"></script>
	

	<?php
	/**
	 *
	 * The settings below are not sanitized.
	 * In order to be able to take advantage of this,
	 * a user would have to gain access to the database
	 * in which case this is the least on your worries.
	 */
	echo apply_filters( 'avada_google_analytics', Avada()->settings->get( 'google_analytics' ) ); // WPCS: XSS ok.
	echo apply_filters( 'avada_space_head', Avada()->settings->get( 'space_head' ) ); // WPCS: XSS ok.
	?>
	<?php /*
	<link href="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/datepicker/dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/datepicker/dist/js/datepicker.min.js"></script>

	<!-- Include English language -->
	<script src="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/datepicker/dist/js/i18n/datepicker.en.js"></script>*/ 
	?>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/bootstrap-datepicker/moment.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>-Child-Theme/lib/bootstrap-datepicker/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/js/bootstrap4-toggle.min.js"></script>

	<script>
		function loadServiciosFilter(){
		
		jQuery("#sidebar").LoadingOverlay("show", {maxSize: 70 });
		
		
		var cat = jQuery("#filtro-categoria-data").val();

			jQuery.ajax({
				type: 'POST',
				url: "https://youneed.com.ec/wp-admin/admin-ajax.php",
				data: {
					action: 'api_youneed_filtro_servicio',
					categoria :  jQuery("#filtro-categoria-data").val()
				},
				success: function( data ) {
					jQuery('#widget-filtro-servicio').html(data);
					jQuery("#sidebar").LoadingOverlay("hide");
				},
				error: function(data){
					jQuery("#sidebar").LoadingOverlay("hide");
				}
			});
		}
	</script>
</head>
    <!-- LOGIN -->
    <div class="apilogin-wrapper" id="yn-login">
      <form class="login">
        <p class="title">Ingreso</p>
        <span class="error-msg" id="login-error"></span>
        <input type="text" placeholder="Email" name="api-username" id="api-username" autofocus/>
        <i class="fa fa-user"></i>
        <input type="password" name="api-password" id="api-password" placeholder="Contraseña" />
        <i class="fa fa-key"></i>
        <center><p>¿No tienes cuenta?</p></center>
        <center><a href="https://youneed.com.ec/registro_escoger/">Registrate</a></center>
        <center><a href="#">¿Olvidaste tu contraseña?</a></center>
        <button>
          <i class="spinner"></i>
          <span class="state">Ingresar</span>
        </button>
      </form>
      <footer></footer>
      </p>
    </div>
    <!-- END LOGIN -->
<?php
$wrapper_class = ( is_page_template( 'blank.php' ) ) ? 'wrapper_blank' : '';

if ( 'modern' === Avada()->settings->get( 'mobile_menu_design' ) ) {
	$mobile_logo_pos = strtolower( Avada()->settings->get( 'logo_alignment' ) );
	if ( 'center' === strtolower( Avada()->settings->get( 'logo_alignment' ) ) ) {
		$mobile_logo_pos = 'left';
	}
}

?>
<script>
	var elLog = document.querySelector("a[title='login']");
	
	addEvent(elLog, "click", function(event){
         alert('testing');
        if(event.preventDefault){
            event.preventDefault;
        }
         if (event.stopPropagation) {
            event.stopPropagation();
         }
        return false;
    });
	
    (function($){
	    jQuery('.login').click(function(e) {
            e.preventDefault();
        });
        
        
        
        jQuery("#yn-login").click(function(event){ 
            if(event.target.id=="yn-login"){
                if(jQuery("#yn-login").hasClass("yn-login")){  
                    jQuery("#yn-login").removeClass("yn-login");
                } 
            }
        });
    })(jQuery);
</script>
<body <?php body_class(); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'Avada' ); ?></a>
	<?php
	do_action( 'avada_before_body_content' );

	$boxed_side_header_right = false;
	$page_bg_layout          = 'default';
	if ( $c_page_id && is_numeric( $c_page_id ) ) {
		$fpo_page_bg_layout = get_post_meta( $c_page_id, 'pyre_page_bg_layout', true );
		$page_bg_layout     = ( $fpo_page_bg_layout ) ? $fpo_page_bg_layout : $page_bg_layout;
	}

	?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && ( 'default' === $page_bg_layout || '' == $page_bg_layout ) ) || 'boxed' === $page_bg_layout ) && 'Top' != Avada()->settings->get( 'header_position' ) ) : ?>
		<div id="boxed-wrapper">
	<?php endif; ?>
	<?php if ( ( ( 'Boxed' === Avada()->settings->get( 'layout' ) && 'default' === $page_bg_layout ) || 'boxed' === $page_bg_layout ) && 'framed' === Avada()->settings->get( 'scroll_offset' ) ) : ?>
		<div class="fusion-sides-frame"></div>
	<?php endif; ?>
	<div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div id="home" style="position:relative;top:-1px;"></div>
		<?php avada_header_template( 'Below', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) ); ?>
		<?php if ( 'Left' === Avada()->settings->get( 'header_position' ) || 'Right' === Avada()->settings->get( 'header_position' ) ) : ?>
			<?php avada_side_header(); ?>
		<?php endif; ?>

		<?php avada_sliders_container(); ?>

		<?php avada_header_template( 'Above', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) ); ?>

		<?php if ( has_action( 'avada_override_current_page_title_bar' ) ) : ?>
			<?php do_action( 'avada_override_current_page_title_bar', $c_page_id ); ?>
		<?php else : ?>
			<?php avada_current_page_title_bar( $c_page_id ); ?>
		<?php endif; ?>
		<?php do_action( 'avada_after_page_title_bar' ); ?>

		<?php
		$main_css   = '';
		$row_css    = '';
		$main_class = '';

		if ( apply_filters( 'fusion_is_hundred_percent_template', false, $c_page_id ) ) {
			$main_css         = 'padding-left:0px;padding-right:0px;';
			$hundredp_padding = get_post_meta( $c_page_id, 'pyre_hundredp_padding', true );
			if ( Avada()->settings->get( 'hundredp_padding' ) && ! $hundredp_padding ) {
				$main_css = 'padding-left:' . Avada()->settings->get( 'hundredp_padding' ) . ';padding-right:' . Avada()->settings->get( 'hundredp_padding' );
			}
			if ( $hundredp_padding ) {
				$main_css = 'padding-left:' . $hundredp_padding . ';padding-right:' . $hundredp_padding;
			}
			$row_css    = 'max-width:100%;';
			$main_class = 'width-100';
		}
		do_action( 'avada_before_main_container' );
		?>
		<main id="main" class="clearfix <?php echo esc_attr( $main_class ); ?>" style="<?php echo esc_attr( $main_css ); ?>">
			<div class="fusion-row" style="<?php echo esc_attr( $row_css ); ?>">