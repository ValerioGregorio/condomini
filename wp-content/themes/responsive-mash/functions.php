<?php

/**
 * Load css files.
 * @return [type] [description]
 */
function responsive_commerce_enqueue_style() {
	// Load main css file of parent theme.
    wp_enqueue_style( 'di-business-style-default', get_template_directory_uri() . '/style.css' );

    // Load this child theme css after all parent css files.
    wp_enqueue_style( 'responsive-commerce-style',  get_stylesheet_directory_uri() . '/style.css', array( 'bootstrap', 'font-awesome', 'di-business-style-default', 'di-business-style-core' ), wp_get_theme()->get('Version'), 'all');
}
add_action( 'wp_enqueue_scripts', 'responsive_commerce_enqueue_style' );

// Product rotation options.
add_action( 'di_business_woo_options', 'responsive_commerce_woo_options_rc' );
function responsive_commerce_woo_options_rc() {

	Kirki::add_field( 'di_business_config', array(
		'type'			=> 'toggle',
		'settings'		=> 'prod_img_rotate',
		'label'			=> esc_attr__( 'Rotate Product Image?', 'responsive-commerce' ),
		'description'	=> esc_attr__( 'Enable/Disable rotation of product images on shop page.', 'responsive-commerce' ),
		'section'		=> 'woocommerce_options',
		'default'		=> '1',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'color',
		'settings'    => 'product_border_color',
		'label'       => esc_attr__( 'Product Border Color', 'responsive-commerce' ),
		'section'     => 'woocommerce_options',
		'default'     => '#a0ce4e',
		'choices'     => array(
			'alpha' => true,
		),
		'output' => array(
			array(
				'element'  => '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product',
				'property' => 'box-shadow',
				'prefix'	=> '0px 0px 2px 1px ',
			),
			array(
				'element'  => '.woocommerce ul.products li.product:hover, .woocommerce-page ul.products li.product:hover',
				'property' => 'box-shadow',
				'prefix'	=> '0px 0px 6px 1px ',
			),
		),
		'transport' => 'auto',
	) );
}

// Product rotation options handle.
add_action( 'wp_enqueue_scripts', 'responsive_commerce_inline_css' );
function responsive_commerce_inline_css() {
	$custom_css = "";
	if( get_theme_mod( 'prod_img_rotate', '1' ) ) {
		$custom_css .= "
		.woocommerce ul.products li.product:hover img, .woocommerce-page ul.products li.product:hover img {
			-ms-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
		";
	}
	wp_add_inline_style( 'responsive-commerce-style', $custom_css );
}
/*-----------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------Marchetti---------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------*/
//creo il post type per l’area riservata

add_action('init', 'crea_contenuti');
function crea_contenuti() {
    $labels = array(
        'name'               => __('Area Riservata'),
        'singular_name'      => __('Contenuto'),
        'add_new'            => __('Aggiungi Contenuto'),
        'add_new_item'       => __('Nuovo Contenuto'),
        'edit_item'          => __('Modifica Contenuto'),
        'new_item'          => __('Nuovo Contenuto'),
        'all_items'          => __('Elenco Contenuti'),
        'view_item'          => __('Visualizza Contenuti'),
        'search_items'       => __('Cerca Contenuto'),
        'not_found'          => __('Contenuto non trovato'),
        'not_found_in_trash' => __('Contenuto non trovato nel cestino'),
    );

    $args = array(
        'labels'            => $labels,
        'public'             => true,
        'rewrite'            => array('slug' => 'contenuti'),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array(
                                'title',
                                'editor',
                                'thumbnail',
                                'comments'
                                ),

    );
register_post_type('area-riservata', $args);
}

//rendo il post type privato di default

function force_type_private($post)
{
    if ($post['post_type'] == 'area-riservata') {
        if ($post['post_status'] == 'publish') {
	        $post['post_status'] = 'private';
        }
    }
    return $post;
}

add_filter('wp_insert_post_data', 'force_type_private');

//rendo il post privato visibile al ruolo sottoscrittore
$subRole = get_role( 'subscriber' );
$subRole->add_cap( 'read_private_posts' );

// rimuovo privato dal titolo
function clean_title($titolo) {
	$titolo = esc_attr($titolo);
	$cerca = array(
		'#Privato:#'

	);
	$sostituisci = array(
		'-' // Sostituiamo la voce "Privato" con
	);
	$titolo = preg_replace($cerca, $sostituisci, $titolo);
	return $titolo;
}
add_filter('the_title', 'clean_title');


//nascondo la barra di wordpress tranne che all’ admin
if (!current_user_can('manage_options')) {
	add_filter('show_admin_bar', '__return_false');
}
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}

// creo il metabox per il post type area riservata

function users_meta_init(){
  add_meta_box("users-meta", "User Select", "users", "area-riservata", "normal", "high");
}
add_action("admin_init", "users_meta_init");

// lista degli utenti
function users(){
  global $post;
  $custom = get_post_custom($post->ID);
  $users = isset($custom["users"][0]);//sottoscrittore
	$user_args  = array(
		// cerco solo gli utenti di tipo sottoscrittore
		'role' => 'Subscriber',
		'orderby' => 'display_name'
	);

	// creo la WP_User_Query object
	$wp_user_query = new WP_User_Query($user_args);

  // richiamo i risultati
	$subscribers = $wp_user_query->get_results();

  // controllo i risultati
	if (!empty($subscribers))
	{
	    // l’attributo di name è la chiave del customfield
	    echo "<select name='users'>";
	    	echo '<option value="all">Tutti</option>';

	    // loop che mostra tutti i sottoscrittori
	    foreach ($subscribers as $subscriber){

	        // richiamo i dati dei sottoscrittori
	        $subscriber_info = get_userdata($subscriber->ID);
	        $subscriber_id = get_post_meta($post->ID, 'users', true);
	        if($subscriber_id == $subscriber_info->ID) {
	        	$subscriber_selected = 'selected="selected"';
	        } else {
	        	$subscriber_selected ='';
	        }
	        echo '<option value='.$subscriber_info->ID.' '.$subscriber_selected.'>'.$subscriber_info->display_name.'</option>';
	    }
	    echo "</select>";
	} else {
	    echo 'No authors found';
	}
}

// salvo l’impostazione della lista
add_action('save_post', 'save_userlist');
function save_userlist(){
  global $post;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	    return $post->ID;
	}
   update_post_meta($post->ID, "users", $_POST["users"]);
}
