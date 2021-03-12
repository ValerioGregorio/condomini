

<?php
/*
Template Name: select
*/

?>

<?php


  $user_args  = array(
		// cerco solo gli utenti di tipo sottoscrittore
		'role' => 'Subscriber',
		'orderby' => 'display_name'
	);
	// creo la WP_User_Query object
	$wp_user_query = new WP_User_Query($user_args);

	// richiamo i risultati
	$subscribers = $wp_user_query->get_results();
?>


  <select name='users'>
      <option value="all">Tutti</option>

      <?php
      foreach ($subscribers as $subscriber):?>
        //var_dump($subscriber);
        <option value="<?=$subscriber->user_nicename ?>"><?=$subscriber->user_nicename ?></option>
        //print_r($subscriber->user_nicename);
    <?php endforeach;
      ?>

	        <!-- echo ?> <option value="<?php //$subscribers[$subscriber]?>"></option>';-->
        </select>
