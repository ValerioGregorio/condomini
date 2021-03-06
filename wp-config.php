<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via
 * web, è anche possibile copiare questo file in «wp-config.php» e
 * riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Prefisso Tabella
 * * Chiavi Segrete
 * * ABSPATH
 *
 * È possibile trovare ulteriori informazioni visitando la pagina del Codex:
 *
 * @link https://codex.wordpress.org/it:Modificare_wp-config.php
 *
 * È possibile ottenere le impostazioni per MySQL dal proprio fornitore di hosting.
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', "sql4398828" );


/** Nome utente del database MySQL */
define( 'DB_USER', "sql4398828" );


/** Password del database MySQL */
define( 'DB_PASSWORD', "FnmMtcqwdp" );


/** Hostname MySQL  */
define( 'DB_HOST', "sql4.freemysqlhosting.net" );


/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );


/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', 'utf8mb4_unicode_ci');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
 /*define( 'WP_POST_REVISIONS', false );*/
define( 'AUTH_KEY',         'XB{dY$Vx;1g3wch5.1CDCRRS~N#Q@{{%N)<x;.CV]>TAoB00.DSu+>D(tU7;mK<t' );

define( 'SECURE_AUTH_KEY',  'x}1t$4._^UD-8;(gw^NSNq&g=OGXRVGEA9=$A@osAUtWYWf{ ;](yQ:kZaRK31%j' );

define( 'LOGGED_IN_KEY',    '7}gk&S#g,a74}Pz#mdH3$)+u#FxL2|Bra0,5=f_SCwtTGRqv{n,JRSFb`U~Nc>B2' );

define( 'NONCE_KEY',        'aqCT.FrxJbm=o3omk~t+n^gvB&ly/[6p`idM{&I;MJ8aF~%KI}oppCJDBx$L0.u-' );

define( 'AUTH_SALT',        'k^C=e8NqgS%0CUvMl-x$[=g7]r<Qm2hnL]XLYcvBs/k3=4 .JQu&:*nrVoY.AUcS' );

define( 'SECURE_AUTH_SALT', '&Vg96_ /V.,sLBO4d}q1Pa9AEr^~%ZmOj)nB|fz-)NmQT5byw:QjPP|&ekze-$O`' );

define( 'LOGGED_IN_SALT',   'MITt8e*(8PH42zR|0UC!1#@7%rLl~pZCefwXCxI.o`#.a<hTf49o2&gAX[Bd /,9' );

define( 'NONCE_SALT',       '_r_q#WiF!c-vZMzseUsLS]yV0E>t+Uhxtp ^d[ZI[:46p>v5c:(W{RHc/kb}/SsJ' );


/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix = 'wp_';


/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi
 * durante lo sviluppo.
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 */
define('WP_DEBUG', false);

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
