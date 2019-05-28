<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

/**
 *
 * API - YouNeed
 * INICIAR SESSION HANDLER
 * 
 */
add_action('init', 'youneed_session_start', 1);
function youneed_session_start() {
    if( ! session_id() ) {
        session_start();
    }
}

/**
 *
 * API - YouNeed
 * CUSTOM QUERY VARS
 * 
 */
function custom_query_vars_filter($vars) {
  $vars[] .= 'cat_id';
  $vars[] .= 'srv_id';
  $vars[] .= 'id';
  $vars[] .= 'page';
  return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );

/**
 *
 * API - YouNeed
 * OBTENER CATEGORIAS
 * 
 */
function api_youneed_categorias(){
    // wp_register_style('my_stylesheet_1', 'https://youneed.com.ec/app/css/owl.carousel.min.css');
    // wp_register_style('my_stylesheet_2', 'https://youneed.com.ec/app/css/owl.theme.default.min.css');
    // wp_register_script('owl-carrousel-api', 'https://youneed.com.ec/app/js/owl.carousel.min.js', array('jquery'),'1.1', true);
    wp_register_script('load-owl-carrousel-api', 'https://youneed.com.ec/app/js/loadCarousel.js', array('jquery'),'1.1', true);
    
    // wp_enqueue_style('my_stylesheet_1');
    // wp_enqueue_style('my_stylesheet_2');
    // wp_enqueue_script('owl-carrousel-api');
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://app.youneed.com.ec/ajax/listadocategorias');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
     
    $data = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($data);
    
    $cats = $result->output;
    
    $out = '<i>No se han encontrado categorias disponibles.</i>';
    
    if($cats){
        
        $out = '<div class="owl-carousel owl-theme owl-api swiper-container" id="categorias-youneed">';    
        
        $out .= '<div class="owl-carousel owl-theme owl-api swiper-wrapper hidden">';    
        
        foreach ($cats as $key => $value) {
           $out .= '<div class="item item-categoria swiper-slide swiper-lazy">';
                $out .= '<a href="/servicios?cat_id=' . $value->id . '"><img src="' . $value->imagen . '" alt="' . $value->nombre . '"/></a>';    
                $out .= '<center><span class="cat-text">' . $value->nombre . '</span></center>';    
            $out .= '</div>';
              
        }
      
        $out .= '</div>';
        
        $out .= '<div class="swiper-lazy-preloader"></div>';
        

        $out .= '<div class="swiper-pagination"></div>';

        $out .= '<div class="swiper-button-next"></div>';
        $out .= '<div class="swiper-button-prev"></div>';
      
        
        $out .= '</div>';
    }else{
        
    }
    
    //var_dump($cats);
    
    
    wp_enqueue_script('load-owl-carrousel-api');
    
    return $out;
    
}
add_shortcode( 'api_youneed_categorias', 'api_youneed_categorias' );


/**
 *
 * API - YouNeed
 * OBTENER SERVICIOS POR CATEGORIA ID
 * 
 */
function api_youneed_servicios(){
    
    if($_REQUEST['cat_id']){
        $cat_id = $_REQUEST['cat_id'];
    }else{
        $cat_id = 1;
    }
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://app.youneed.com.ec/ajax/listadoservicios?depdrop_parents=' . $cat_id);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
     
    $data = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($data);
    
    $cats = $result->output;
    
    $out = '<i>No se han encontrado servicios disponibles en esta categoría.</i>';
    
    if($cats){
        
        $out = '<div class="catalogo-servicios" id="servicios-youneed">';    
        $out .= '<h2>Listado de Servicios</h2>';  
        
        foreach ($cats as $key => $value) {
           $out .= '<div class="item item-servicio">';
               $out .= '<div class="item-inner">';
                    $out .= '<div class="item-expand">';
                        $out .= '<div class="img-panel meta-imagen"><img src="' . $value->imagen . '" alt="' . $value->nombre . '"/></div>';    
                        $out .= '<div class="content-panel meta-content">';
                            $out .= '<div class="meta meta-nombre">' . $value->nombre  . '</div>';
                            //$out .= '<label><b>Precio: </b></label><div class="meta meta-precio">' . $value->precio  . '</div>';
                            $out .= '<div class="meta meta-desc"><a class="ver-detalles link-servicio" onclick="getServicio(' . $value->id . ')">Ver Detalles</a></div>';
                            $out .= '<div class="meta meta-link"><a class="ver-asociados btn-asociados" href="/servicio-asociados?srv_id=' . $value->id . '">Ver Profesionales</a></div>';
                        $out .= '</div>';
                    $out .= '</div>';
                $out .= '</div>';
            $out .= '</div>';
        }
      
        $out .= '</div>';
    }else{
        
    }
    
    //var_dump($cats);
    
    return $out;
    
}

