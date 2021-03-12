<?php
/*
Plugin Name: selectuser
Plugin URI:
Description: seleziona utente
Version: 1.0
Author: Luciano
Author URI:
*/
?>
<?php
//----Crea cpt--------------
function selezionautente() {
    $labels = array (
        'name' => __('selezionautente'),
        'singular_name' => __('Contenuto'),
        'add_new' => __('Aggiungi contenuto'),
        'add_new_item' => __('Nuovo Contenuto'),
        'edit_item' => __('Modifica Contenuto'),
        'new_item' => __('Nuovo Contenuto'),
        'all_items' => __('Elenco Contenuto'),
        'view_item' => __('Visualizza Contenuti'),
        'search_items' => __('Cerca Contenuto'),
        'not_found' => __('Contenuto non trovato'),
        'not_found_in_trash' => __('Contenuto non trovato nel cestino'),
    );
    $args = array (
        'labels' => $labels,
        'public' => true,
        //'rewrite' => array('slug' => 'utenti'),
        //'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
		'show_in_rest' => true,
		//'taxonomies'		=> array( 'category', 'post_tag' ),
        //'supports' => array ('title','editor','thumbnail')
      );
register_post_type('selezionautente',$args);
 $cptselezionautente = "selezionautente";
 global $cptselezionautente;
}
add_action('init','selezionautente');


//---------------RENDERE I POST DELL'AREA RISERVATA PRIVATI DI DEFAULT -------------------
function force_post_type_private($post) {
	if ($post['post_type'] != 'selezionautente' || $post['post_status'] == 'trash')
	return $post;
	$post['post_status'] = 'private';
	return $post;
}
//-------------------Rendo il post privato visibile al ruolo sottoscrittore------------------
$subRole = get_role('subscriber');
$subRole->add_cap('read_private_posts');
function remove_private_post_prefix($format) {
    return '%s';
}
add_filter( 'private_title_format', 'remove_private_post_prefix', 99, 2 );
//CREO TASSONOMIA UTENTI
function crea_utenti() {
    $labels = array(
        'name'  => __('utenti'),
        'singular_name' => __('Utente'),
        'search_items'  => __('Cerca Utenti'),
        'popular_items'  => __('Utenti più utilizzati'),
        'all_items'  => __('Elenco Utenti'),
        'edit_item'  => __('Modifica Utente'),
        'add_new_item'  => __('Aggiungi Utente'),
        'separate_items_with_commas' => __('Separa gli utenti con una virgola'),
        'choose_from_most_used' => __('Scegli tra gli utenti più utilizzati'),
     );
    $args = array(
        'labels' => $labels,
        'hierarchical'  => false,
		'show_in_rest'      => true
    );
register_taxonomy('utenti','selezionautente', $args);
}
add_action( 'init', 'crea_utenti' );
// FINE TASSONOMIA-------------------------------------------

//nascondo la barra di wordpress tranne che all’ admin e editore
/*if( current_user_can('editor') || current_user_can('administrator') ) {
	add_filter('show_admin_bar', '__return_true');
}
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}*/
/* FINE FUNZIONI AREA PRIVATA------------------------------------*/
//----Crea metabox-----------
function metabox_select_user()
{
add_meta_box("selectuser", "Seleziona utente", "seleziona_utente",'selezionautente');
}
add_action('add_meta_boxes', 'metabox_select_user');
?>
<?php
function seleziona_utente($post)
{
  //  global $utenteselezionato;
  $user_args  = array(
		// cerco solo gli utenti di tipo sottoscrittore
		'role' => 'Subscriber',
		'orderby' => 'display_name'
	);
	// creo la WP_User_Query object
	$wp_user_query = new WP_User_Query($user_args);
	// richiamo i risultati
	$subscribers = $wp_user_query->get_results();
  echo "<select name='users'>";
  echo '<option value="all">Tutti</option>';
        foreach ($subscribers as $subscriber){
        //var_dump($subscriber);
        //print_r($subscriber->user_nicename);
        // richiamo i dati dei sottoscrittori
        $subscriber_info = get_userdata($subscriber->ID);
        $subscriber_id = get_post_meta($post->ID, 'users', true);
        if($subscriber_id == $subscriber_info->ID) {
        $subscriber_selected = 'selected="selected"';
        //$utenteselezionato = $subscriber_selected;
        //global $utenteselezionato;
      } else {
          $subscriber_selected ='';
        }//else
        echo '<option value='.$subscriber_info->ID.' '.$subscriber_selected.'>'.$subscriber_info->display_name.'</option>';
    }//foreach
    echo "</select>";
  }// fine funzione
  // salvo l’impostazione della lista
  add_action('save_post', 'salva_lista_utenti');
  function salva_lista_utenti(){
  global $post;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post->ID;
  }
   update_post_meta($post->ID, "users", $_POST["users"]);
}
?>
