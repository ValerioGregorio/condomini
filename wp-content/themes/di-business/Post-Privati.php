<?php
/*
Template name: Post Privati
*/
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/condomini/wp-config.php' );
get_header();?>
<!--<h1>QUESTA è LA PAGINA PRIVATA</h1>-->

<?php
// imposta il parametro "paged" (usa 'page' se la query è su una prima pagina statica)
 $paged = (get_query_var ('paged'))?  get_query_var ('paged'): 1;
 //echo ('USER LOGIN E: ' .$user_login);
 global $current_user;
 get_currentuserinfo();
 $my_user_id = $current_user->id;
 ?>
 <br>
 <?php //echo ('CURRENT USER ID: ' .$my_user_id)?><br>

<?php
$args = array(
  'post_type'=> 'selezionautente',
  //'utenti' => $user_login,
  'meta_key' => 'users',
  'meta_value' => $my_user_id,
  'posts_per_page' => 2,
  'paged' => $paged
);

$query = new WP_Query($args);
if($query->have_posts()):
  while($query->have_posts()) : $query->the_post();
  ?>
  <!---Loop-->
  <?php get_template_part( 'contentcondominio' );?>
<!--<h3 class="the-title" itemprop="headline"><a class="entry-title" rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a></h3>-->

      <?php //get_sidebar();?>
     <h2><?php //the_title();?></h2>
  <p><?php //the_excerpt();?></p>

<?php endwhile;?>

 <!-- utilizzo next_posts_link () con max_num_pages-->
<div class="col-12 navipost">
	<div class="row">
<?php
next_posts_link ('<< Indietro', $query-> max_num_pages);
previous_posts_link ('Avanti >>');
 ?>
	</div>
</div>



 <?php
 // ripulisce dopo la query e l'impaginazione
 wp_reset_postdata ();
 ?>

 <?php else:?>
 <p> <?php echo('Siamo spiacenti, nessun post corrisponde ai tuoi criteri.'); ?> </p>
 <?php endif;  ?>

<?php //get_footer(); ?>