add_shortcode( 'api_youneed_servicios', 'api_youneed_servicios' );


/**
 *
 * API - YouNeed
 * OBTENER LISTA DE ASOCIADOS
 * 
 */
function api_youneed_asociados(){
    
	
	
    if($_REQUEST['srv_id']){
        $srv_id = $_REQUEST['srv_id'];
		$_SESSION['servicio_id'] = $_REQUEST['srv_id'];
    }else{
        $srv_id = 1;
    }
	
	$chUrl = 'https://app.youneed.com.ec/ajax/listadoasociados?srv_id=' . $srv_id;
	
	$nPage = get_query_var('page');
	
	if($nPage > 1){
		$chUrl = 'https://app.youneed.com.ec/ajax/listadoasociados?srv_id=' . $srv_id . "&page=" . $nPage;
	}
    
    $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $chUrl);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         
        $data = curl_exec($ch);
    
        curl_close($ch);
    
        $result = json_decode($data);
		
		// echo "<pre>";
		// var_dump($result->total);
		// var_dump($result->pages);
		// var_dump($result->offset);
		// var_dump($result->rows);
		// echo "</pre>";
		
        $asoc = $result->output;
    
    $out = '<i>No se han encontrado asociados disponibles para este servicio.</i>';
    
    if($asoc){
        
        $out = '<div class="catalogo-asociados" id="asociados-youneed">';    
        //$out .= '<h2>Listado de Servicios</h2>';  
        
        foreach ($asoc as $key => $value) {
			$params = array('id' => $value->id, 'srv_id' => $srv_id);
            $out .= '<div class="item item-asociado">';
                $out .= '<div class="left-panel meta-imagen"><img src="' . $value->imagen . '" alt="' . $value->nombre . '"/></div>';    
                $out .= '<div class="right-panel meta-content">';
                    $out .= '<div class="meta meta-nombre-asociado">' . strtolower($value->nombre)  . '</div>';
                    $out .= '<div class="meta meta-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>';
                    $out .= '<div class="meta meta-ciudad">' . $value->ciudad->nombre  . '</div>';
                    //$out .= '<label><b>Precio: </b></label><div class="meta meta-precio">' . $value->precio  . '</div>';
                    $out .= '<div class="meta meta-link"><a class="ver-asociados btn-asociados" href="' . add_query_arg($params, '/ver-asociado') . '">Ver Perfil</a></div>';
					///ver-asociado?id=' . $value->id . '
                $out .= '</div>';
            $out .= '</div>';
            $out .= '<hr class="hr-asoc">';
              
        }
		
		if($result->pages > 1){
			$out .= '<div class="pagination-asoc">';

				for($i = 1; $i <= $result->pages; $i++){

					$params = array('srv_id' => $srv_id, 'page' => $i);
					$out .= '<div class="page-asoc">';
						
						if($i != $nPage){
							$out .= '<a class="page-link" href="' . add_query_arg($params, '/servicio-asociados') . '" >' . $i . '</a>';
						}else{
							$out .= '<span class="page-link">' . $i . '</span>';	
						}
					
					$out .= '</div>';
				
				}
			$out .= '</div>';
		}
	  
        $out .= '</div>';
    }else{
        
    }
    
    //var_dump($cats);
    
    return $out;
    
}

