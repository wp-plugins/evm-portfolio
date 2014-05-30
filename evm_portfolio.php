<?php 

/*

  Plugin Name: EVM portfolio

  Plugin URI: http://www.expertvillagemedia.com/portfolio

  Description: Using this free portfolio plugin you can showcase your work in a jquery filtered portfolio system. You can also enable social sharing buttons on portfolio items

  Version: 1.2

  Author: Amit Porwal, Ashish Mishra

  Author URI: http://www.expertvillagemedia.com/

  License: GPLv2 or later

 */



$direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/evm-portfolio"; 



function evm_get_version(){

	if (!function_exists( 'get_plugins' ) )

	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );

	$plugin_file = basename( ( __FILE__ ) );

	return $plugin_folder[$plugin_file]['Version'];

}



add_action('init', 'portfolio_custom_init');  	

	/*-- Custom Post Init Begin --*/

function portfolio_custom_init()

	{

	  $labels = array(

		'name' => _x('Portfolios', 'post type general name'),

		'singular_name' => _x('Portfolio', 'post type singular name'),

		'add_new' => _x('Add New', 'portfolios'),

		'add_new_item' => __('Add New Portfolio'),

		'edit_item' => __('Edit Portfolio'),

		'new_item' => __('New Portfolio'),

		'view_item' => __('View Portfolio'),

		'search_items' => __('Search Portfolios'),

		'not_found' =>  __('No portfolios found'),

		'not_found_in_trash' => __('No portfolios found in Trash'),

		'parent_item_colon' => '',

		'menu_name' => 'Portfolio'

	  );	



	 $args = array(

		'labels' => $labels,

		'public' => true,

		'publicly_queryable' => true,

		'show_ui' => true,

		'show_in_menu' => true,

		'query_var' => true,

		'rewrite' => true,

		'capability_type' => 'post',

		'has_archive' => true,

		'hierarchical' => false,

		'menu_position' => null,

		'supports' => array('title','editor','author','thumbnail','excerpt','comments', 'post-formats')

	  );



	  // The following is the main step where we register the post.

	  register_post_type('portfolio',$args);

	  // Initialize New Taxonomy Labels



	  $labels = array(

		'name' => _x( 'Filters', 'taxonomy general name' ),

		'singular_name' => _x( 'Filter', 'taxonomy singular name' ),

		'search_items' =>  __( 'Search Types' ),

		'all_items' => __( 'All Filters' ),

		'parent_item' => __( 'Parent Filter' ),

		'parent_item_colon' => __( 'Parent Filter:' ),

		'edit_item' => __( 'Edit Filter' ),

		'update_item' => __( 'Update Filter' ),

		'add_new_item' => __( 'Add New Filter' ),

		'new_item_name' => __( 'New Filter Name' ),

	  );



		// Custom taxonomy for Portfolio Filters

		

		register_taxonomy('filterportifolio',array('portfolio'), array(

		'hierarchical' => true,

		'labels' => $labels,

		'show_ui' => true,

		'query_var' => true,

		'rewrite' => array( 'slug' => 'filter-portifolio' ),

	  ));

	}

	/*-- Custom Post Init Ends --*/

	/*--- Custom Messages - portfolio_updated_messages ---*/

add_filter('post_updated_messages', 'portfolio_updated_messages');

function portfolio_updated_messages( $messages ) {

	  global $post, $post_ID;

	  $messages['portfolios'] = array(

		0 => '', // Unused. Messages start at index 1.

		1 => sprintf( __('Portfolio updated. <a href="%s">View portfolio</a>'), esc_url( get_permalink($post_ID) ) ),

		2 => __('Custom field updated.'),

		3 => __('Custom field deleted.'),

		4 => __('Portfolio updated.'),

		5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,

		6 => sprintf( __('Portfolio published. <a href="%s">View portfolio</a>'), esc_url( get_permalink($post_ID) ) ),

		7 => __('Portfolio saved.'),

		8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview portfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),

		9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview portfolio</a>'),

		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),

		10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview portfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),

	  );

	  return $messages;

	}

	/*--- #end SECTION - portfolio_updated_messages ---*/

	/*--- Demo URL meta box ---*/

	

