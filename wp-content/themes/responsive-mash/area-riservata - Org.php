<?php

/*
Template Name: Area Riservata
*/
?>

<?php get_header(); ?>

<?php //se l’utente è loggato mostra messaggio di benvenuto e post
		if ( is_user_logged_in() ) {?>
				<?php //info dell’utente loggato
	//	global $current_user;
		//get_currentuserinfo();
		$current_user = wp_get_current_user();
		$my_user = $current_user->user_login ;
		$my_user_level = $current_user->user_level ;
		$my_user_id = $current_user->ID;
		echo 'Benvenuto, '. $my_user;
		?>

		<hr />
<?php //se l’utente è l’admin mostro tutti i contenuti, altrimenti mostro quelli dell’utente associato al post
if($my_user_level == 10) {

				  //loop con tutti i contenuti
$wpquery = new WP_Query(array(

'post_type'	=> 'area-riservata',
));
			  } else {

			      //loop con i contenuti del relativo utente + quelli contrassegnati come all
$wpquery = new WP_Query(array(
'post_type'	=> 'area-riservata',
'meta_query' => array(
'relation' => 'OR',
array(
'key' => 'users',
'value' => $my_user_id,
'compare' => '='
),
						         array(

'key' => 'users',
'value' => 'all',
'compare' => '='
)
)
)
);

			  }

?>
<?php if ( $wpquery -> have_posts() ) : while ( $wpquery -> have_posts() ) : $wpquery -> the_post(); ?>
<?php //richiamo le info dell’utente associato al post
$user_selected = get_post_meta($post->ID, 'users', TRUE);
$user_info = get_userdata($user_selected);
?>
<div class="post">
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			    <?php the_content('Leggi…');?>
			    <?php if($user_selected == 'all') { ?>
			    	<small><i><?php  echo 'Contenuto per Tutti'; ?></i></small>
			    <?php } else  { ?>
			    	<small><i><?php  echo 'Contenuto per l\'utente: ' . $user_info->user_login . "\n";	 ?></i></small>
			    <?php } ?>
</div>

<hr />
		<?php endwhile; else: ?>
			<div class="post">
<h3>Spiacenti, non ci sono contenuti…</h3>
</div>
		<?php endif; ?>
		<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a>
	<?php } else { ?>
		Area Riservata
			<h2>Login</h2>
			<?php wp_login_form(); ?>
	<?php } ?>
</div>

<?php get_footer(); ?>
