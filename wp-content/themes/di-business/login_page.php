<?php
/**
* Template Name: Login Page A2
*
* Login Page Template.
*
* @author Alessio Angeloro
* @since 1.0.0
*/
get_header(); ?>

<style>
section.a2_loginForm label {
width: 100%;
}
section.a2_loginForm input[type="text"],section.a2_loginForm input[type="password"] {
border-radius: 3px;
width: 100%;
}
section.a2_loginForm p.login-password::before {
content: "\f023";
font-family: fontawesome;
margin: 35px 0px 0px 334px;
position: absolute;
}
section.a2_loginForm p.login-username::before {
content: "\f007";
font-family: fontawesome;
margin: 35px 0 0 336px;
position: absolute;
}
section.a2_loginForm {
margin: 0 auto;
display: block;
width: 400px;
background: #ffffff;
border-radius: 3px;
padding: 22px;
}
</style>

<!-- section -->
<section class="a2_loginForm">
<?php
global $user_login;
// In case of a login error.
if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
<div class="a2_error">
<p><?php _e( 'FAILED: Try again!', 'A2' ); ?></p>
</div>
<?php
endif;

// If user is  already logged in.
if ( is_user_logged_in() ) : ?>
<div class="a2_logout">
<?php
_e( 'Ciao, sei connesso come ', 'A2' );
echo '<strong>' . $user_login .'</strong>';
?>
</div>
<!-- Pulsante Logout-->
<a id="wp-submit" class="btn btn-danger btn-lg" href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">
<?php _e( 'Logout', 'A2' ); ?>
</a>


<?php
// If user is not logged in visualizza il form.
else:
// Login form arguments.
$args = array(
'echo' => true,
'redirect' =>  ('https://side-web.it/condomini/riservato/'), //riporta alla pagina dei post privati
'form_id' => 'loginform',//classe assegnata al form visibile nel html generato
'label_username' => __( 'Username' ), // etichetta della casella
'label_password' => __( 'Password' ), // etichetta della casella
'label_remember' => __( 'Remember Me' ), // etichetta della casella
'label_log_in' => __( 'Log In' ),
'id_username' => 'user_login', //classe assegnata alla casella username  visibile nel html generato
'id_password' => 'user_pass', //classe assegnata alla casella password  visibile nel html generato
'id_remember' => 'rememberme', //classe assegnata alla casella ricordami  visibile nel html generato
'id_submit' => 'wp-submit', //classe assegnata al pulsante submit  visibile nel html generato
'remember' => true, //abilita l'opzione ricordami
'value_username' => NULL,
'value_remember' => true
);

// Calling the login form.
wp_login_form( $args );
endif;
if (current_user_can('administrator')):?>
<h2>Benvenuto amministratore effettua una delle scelte a tua disposizione</h2>
<br>

<ul>
	<li><h2> <a href="<?php bloginfo('wpurl');?>/wp-admin/">Bacheca</a></h2></li>
	<li> <h2><a href="<?php bloginfo('wpurl');?>/wp-admin/post-new.php">Scrivi un post</a><h2></li>
</ul>

<?php endif;?>




<?php get_footer(); ?>