add_action('admin_init','portfolio_meta_init');

function portfolio_meta_init()

	{

		// add a meta box for wordpress 'portfolio' type

		add_meta_box('portfolio_meta', 'Portfolio URL', 'portfolio_meta_setup', 'portfolio', 'side', 'low');

		// add a callback function to save any data a user enters in

		add_action('save_post','portfolio_meta_save');

	}

	



function portfolio_meta_setup()

	{

		global $post;	 	 

		?>

		<div class="portfolio_meta_control">			

			<p>

			<input type="text" name="_url" value="<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />

			</p>

		</div>



		<?php

		// create for validation

		echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';

	}



function portfolio_meta_save($post_id) 

	{

		// check nonce

		if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {

		return $post_id;

	}

	// check capabilities

	if ('post' == $_POST['post_type']) {

	if (!current_user_can('edit_post', $post_id)) {

	return $post_id;

	}

		} elseif (!current_user_can('edit_page', $post_id)) {

		return $post_id;

		}

		// exit on autosave

		if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {

		return $post_id;

		}



		if(isset($_POST['_url'])) 

		{

			update_post_meta($post_id, '_url', $_POST['_url']);

		} else 

		{

			delete_post_meta($post_id, '_url');

		}

	}	

	

	

function enqueue_filterable() 

	{

		wp_register_script( 'filterable', get_bloginfo('wpurl').'/wp-content/plugins/evm-portfolio/js/filterable.js', array( 'jquery' ) );

		wp_enqueue_script( 'filterable' );

	}

add_action('wp_enqueue_scripts', 'enqueue_filterable');



function evm_portfolio_admin_menu() {

    add_submenu_page('edit.php?post_type=portfolio', 'settings', 'Settings', 'manage_options', 'portfolio_settings', 'portfolio_settings_page');; 

}



add_action('admin_menu', 'evm_portfolio_admin_menu');



function portfolio_settings_page(){

	

require_once( ABSPATH . 'wp-content/plugins/evm-portfolio/options.php' ); 



	

}









function evm_portfolio(){	

$evm_fb= get_option('evm_fb'); 

$evm_twitter= get_option('evm_twitter');

$evm_linkedin= get_option('evm_linkedin');



				 $terms = get_terms("filterportifolio");

				 $count = count($terms);

				 echo '<ul id="portfolio-filter">';

				 echo '<li><a href="#all" title="">All</a></li>';

				 if ( $count > 0 ){

						foreach ( $terms as $term ) {		

							$termname = strtolower($term->name);

							$termname = str_replace(' ', '-', $termname);

							echo '<li><a href="#'.$termname.'" title="" rel="'.$termname.'">'.$term->name.'</a></li>';

						}

				 }

				 echo "</ul>";

?>

<?php 

				$loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => -1));

				$count =0;

			?>

			<div id="portfolio-wrapper">

				<ul id="portfolio-list">

<?php if ( $loop ) : 

					while ( $loop->have_posts() ) : $loop->the_post(); ?>

<?php

						$terms = get_the_terms( $post->ID, 'filterportifolio' );

						if ( $terms && ! is_wp_error( $terms ) ) : 

							$links = array();

							foreach ( $terms as $term ) 

							{

								$links[] = $term->name;

							}

							$links = str_replace(' ', '-', $links);	

							$tax = join( " ", $links );	

						else :	

							$tax = '';	

						endif;

?>





<?php $infos = get_post_custom_values('_url'); ?>

						<li class="portfolio-item <?php echo strtolower($tax); ?> all">

							<div class="thumb"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( array(250, 250) ); ?></a></div>

<div class="evm_veiw"><a href="<?php wp_create_nonce(__FILE__); ?>" target="_blank"> <?php echo '<img src="' . plugins_url( 'img/view-details_new.png' , __FILE__ ) . '" > ';?></a></div>

	

				<span class="portfolio-item-meta"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> </span>	                            

                            <div class="live-site"> </div>                                               

                        

                        </li>

                        

                        

