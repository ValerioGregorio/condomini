<?php
/*
*Template name: Prova
*/
 ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/condomini/wp-config.php' );?><!-- senza questa istruzione non vengono riconosciute
le funzione wordpress ma solo il linguaggio php -->

<?php get_header();
 //echo ('utente selezionato da select amministratore');?><br>
<?php
if(isset($_POST["users"])); // senza questa verifica $_POST non visualizza niente. Si tratta di una precauzione insita nella struttura php
//echo $_POST["users"];?><br>
<?php $utente = $_POST["users"];?>
<?php //echo ('variabile $utente:  '.'<br>'.$utente.'<br>');
//var_dump($_POST);?>
 <!--<br><br>-->

<?php // The Query
$args = array(
'post_type' => 'selezionautente',
'orderby' => 'title',
'meta_key' => 'users',
'meta_value' => $utente,
);

$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
    echo '<ul>';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        //echo '<li>'.'<h1>' . get_the_title() . '</h1>'.'</li>';
        //echo '<li>' . get_the_excerpt() . '</li>';
        get_template_part( 'template-parts/content', 'loop' );?>
        <!--<a href=" <?php //the_permalink();?>"title="<?php //the_title_attribute();?>"><?php //the_title()?>;</a>
          <?php //the_excerpt();?>-->
<?php
    }
    echo '</ul>';
    di_business_posts_pagination();
} else {
    echo ('no posts found');
}
/* Restore original Post Data */
wp_reset_postdata(); ?>

 <br>


<?php


// The Query
  //$subscriber_info = get_userdata($subscriber->ID);

 ?>
