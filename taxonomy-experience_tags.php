/*
Template Name: experiences-tag-layout
*/

<?php
wp_enqueue_script("jquery"); 

get_header();

$args = array(
    'numberposts'   	=> -1,
    'post_type'      	=> 'experience',
    'meta_key'       	=> 'start_date',
    'meta_value'   		=> date( "Y-m-d" ),
    'meta_compare' 		=> '>=',
    'order'   			=> 'ASC',
    'orderby'			=> 'start_date',
    'posts_per_page' 	=> -1,
);

$exps = new WP_Query($args);

?>

<div id="main-content">
	

	
</div>



<?php get_footer();