<?php endwhile; else: ?>

					<li class="error-not-found">Sorry, no portfolio entries for while.</li>		

<?php endif; ?>

				</ul>

				<div class="clearboth"></div>

			</div>

            

<style type="text/css">

#portfolio-filter {list-style-type: none;margin-top: 10px;}

#portfolio-filter li {display: inline; margin:0;} 

#portfolio-filter li a {background-color:#f1f1f1;  border: 1px solid #DBDBDB; color: #7B6666;font-size: 14px; padding: 8px 15px 8px 18px;

 text-decoration: none;}

#portfolio-filter li .current,#portfolio-filter li:hover {color: #084a9a;}

#portfolio-wrapper {float: left; margin-top: 20px;padding-bottom: 25px; width: 100%;}

#portfolio-list {list-style-type: none;}

#portfolio-list .portfolio-item {border: 1px solid #EEEEEE;box-shadow: 0 1px 2px 0 rgba(180, 180, 180, 0.2);float: left;margin: 5px;

height:<?php echo get_option('evm_height'); ?>;  padding: 8px;  width:<?php echo get_option('evm_width'); ?>;} 

	

#portfolio-list li .thumb{margin: auto; display: table; }



#portfolio-list li .thumb a{float:left; width:100%;}

#portfolio-list li .thumb img{float: left; margin: 0; max-height: 280px; width: 100%;}

#portfolio-list .portfolio-item .portfolio-item-meta{float: left; width: 89.1%; padding: 10px 15px;}



#portfolio-list .portfolio-item .portfolio-item-meta a {color:<?php echo get_option('evm_tcolor'); ?>; float: left; font-size: 16px; font-weight: bold; text-align: center; text-transform: capitalize; width: 100%;}

#portfolio-list .portfolio-item .excerpt{text-align: justify;font-size: 14px;line-height: 18px;	padding-right: 15px;margin-bottom: 5px;}

#portfolio-list .portfolio-item .excerpt a {color: #555;}

#portfolio-list .portfolio-item .excerpt a:hover {text-decoration: none;}

.fb{ float:left; width:27%; margin-right:10px;} 

.twitter{float:left; width:29%; margin-right:10px;}

.linkedin{ float:left; width:34%; } 

#portfolio-list li:hover .live-site{  display: block;  position: absolute; top: 0;  width: 96%;  z-index: 99999;}



.live-site{display:none;}

.evm_veiw {bottom: 46%; left: 27%; position: absolute;z-index: 999999;}

#portfolio-list li:hover .evm_veiw {display: block;}

#portfolio-list li .evm_veiw{display: none;}

#portfolio-list li:hover {background-color:<?php echo get_option('evm_color'); ?>;box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); position: relative;transition: all 0.5s ease 0s;z-index: 99999; opacity:0.6; }

li.portfolio-item:hover .portfolio-item-meta {  background-color:<?php echo get_option('evm_htbcolor'); ?>; left: 0px; position: absolute; z-index: 9999; bottom:0px;  }

li.portfolio-item:hover .portfolio-item-meta a {color:<?php echo get_option('evm_htcolor'); ?> !important;}



</style>   			



<script type="text/javascript">

	jQuery(document).ready(function() {	

	jQuery("#portfolio-list").filterable();

	});

</script>   

       

<?php

}



function evmportfolio_shortcode() {

	ob_start();

	evm_portfolio();

	$out1 = ob_get_contents();

	ob_end_clean();

	return $out1;

}

add_shortcode('evm-portfolio','evmportfolio_shortcode');




function your_plugin_settings_link($links) { 

  $settings_link = '<a href="edit.php?post_type=portfolio&page=portfolio_settings">Settings</a>'; 

  array_unshift($links, $settings_link); 

  return $links; 

}

 

$plugin = plugin_basename(__FILE__); 

add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );

?>