add_shortcode( 'api_youneed_asociados', 'api_youneed_asociados' );


/**
 *
 * API - YouNeed
 * CONTAR ASOCIADOS SEGUN CATEGORIA
 * 
 */
function api_youneed_contar_asociados(){
    
    $out = '';
    
    if($_REQUEST['srv_id']){
        $srv_id = $_REQUEST['srv_id'];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://app.youneed.com.ec/ajax/contarasociados?srv_id=' . $srv_id);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         
        $data = curl_exec($ch);
    
        curl_close($ch);
        
        $result = json_decode($data);
        
        $text = "<h3 class='filtro-titulo'><b>" . $result->nombre_servicio . "</b></h3>"; 
        $text .= "<span class='filtro'>" . $result->count . ($data > 1 ? " resultados" : " resultado") . "</span>";
        
        return $text;
    }else{
        return 0;
    }
}
add_shortcode( 'api_youneed_contar_asociados', 'api_youneed_contar_asociados' );


/**
 *
 * API - YouNeed
 * MOSTRAR DATOS ASOCIADO
 * 
 */
function api_youneed_asociado(){
    
    $user = null;

    if(isset($_SESSION["api_userdata"])) {
        $user = $_SESSION["api_userdata"];
        //$data = json_encode($data);
        //echo "USAURIO";
    }
    
	$srv_id = get_query_var('srv_id');
    
    if($user){
        //echo $data->usuario;
        //echo json_encode($data);
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://app.youneed.com.ec/ajax/verasociado?aso_id=' . $_REQUEST['id'] . '&api_token=8e705fdb6ed22df72e4fcbeb37bcf517');
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         
        $dataAsoc = curl_exec($ch);
    
        curl_close($ch);
        
        $asociado = json_decode($dataAsoc);
        
        $dias = [ 1 => 'Lunes a Viernes', 2 => 'Fines de semana', 3 => 'Cualquier día' ];
        $horarios = [ 1 => '7am a 12 am', 2 => '12am a 7pm', 3 => '7pm a 7 am', 4 => '24 horas' ];
        
		$srv_id = get_query_var('srv_id');
		
		if(!($srv_id > 0)){
			$srv_id = $_SESSION['servicio_id'];
		}
        
        $out = '<div id="panel-asociado" class="fusion-fullwidth fullwidth-box hundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: #f3f3f3;background-position: center center;background-repeat: no-repeat;padding-top:45px;padding-right:8%;padding-bottom:45px;padding-left:8%;"><div class="fusion-builder-row fusion-row "><div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1 fusion-builder-column-2 fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:20px;">';
        $out .= '<h2>Asociado</h2>';
        $out .= '<hr>';
        $out .= '<div class="panel-asociado">';
        $out .= '<form id="contratar-asociado" method="post" action="https://youneed.com.ec/contratar/" >';
            //$out .= '<input type="hidden" name="_csrf" value="XDB8ErUw8zD_28OF8uOJGeVszR7GuztlpYlXhhaPVNYTWDlcgFW_QZmR7rynishGig2scrH4Yg_20RnBL7cVsg==">';
            
                $out .= '<input id="asociado_id" type="hidden" name="asociado_id" value="' . $asociado->id . '">';
                $out .= '<input id="cliente_id" type="hidden" name="cliente_id" value="' . $user->usuario->id . '">';
                $out .= '<input id="servicio_id" type="hidden" name="servicio_id" value="' . $srv_id . '">';
   
            $out .= '<div class="left-panel">';
                $out .= '<img class="asociado-vista-img" src="' . $asociado->imagen . '">';
            $out .= '</div>';
            
            $out .= '<div class="right-panel">';
                
                $out .= '<label><b>Nombre</b></label>';
                $out .= '<p><span>' . ucwords(strtolower($asociado->nombres)) . " " . ucwords(strtolower($asociado->apellidos)) . '</span></p>';
                
                $out .= '<div class="meta meta-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>';
                
                $out .= '<label><b>Estado</b></label>';
                $out .= '<p><span>' . $asociado->estado . '</span></p>';
                
                
                //$out .= '<h4>Disponibilidad</h4>';

                $out .= '<div class="fusion-builder-row fusion-row">';
                
                    $out .= '<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2 fusion-builder-column-7 fusion-one-half fusion-column-last 1_2">';
                        $out .= '<label><b>Días</b></label>';
                        $out .= '<p><span>' . $dias[$asociado->dias_trabajo] . '</span></p>';
                        
                        $out .= '<label><b>Horas</b></label>';
                        $out .= '<p><span>' . $horarios[$asociado->horarios_trabajo] . '</span></p>';
                    $out .= '</div>';
                    
                    $out .= '<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2 fusion-builder-column-7 fusion-one-half fusion-column-last 1_2">';
                        $out .= '<label><b>País</b></label>';
                        $out .= '<p><span>' . $asociado->pais->nombre . '</span></p>';
                        
                        $out .= '<label><b>Ciudad</b></label>';
                        $out .= '<p><span>' . $asociado->ciudad->nombre . '</span></p>';
                    $out .= '</div>'; 
                
                $out .= '</div>'; 
                
                $out .= '<div class="meta meta-link">';
                    $out .= '<a class="ver-asociados btn-asociados btn-cancelar" href="javascript:history.back()">Cancelar</a>';
                    $out .= '<a href="javascript:{}" onclick="document.getElementById(\'contratar-asociado\').submit();" class="ver-asociados btn-asociados" >Contratar</a>';
                $out .= '</div>';
            $out .= '</div>';
            
            $out .= '<hr>';
            
            $out .= '<div class="comment-panel">';
                $out .= '<h4>Comentarios</h4>';
            $out .= '</div>';
        $out .= '</form>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
        return $out;
    }else{
        //echo null;
        //$out = '<div class="apilogin-wrapper" id="yn-login"> <form class="login"> <p class="title">Ingreso</p> <span class="error-msg" id="login-error"></span> <input type="text" placeholder="Email" name="api-username" id="api-username" autofocus/> <i class="fa fa-user"></i> <input type="password" name="api-password" id="api-password" placeholder="Contraseña" /> <i class="fa fa-key"></i> <center><p>¿No tienes cuenta?</p></center> <center><a href="https://youneed.com.ec/registro_escoger/">Registrate</a></center> <center><a href="#">¿Olvidaste tu contraseña?</a></center> <button> <i class="spinner"></i> <span class="state">Ingresar</span> </button> </form> <footer></footer> </p> </div>';
        $out = '<div class="fusion-fullwidth fullwidth-box hundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: #f3f3f3;background-position: center center;background-repeat: no-repeat;padding-top:45px;padding-right:8%;padding-bottom:45px;padding-left:8%;"><div class="fusion-builder-row fusion-row "><div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1 fusion-builder-column-2 fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:20px;">';
        $out .= '<h2>Acceso para usuarios</h2>';
        $out .= '<p>Por favor inicie sesión antes de continuar.</p>';
        $out .= '<a class="menu-text fusion-button button-default button-small btn-trigger-login" href="#">Ingresar</a>';
        $out .= '<h3>¿No tienes cuenta?</h3>';
        $out .= '<a href="https://youneed.com.ec/registro_escoger/">Registrate</a>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
        
        //wp_register_script('show-login', 'https://youneed.com.ec/app/js/showLogin.js', array('jquery'),'1.1', true);
        //wp_enqueue_script('show-login');
        return $out;
    };
    
}
add_shortcode( 'api_youneed_asociado', 'api_youneed_asociado' );

