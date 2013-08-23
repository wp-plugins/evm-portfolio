<?php 
/*
  Plugin Name: EVM portfolio plugin
  Plugin URI: http://www.expertvillagemedia.com/portfolio
  Description: Using this free portfolio plugin you can showcase your work in a jquery filtered portfolio system. You can also enable social sharing buttons on portfolio items
  Version: 1.2
  Author: Amit Porwal, Ashish Mishra
  Author URI: http://expertvillagemedia.com/
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
							<div class="thumb"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( array(600, 300) ); ?></a></div>
							<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
							<p class="excerpt"><a href="<?php the_permalink() ?>"><?php excerpt('30'); ?></a></p>
							<p class="links"><a href="<?php echo $infos[0]; ?>" target="_blank">Live Preview &rarr;</a> <a href="<?php the_permalink() ?>">More Details &rarr;</a></p>
                           
							
                            <div class="socialicons">
                            <?php if($evm_fb=='true') { ?>
                            <div class="fb"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;
width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;">
							</iframe><div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script></div> 
							 <?php } ?>
							<?php if($evm_twitter=='true') { ?>                            
                            <div class="twitter"><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
                           	 <a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink($post->ID)); ?>&via=wpbeginner&count=horizontal" class="twitter-share-button">Tweet</a>
                            </div>

							<?php } if($evm_linkedin=='true') { ?>
                            <div class="linkedin"><script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-url="<?php the_permalink(); ?>" data-counter="right"></script></div>
							<?php } ?>
                        </div>
                       
                        
                        </li>
					<?php endwhile; else: ?>
					<li class="error-not-found">Sorry, no portfolio entries for while.</li>		
				<?php endif; ?>
				</ul>
				<div class="clearboth"></div>
			</div>
            
<style type="text/css">
#portfolio-filter {list-style-type: none;margin-top: 10px;}
#portfolio-filter li {display: inline;padding-right: 10px; margin:0;} 
#portfolio-filter li a {color: #777;text-decoration: none;border-left: 1px solid #333; border-radius: 10px 10px 10px 10px; padding: 5px 10px;}
#portfolio-filter li .current,#portfolio-filter li:hover {color: #084a9a;}
#portfolio-wrapper {float: left; margin-top: 20px;padding-bottom: 25px; width: 100%;}
#portfolio-list {list-style-type: none;}
#portfolio-list .portfolio-item {width: 288px;	float: left; margin: 0 16px 16px;}
#portfolio-list li .thumb{ float:left; width:100%;min-height: 310px;}
#portfolio-list .portfolio-item h3 a {color: #084a9a;text-transform: uppercase;	font-weight: bold;}
#portfolio-list .portfolio-item .excerpt{text-align: justify;font-size: 14px;line-height: 18px;	padding-right: 15px;margin-bottom: 5px;}
#portfolio-list .portfolio-item .excerpt a {color: #555;}
#portfolio-list .portfolio-item .excerpt a:hover {text-decoration: none;}
.fb{ float:left; width:27%; margin-right:10px;} 
.twitter{float:left; width:29%; margin-right:10px;}
.linkedin{ float:left; width:34%; } 
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



function excerpt($num) {
$limit = $num+1;
$excerpt = explode(' ', get_the_excerpt(), $limit);
array_pop($excerpt);
$excerpt = implode(" ",$excerpt)."...";
echo $excerpt;
}

function your_plugin_settings_link($links) { 
  $settings_link = '<a href="edit.php?post_type=portfolio&page=portfolio_settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );
?>