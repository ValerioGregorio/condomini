<?php get_header(); ?>

<?php
if( get_theme_mod( 'breadcrumbx_setting', '1' ) == '1' )
{
	di_business_breadcrumbs();
}

$single_layout = esc_attr( get_theme_mod( 'blog_single_layout', 'rights' ) );
?>
<?php get_sidebar();?>

<div class="<?php if( $single_layout == 'rights' ) { echo 'col-md-8'; } elseif( $single_layout == 'lefts' ) { echo 'col-md-8 layoutleftsidebar'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >
		
		<?php
		while( have_posts() ) : the_post();
		
			get_template_part( 'content', get_post_format() );
			
			comments_template();
		

          
            //di_business_post_navigation();
		
		endwhile;
		
        	/*updated on 24012020*/
           

            global $wpdb;
            $currentId = get_the_id();
            
            //previous post
            $theQuery = "SELECT  IFNULL(max(p.id),0) as id FROM wp_terms wt";
            $theQuery.= " INNER JOIN wp_term_taxonomy wtt ON wt.term_id = wtt.term_id";
            $theQuery.= " INNER JOIN wp_term_relationships wtr ON wtt.term_taxonomy_id = wtr.term_taxonomy_id";
            $theQuery.= "  INNER JOIN wp_posts p ON wtr.object_id = p.ID";
            $theQuery.= " WHERE p.post_type = 'areariservata' and wt.name='$current_user->user_login' and p.id<$currentId and p.post_status not in ('trash')";

            $result = $wpdb->get_var($theQuery);
             //echo 'RESULT = '.$result;
            
             if ($result==0){
                
                $theQuery2 = "SELECT  IFNULL(max(p.id),0) as id FROM wp_terms wt";
                $theQuery2.= " INNER JOIN wp_term_taxonomy wtt ON wt.term_id = wtt.term_id";
                $theQuery2.= " INNER JOIN wp_term_relationships wtr ON wtt.term_taxonomy_id = wtr.term_taxonomy_id";
                $theQuery2.= "  INNER JOIN wp_posts p ON wtr.object_id = p.ID";
                $theQuery2.= " WHERE p.post_type = 'areariservata' and wt.name='$current_user->user_login' and p.id not in ($currentId) and p.post_status not in ('trash')";
                
                $result = $wpdb->get_var($theQuery2);
                
            }

            //echo 'CURRENT_ID = '.$currentId.'<br>';
            //echo 'RESULT = '.$result;

          
                
                $previousUserPost = get_post_permalink($result);
                ?>
            <div class="container-fluid row">   
                <div class="col-lg-6 col-md-6">
                    <a href="<?= $previousUserPost;?>">Previous post</a> 
                </div>
            <?php
            
            
            //next post
               $theQuery = "SELECT  IFNULL(min(p.id),0) as id FROM wp_terms wt";
               $theQuery.= " INNER JOIN wp_term_taxonomy wtt ON wt.term_id = wtt.term_id";
               $theQuery.= " INNER JOIN wp_term_relationships wtr ON wtt.term_taxonomy_id = wtr.term_taxonomy_id";
               $theQuery.= "  INNER JOIN wp_posts p ON wtr.object_id = p.ID";
               $theQuery.= " WHERE p.post_type = 'areariservata' and wt.name='$current_user->user_login' and p.id>$currentId and p.post_status not in ('trash')";
   
               $result = $wpdb->get_var($theQuery);
                
               
                if ($result==0){
                  
                   $theQuery2 = "SELECT  IFNULL(min(p.id),0) as id FROM wp_terms wt";
                   $theQuery2.= " INNER JOIN wp_term_taxonomy wtt ON wt.term_id = wtt.term_id";
                   $theQuery2.= " INNER JOIN wp_term_relationships wtr ON wtt.term_taxonomy_id = wtr.term_taxonomy_id";
                   $theQuery2.= "  INNER JOIN wp_posts p ON wtr.object_id = p.ID";
                   $theQuery2.= " WHERE p.post_type = 'areariservata' and wt.name='$current_user->user_login' and p.id not in ($currentId) and p.post_status not in ('trash')";
                   
                   $result = $wpdb->get_var($theQuery2);
                   
               }
   
                
             
                   
                   $nextUserPost = get_post_permalink($result);
                   ?>
                <div class="col-lg-6 col-md-6" style="text-align:right">      
                    <a href="<?= $nextUserPost;?>">Next post</a>
                </div>
            </div>
               <?php
            /* fine */ ?>
              
	</div>
</div>
<?php if( $single_layout == 'rights' || $single_layout == 'lefts' ) { get_sidebar(); } ?>
<?php get_footer(); ?>
