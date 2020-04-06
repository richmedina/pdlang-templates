<?php
/*
Template Name: experiences-front
*/
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
    'offset'			=> 1,
    'posts_per_page' 	=> 3,
);

$upcoming_posts = new WP_Query($args);

$args2 = array(
    'numberposts'   	=> -1,
    'post_type'      	=> 'experience',
    'meta_key'       	=> 'start_date',
    'meta_value'   		=> date( "Y-m-d" ),
    'meta_compare'		=> '<',
    'order'   			=> 'DESC',
    'orderby'			=> 'modified',
    'offset'			=> 0,
    'posts_per_page' 	=> 3,
);
$past_posts = new WP_Query($args2);

$args3 = array(
    'numberposts'   	=> -1,
    'post_type'      	=> 'experience',
    'meta_key'       	=> 'start_date',
    'meta_value'   		=> date( "Y-m-d" ),
    'meta_compare' 		=> '>=',
    'order'   			=> 'ASC',
    'orderby'			=> 'start_date',
    'offset'			=> 0,
    'posts_per_page' 	=> 1,
);

$featured = new WP_Query($args3);

$args4 = array(
    'numberposts'   	=> -1,
    'post_type'      	=> 'experience',
    'meta_key'       	=> 'start_date',
    'meta_value'   		=> date( "Y-m-d" ),
    'meta_compare'		=> '<',
    'order'   			=> 'DESC',
    'orderby'			=> 'start_date',
    'offset'			=> 0,
    'posts_per_page' 	=> 1,
);

$featured2 = new WP_Query($args4);

?>	