/**
 *
 * API - YouNeed
 * CONTRATAR ASOCIADO
 * 
 */
function api_youneed_contratar(){

    // wp_register_style('bootstrap-icons', 'https://youneed.com.ec/wp-content/themes/Avada-Child-Theme/lib/css/bootstrap.min.css');
    // wp_enqueue_style( 'bootstrap' );

    wp_register_style('glyphicons', 'https://youneed.com.ec/wp-content/themes/Avada-Child-Theme/lib/glyphicons/css/bootstrap.min.css');
    wp_enqueue_style( 'glyphicons' );

    $user = null;
    $servicio_id = null;
    $asociado_id = null;

    if(isset($_SESSION["api_userdata"])) {
        $user = $_SESSION["api_userdata"];
        //$user = json_encode($data);
        //echo "USAURIO";

    }

    $out = '';

    
    if(isset($_SESSION["pedido_asociado_id"]) && isset($_SESSION["pedido_servicio_id"])){
        $asociado_id = $_SESSION["pedido_asociado_id"];
        $servicio_id = $_SESSION["pedido_servicio_id"];
    }else if(isset($_POST["asociado_id"]) && isset($_POST["servicio_id"])){

        $asociado_id = $_POST["asociado_id"];
        $servicio_id = $_POST["servicio_id"];
        
        $_SESSION["pedido_asociado_id"] = $_POST["asociado_id"];
        $_SESSION["pedido_servicio_id"] = $_POST["servicio_id"];

    }else{
        return $out;
    }

    if($user){

        $data = array (
            'serviceID' => $servicio_id
        );
        
        $params = '';
            foreach($data as $key=>$value)
            $params .= $key.'='.$value.'&';
        
        $params = trim($params, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://app.youneed.com.ec/ajax/getservicio');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        //We add these 2 lines to create POST request
        curl_setopt($ch, CURLOPT_POST, count($data)); //number of parameters sent
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //parameters data

        $dataRes = curl_exec($ch);

        curl_close($ch);
        
        

        //$out['login'] = true;

        $_servicio = json_decode($dataRes);

        $out = '<div class="fusion-fullwidth fullwidth-box hundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-position: center center;background-repeat: no-repeat;padding-top:45px;padding-right:8%;padding-bottom:45px;padding-left:8%;"><div class="fusion-builder-row fusion-row "><form class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1 fusion-builder-column-2 fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:20px;">';
        $out .= '<h2>Checkout</h2>';
        $out .= '<form id="contratar-asociado" method="post" action="https://youneed.com.ec/contratar/" >';
			//$out .= '<input type="hidden" name="_csrf" value="XDB8ErUw8zD_28OF8uOJGeVszR7GuztlpYlXhhaPVNYTWDlcgFW_QZmR7rynishGig2scrH4Yg_20RnBL7cVsg==">';
            
                $out .= '<input id="asociado_id" type="hidden" name="Pedido[asociado_id]" value="' . $asociado_id . '">';
                $out .= '<input id="cliente_id" type="hidden" name="Pedido[cliente_id]" value="' . $user->usuario->id . '">';
                $out .= '<input id="servicio_id" type="hidden" name="Pedido[servicio_id]" value="' . $servicio_id . '">';
                $out .= '<input id="valor_total" type="hidden" name="Pedido[total]" value="' . $_servicio->servicio->total . '">';
            
            // AGREGAR COORDENADAS DE API GEOREFERENCIAL !!!!!
			// $out .= '<input id="georeferencia" type="hidden" name="georeferencia" value="' . $_POST["servicio_id"] . '">';

            $fecha_actual = date("Y/m/d H:i");

            $out .= '<h2>Fecha de Servicio</h2>';
            $out .= '<div style="overflow:hidden;margin-bottom:35px;"><div class="form-group"><div class="row"><div class="col-md-8"><div id="datetimepicker12"></div></div></div></div>';
            $out .= '<script>var today = new Date(); jQuery("#datetimepicker12").datetimepicker({ inline: true, sideBySide: true, locale: "es", minDate: today });</script>';
            $out .= '<input type="hidden" id="fecha_servicio" name="Pedido[fecha_para_servicio]" class="datepickerinput" >';
            $out .= '</div>';



            
            $out .= '<h2>Datos de Servicio</h2>';
            $out .= '<table class="table-1 checkout-table"  style="margin-bottom:35px;">';
                $out .= '<tbody>';
                    $out .= '<tr>';
                        $out .= '<th></th>';
                        $out .= '<th>Código</th>';
                        $out .= '<th>Descripción</th>';
                        $out .= '<th>Valor</th>';
                    $out .= '</tr>';
                    
                    $out .= '<tr>';
                        $out .= '<td class="checkout_meta"><img width="50" src="' . $_servicio->servicio->imagen .'" alt="' . $_servicio->servicio->nombre . '"></td>';
                        $out .= '<td class="checkout_meta">' . $_servicio->servicio->id .'</td>';
                        $out .= '<td class="checkout_meta">' . $_servicio->servicio->nombre .'</td>';
                    $out .= '<td class="checkout_meta">' . $_servicio->servicio->total .'</td>';
                    $out .= '</tr>';
                $out .= '</tbody>';
            $out .= '</table>';

            $out .= '<table class="table-2" style="margin-bottom:35px;">';
            $out .= '<tbody>';
                $out .= '<tr>';
                    $out .= '<td>Incluye</td>';
                    $out .= '<td class="checkout_meta meta-mini">' . $_servicio->servicio->incluye .'</td>';
                    $out .= '</tr>';
                    $out .= '<tr>';
                    $out .= '<td>No Incluye</td>';
                    $out .= '<td class="checkout_meta meta-mini">' . $_servicio->servicio->no_incluye .'</td>';
                $out .= '</tr>';
                $out .= '</tr>';
            $out .= '</tbody>';
        $out .= '</table>';

            $out .= '<hr>';
            
            $out .= '<a class="ver-asociados btn-asociados" onclick="contratarAsociado(event)" href="#">Contratar</a>';
        $out .= '</form>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
    }else{
        $out = '<div class="fusion-fullwidth fullwidth-box hundred-percent-fullwidth non-hundred-percent-height-scrolling" style="background-color: #f3f3f3;background-position: center center;background-repeat: no-repeat;padding-top:45px;padding-right:8%;padding-bottom:45px;padding-left:8%;"><div class="fusion-builder-row fusion-row "><div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1 fusion-builder-column-2 fusion-one-full fusion-column-first fusion-column-last 1_1" style="margin-top:0px;margin-bottom:20px;">';
        $out .= '<h2>Acceso para usuarios</h2>';
        $out .= '<p>Por favor inicie sesión antes de continuar.</p>';
        $out .= '<a class="menu-text fusion-button button-default button-small btn-trigger-login" href="#">Ingresar</a>';
        $out .= '<h3>¿No tienes cuenta?</h3>';
        $out .= '<a href="https://youneed.com.ec/registro_escoger/">Registrate</a>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
    }
    
    return $out;
}
add_shortcode( 'api_youneed_contratar', 'api_youneed_contratar' );

/**
 *
 * API - YouNeed
 * FILTROS ASOCIADOS
 * 
 */
function api_youneed_listar_asociados(){
        $text = "<h3 class='filtro-titulo'><b>Ordenar</b></h3>"; 
        //$text .= "<span class='filtro'>" . $result->count . ($data > 1 ? " resultados" : " resultado") . "</span>";
        
        return $text;
}
add_shortcode( 'api_youneed_listar_asociados', 'api_youneed_listar_asociados' );

function api_youneed_filtro_ciudades(){
        $text = "<h3 class='filtro-titulo'><b>Ubicación</b></h3>"; 
        //$text .= "<span class='filtro'>" . $result->count . ($data > 1 ? " resultados" : " resultado") . "</span>";
        
        return $text;
}
add_shortcode( 'api_youneed_filtro_ciudades', 'api_youneed_filtro_ciudades' );

function api_youneed_filtro_categoria(){
        $text = "<h3 class='filtro-titulo'><b>Categortía</b></h3>"; 
        //$text .= "<span class='filtro'>" . $result->count . ($data > 1 ? " resultados" : " resultado") . "</span>";
        
        return $text;
}
add_shortcode( 'api_youneed_filtro_categoria', 'api_youneed_filtro_categoria' );