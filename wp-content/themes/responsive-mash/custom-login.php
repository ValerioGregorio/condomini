<script>

function reveal(){

    var pwd = document.getElementById('password');
    var pwdAttr = pwd.getAttribute('type');
    if (pwdAttr === 'password') {
     
        pwd.setAttribute("type", "text");
    } else {
        pwd.setAttribute("type", "password");
    }

}
    




function ajaxRequest(){
    var theme_directory = "<?php echo get_template_directory_uri() ?>";
    var site_url = "<?php echo site_url();?>"
        if (window.XMLHttpRequest) {
            var request = new XMLHttpRequest;
        }else{
            var request = new ActiveXObject(Microsoft.XMLHTTP);
        }   
    

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    

    request.responseType = "json";

    

    var formSerialize = "username="+username+"&password="+password;

   request.open('POST',theme_directory+'/inc/check-login.php',true);

   request.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    request.send(formSerialize);

    request.onload = function(){
        
       if (this.status==200){
           
           var  response = request.response;
           var formMessage = document.getElementById('form-message');
           var userInput = document.getElementById('username');
           var pwdImput = document.getElementById('password');


          
           if (response.message==='') {

                formMessage.classList = "login-success";
                window.location.assign(site_url+'/area-riservata');
                
            }else{

                formMessage.classList = "login-error";
                userInput.value = '';
                pwdImput.value = '';
            
            }
        
            

            

            formMessage.innerHTML = response.message; 

      


        }

   }

}



</script>



<?php
/**
 * Template Name: Custom Login Page
 */




get_header();

if (is_user_logged_in()) :
    global $current_user;
    get_currentuserinfo();
    $my_user = $current_user->user_login;
    
   

?>

       

<div class="row container-fluid"> <!-- container area riservata contenuti -->
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- container area benvenuto  -->

        <h2 style="font-weight:bold;">Benvenuto <?=strtoupper($my_user);?></h2> 
    </div><!-- fine container area benvenuto  -->
    
    <div class="col-lg-6 col-xs-12 col-sm-12"> <!-- container post privati  -->

    <?php
    //loop custom post type privati
        if (current_user_can('administrator')) {
            $wpquery = new WP_Query(array(

                    'post_type'  => 'areariservata',

                    


            ));
        }else{
            $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1; 
            $wpquery = new WP_Query(array(
                
                'post_type'  => 'areariservata',
                'utenti' =>	".  $my_user .", //imposto il nome dell'utente come valore della tassomia utenti
                'posts_per_page' => 10,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          =>  $current
                


            ));
        }    


        


    if ( $wpquery -> have_posts() ) : while ( $wpquery -> have_posts() ) : $wpquery -> the_post(); ?>

            <div class="post" style="width: 100%">

                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                <?php the_excerpt();?>

            </div>

             


            <hr/>

        <?php endwhile; ?>
    </div> <!-- fine container  post privati  -->
    
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style=""><!-- container pulsante logout  -->
        
        <a style="padding:5px 10px;font-size:16px;border: 2px solid green;height: 40px;width:100px;font-weight:bold;" href="<?php echo wp_logout_url( home_url().'/area-riservata' ); ?>" title="Logout">Esci</a>
   
    </div><!-- fine container pulsante logout  -->

    
   
</div>    <!-- fine container area riservata contenuti -->
    <div class="row" style="width:100%;text-align:center;"> <!-- container pagination link -->
        <div class="pagination-custom col-lg-6 offset-lg-3 col-md-6 offset-md-3" ">       
                <?php 
                
                
                $page_args = array(
                    'total' => $wpquery->max_num_pages,
                    'current' => $current ,
                    
                );
                echo paginate_links($page_args); 

                
                ?>
        </div>    
    </div> <!-- end container pagination link -->    
   
   <?php else: ?>


        <div class="post row">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <h3>Non ci sono contenuti riservati per l'utente: <?php echo $my_user ?></h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">   
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="">
        
                    <a style="padding:5px 10px;font-size:16px;border: 2px solid green;height: 40px;width:100px;font-weight:bold;" href="<?php echo wp_logout_url( home_url().'/area-riservata' ); ?>" title="Logout">Esci</a>
    
                </div>
            </div>
        </div>
        </div>
         
    <?php endif;?>
     
<?php else :
   ?>

<div class="container"  id="container">

        
        
<div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 col-xs-12"  id="wrapper">  

    <h2>Accedi all'area riservata:</h2>

    <form id="form form-login">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="email" class="form-control" id="username" name="username" placeholder="">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            
            <div class="input-group-append">
                <input type="password" id="password" name="password" class="form-control" data-toggle="password" placeholder="">
                <a class="btn btn-default reveal" type="button" onclick="reveal()">
                    <span class="input-group-text">
                        <i class="fa fa-eye"></i>
                    </span>
                </a>

            </div>

        </div>
        
        
        <input id="subscribe-btn" type="button" class="btn btn-success" onclick="ajaxRequest()" value="LOGIN"/><br>
        <div id="form-message" class="form-message"></div> 
       

    </form>
</div>
</div>  


   
<?php 
endif;
?>
<?php get_footer(); ?>

