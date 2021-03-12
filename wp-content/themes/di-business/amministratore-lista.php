<?php
/*
/*
Template name: Lista amministratore
*/
?>

<!--<h1>PAGINA TEMPLATE PRIVATO</h1>-->
<?php get_header()?>
<style>
.stileselect{
  width: 100%;
  display: flex;
  justify-content: center;
}

h1{
  text-align: center;
  color:blue;
}

.stileform{
  font-size: 20px;
}

</style>
<div class ="stileselect">
  <div class="allineastile">
    <h1>Seleziona il condomino</h1>
    <br>

<?php
get_header();
  $user_args  = array(
		// cerco solo gli utenti di tipo sottoscrittore
		'role' => 'Subscriber',
		'orderby' => 'display_name',
    'show_in_rest' => true,
	);
	// creo la WP_User_Query object
	$wp_user_query = new WP_User_Query($user_args);
	// richiamo i risultati
	$subscribers = $wp_user_query->get_results();
?>
<form class="stileform" action="<?php echo get_template_directory_uri().'/ammuserloop.php'?>" method="post">

<?php
echo "<select name='users'>";
foreach ($subscribers as $subscriber){
$subscriber_info = get_userdata($subscriber->ID);
$subscriber_id = get_post_meta($post->ID, 'users', true);
if($subscriber_id == $subscriber_info->ID) {
$subscriber_selected = 'selected="selected"';
} else {
  $subscriber_selected ='';
}//else
echo '<option value='.$subscriber_info->ID.' '.$subscriber_selected.'>'.$subscriber_info->display_name.'</option>';
}//foreach
echo "</select>";

?>
    <!--<input type="submit" name="submit" value="Get Selected Values" />-->
      <input type="submit" name="submit"/>
    </form>
    <?php
/*if(isset($_POST['submit']));/*{
As output of $_POST['Color'] is an array we have to use foreach Loop to display individual value
foreach ($_POST['users'] as $select)
{
echo "You have selected :" .$select; // Displaying Selected Value
}
}
?>