<div id="main-content">
	<div class="et_pb_module et_pb_code et_pb_code_0">				
		<div class="et_pb_code_inner">
			<style>				
					.left-blog-image .et_pb_post .entry-featured-image-url {
						float: left;
						width: 100%;
						max-width: 150px;
						margin: 0px 20px 30px 0;
					}
					/*.left-blog-image .et_pb_post {
						margin-bottom: 10px !important;
					}*/
					.entry-presenters {
						margin-top: -10px;
						font-size: 0.9em;
					}
					  .date-block {float: left; max-width: 48px; width: 48px; height: 80px; border: 1px solid #ecece9; text-align: center; font-weight: bold; margin-right: 10px;}
					  .date-block-top {background-color: #cc3333; color: white; padding: 5px; font-size: 1.0em; text-transform: uppercase;}
					  .date-block-bottom {font-size: 2.0em; padding-top: 10px;}
					  .label {padding:5px; font-weight:800; font-size:80%; text-transform:uppercase; max-width: 64px; width: 64px;}
					  .lbl-blu {background-color:#0099cc; color:#ffffff}
					  .lbl-red {background-color:#cc3333; color:#ffffff}
					}
			</style>
		</div>
	</div> <!-- .et_pb_code -->
	<div class="et_pb_section et_pb_section_0 et_section_regular">							
		<div class="et_pb_row et_pb_row_0">
			<div class="et_pb_column et_pb_column_2_5 et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">
				<h2>Next Up</h2>
				<?php if ( $featured->have_posts() ) : ?>
					<?php  while ( $featured->have_posts() ) : $featured->the_post(); ?>
			 			<article id="post-<?php the_ID()?>" class="et_pb_post clearfix post-<?php the_ID()?> experience type-experience status-publish has-post-thumbnail hentry">
			 				<a href="<?php the_permalink();?>" class="entry-featured-image-url"><?php the_post_thumbnail();?></a>
							<div class="date-block">
								<?php 
									$s = get_field('start_date');
									$d = getdate(strtotime($s));
									$day = $d['mday'];
									$mon = substr($d['month'], 0, 3);
									echo "<div class='date-block-top'>{$mon}</div><div class='date-block-bottom'>{$day}</div>";
								?>
							</div>
							<h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
							<?php
								$posts = get_field('presenters__facilitators_relation');
								if( $posts ) {
								    foreach( $posts as $p) {
								    	$name = get_field('post_title', $p->ID);
								    	$affiliation = get_field('affiliation', $p->ID);
								    	$position = get_field('position', $p->ID);
								    	$link = get_permalink($p->ID);
								    	echo "<div class='entry-presenters'><a href='{$link}'>{$name}</a>, {$position}, {$affiliation} </div>";
								    }
								}								
							?>
							<div ><span class="label lbl-blu"><?php the_field('pd_resource');?></span></div>
							<p class="clearfix">
								<?php 
									$blurb = get_field('resource_description');
									$trim = wp_trim_words($blurb, 50, ' ...');
									echo $trim;							
								?>								
							</p>
							<div class=""><p>
								<?php 

								// the_terms( get_the_ID(), 'experience_tags', '', ', '); 
								$terms = get_the_terms($post->ID, 'experience_tags', 'Topics ', ', ');
								if( $terms ) {
								    foreach( $terms as $p) {
								    	$name = $p->name;
								    	$link = get_term_link($p);
								    	echo "<a href='{$link}' class=''>{$name}</a>";
								    }
								}
								?>
									
							</p></div>				
						</article>
					<?php endwhile; ?>
				<?php endif; ?>		   
				<?php wp_reset_postdata();?>
				
			</div> <!-- .et_pb_column -->

			<div class="et_pb_column et_pb_column_3_5 et_pb_column_1 et_pb_css_mix_blend_mode_passthrough left-blog-image">
				<h2>Coming Soon</h2>
				<?php if ( $upcoming_posts->have_posts() ) : ?>
					<?php  while ( $upcoming_posts->have_posts() ) : $upcoming_posts->the_post(); ?>	
			 			<article id="post-<?php the_ID()?>" class="et_pb_post clearfix post-<?php the_ID()?> experience type-experience status-publish has-post-thumbnail hentry">

			 				<a href="<?php the_permalink();?>" class="entry-featured-image-url"><?php the_post_thumbnail();?></a>
							<div class="date-block">
								<?php 
									$s = get_field('start_date');
									$d = getdate(strtotime($s));
									$day = $d['mday'];
									$mon = substr($d['month'], 0, 3);
									echo "<div class='date-block-top'>{$mon}</div><div class='date-block-bottom'>{$day}</div>";
								?>
							</div>
							<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php the_field('resource_title');?></a></h3>
								<?php
									$posts = get_field('presenters__authors_relation');
									if( $posts ) {
									    foreach( $posts as $p) {
									    	$name = get_field('full_name', $p->ID);
									    	$affiliation = get_field('affiliation', $p->ID);
									    	$position = get_field('position', $p->ID);
									    	$link = get_permalink($p->ID);
									    	echo "<div class='entry-presenters'><a href='{$link}'>{$name}</a>, {$position}, {$affiliation} </div>";
									    }
									}								
								?>
							<div ><span class="label lbl-blu"><?php the_field('pd_resource');?></span></div>
							<p class="clearfix">
								<?php 
									$blurb = get_field('resource_description');
									$trim = wp_trim_words($blurb, 20, ' ...');
									echo $trim;							
								?>								
							</p>
							<div class=""><p>
								<?php 

								// the_terms( get_the_ID(), 'experience_tags', '', ', '); 
								$terms = get_the_terms($post->ID, 'experience_tags', 'Topics ', ', ');
								if( $terms ) {
								    foreach( $terms as $p) {
								    	$name = $p->name;
								    	$link = get_term_link($p);
								    	echo "<a href='{$link}' class=''>{$name}</a>";
								    }
								}
								?>
									
							</p></div>
						</article>
					<?php endwhile; ?>
				<?php else: ?>
					<p>Nothing coming up</p>
				<?php endif; ?>		   
				<?php wp_reset_postdata();?>
			</div> <!-- .et_pb_column -->
		</div> <!-- .et_pb_row -->

		<div class="et_pb_row et_pb_row_0">
			<div class="et_pb_column et_pb_column_3_5 et_pb_column_0 et_pb_css_mix_blend_mode_passthrough left-blog-image">
				<h2>Recently Updated</h2>
				<?php if ( $past_posts->have_posts() ) : ?>
					<?php  while ( $past_posts->have_posts() ) : $past_posts->the_post(); ?>	
						<article id="post-<?php the_ID()?>" class="et_pb_post clearfix post-<?php the_ID()?> experience type-experience status-publish has-post-thumbnail hentry">
							<a href="<?php the_permalink();?>" class="entry-featured-image-url"><?php the_post_thumbnail();?></a> 
							<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php the_field('resource_title');?></a></h3>
							<div> <span style="float:right; font-size: 0.7em;"> Updated <?php echo the_modified_date();?></span></div>
							<?php
								$posts = get_field('presenters__authors_relation');
								if( $posts ) {
								    foreach( $posts as $p) {
								    	$name = get_field('full_name', $p->ID);
								    	$affiliation = get_field('affiliation', $p->ID);
								    	$position = get_field('position', $p->ID);
								    	$link = get_permalink($p->ID);
								    	echo "<div class='post-content'><a href='{$link}'>{$name}</a> </div>";
								    }
								}								
							?>
							<div class="post-content"><span class="label lbl-blu"><?php the_field('pd_resource');?></span></div>
							<div class="post-content"><p> 
								<?php 
									$blurb = get_field('resource_description');
									$trim = wp_trim_words($blurb, 20, ' ...');
									echo $trim;
								?>
							</p></div>
								
							<div class="post-content"><p><?php the_terms( get_the_ID(), 'experience_tags', '', ', '); ?></p>	</div>
						</article>
					<?php endwhile; ?>
				<?php endif; ?>		   
				<?php wp_reset_postdata();?>
			</div> <!-- .et_pb_column -->

			<div class="et_pb_column et_pb_column_2_5 et_pb_column_1 et_pb_css_mix_blend_mode_passthrough">
				<h2>Recently Featured</h2>
				<?php if ( $featured2->have_posts() ) : ?>
					<?php  while ( $featured2->have_posts() ) : $featured2->the_post(); ?>
			 			<article id="post-<?php the_ID()?>" class="et_pb_post clearfix post-<?php the_ID()?> experience type-experience status-publish has-post-thumbnail hentry">
			 				<a href="<?php the_permalink();?>" class="entry-featured-image-url"><?php the_post_thumbnail();?></a>			
							<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="post-content"><span class="published"><?php the_field('start_date');?></span> </div>
							<?php
								$posts = get_field('presenters__authors_relation');
								if( $posts ) {
								    foreach( $posts as $p) {
								    	$name = get_field('full_name', $p->ID);
								    	$affiliation = get_field('affiliation', $p->ID);
								    	$position = get_field('position', $p->ID);
								    	$link = get_permalink($p->ID);
								    	echo "<div class='post-content'><a href='{$link}'>{$name}</a> </div>";
								    }
								}								
							?>
							<div class="post-content"><span class="label lbl-blu"><?php the_field('pd_resource');?></span>
							<div class="post-content"><?php the_field('resource_description');?></div>
							<div class="post-content"><p><?php the_terms( get_the_ID(), 'experience_tags', '', ', '); ?></p>	</div>
						</article>
					<?php endwhile; ?>
				<?php endif; ?>		   
				<?php wp_reset_postdata();?>
				
			</div> <!-- .et_pb_column -->
		</div> <!-- .et_pb_row -->
		<div class="et_pb_row et_pb_row_0">
			<div class="et_pb_column et_pb_column_4_4 et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">
				<h2>Browse by Descriptor</h2>
				<?php 
					$xtags = get_terms( array(
						'taxonomy' 	=> 'experience_tags',
						'hide_empty'=> true,
						'orderby' 	=> 'count',
						'order'		=> 'DESC'
					)); 
				?>
				<ul>
					<?php foreach( $xtags as $term ) : ?>
						<li><a href="<?php print_r(esc_url( get_term_link( $term ))); ?>"> <?php print_r($term->name); ?></a> (<?php print_r($term->count) ?>)</li>
					<?php endforeach; ?>
				</ul>
			</div><!-- .et_pb_column -->
			<div class="et_pb_column et_pb_column_4_4 et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">
				<h2>Browse by Series</h2>
				<?php 
					$xtags = get_terms( array(
						'taxonomy' 	=> 'series',
						'hide_empty'=> true,
						'orderby' 	=> 'count',
						'order'		=> 'DESC'
					)); 
				?>
				<ul>
					<?php foreach( $xtags as $term ) : ?>
						<li><a href="<?php print_r(esc_url( get_term_link( $term ))); ?>"> <?php print_r($term->name); ?></a> (<?php print_r($term->count) ?>)</li>
					<?php endforeach; ?>
				</ul>
			</div><!-- .et_pb_column -->
		</div><!-- .et_pb_row -->




	</div> <!-- .et_pb_section -->
</div> <!-- #main-content -->
<?php get_footer(); 
