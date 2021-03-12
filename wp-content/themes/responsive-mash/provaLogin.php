
<?php

/*
Template Name: provaLogin
*/
?>


<?php
if ( is_user_logged_in() ) {
    echo 'Welcome, registered user!';
} else {
    echo 'Benvenuto Registrati per rievere la nostra newsletter';
    wp_login_form();
}
?>
