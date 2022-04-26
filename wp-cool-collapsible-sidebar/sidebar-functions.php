<?
add_action( 'wp_enqueue_scripts', 'GOLLCDT_enqueue' );
function GOLLCDT_enqueue() {

	wp_enqueue_style( 'GOLLCDT-sidebar-style', get_template_directory_uri() . '/wp-cool-collapsible-sidebar/sidebar.css' );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'GOLLCDT-script', get_template_directory_uri() . '/js/script.js', array( 'jquery', 'bootstrap' ));
	wp_enqueue_script( 'GOLLCDT-sidebar-script', get_template_directory_uri() . '/wp-cool-collapsible-sidebar/sidebar.js', array( 'jquery' ));

}

add_action( 'widgets_init', 'GOLLCDT_widgets_init' );
function GOLLCDT_widgets_init() {
	register_sidebar( array(
		'name'					=> esc_html__( 'Sidebar Widget Area', 'GOLLCDT' ),
		'id'					=> 'primary-widget-area',
		'before_widget'			=> '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'			=> '</li>',
		'before_title'			=> '<h3 class="widget-title">',
		'after_title'			=> '</h3>',
	));
}


add_filter( 'sidebars_widgets','GOLLCDT_wpbootstrap_checksidebars_widgets' );
function GOLLCDT_wpbootstrap_checksidebars_widgets( $sidebars_widgets ) {
	return $sidebars_widgets;
}

//add_filter( 'wp_nav_menu_args', 'GOLLCDT_sidebar_nav_widgets_walker' );
function GOLLCDT_sidebar_nav_widgets_walker( $args ) {
	return array_merge( $args, array(
		'walker' => new bootstrap_5_wp_nav_menu_walker(),
		// another setting go here ... 
	));
}

add_action( 'init', 'GOLLCDT_sidebar_nav_widgets_init' );
function GOLLCDT_sidebar_nav_widgets_init() {

	register_nav_menus(
		array(
			"gollcdt-funnels-menu-customizer" => __( "Customizer Preview" )
		)
	);

	$args = array(
		'post_type'				=> 'gollcdt-funnels',
		'posts_per_page'		=> -1,
		'post_status'			=> 'publish',
		'orderby'				=> 'menu_order',
		'order'					=> 'ASC', 
	);

	$sidebars = get_posts( $args );

	$i=0;
	foreach ( $sidebars as $key => $sidebar) {

		$sidebar_id = "gollcdt-funnels-{$sidebar->ID}";
		register_nav_menus(
			array( 
				"gollcdt-funnels-menu-{$sidebar->ID}" => __( "Drawer | {$sidebar->post_title} (ID: '{$sidebar->ID}') Menu" )
			)
		);

	}
}

function GOLLCDT_customizer_sidebar( $callback, $callback_preview ) {
	
	if( is_customize_preview() && !!$callback_preview )
		return $callback_preview();
	
	return $callback();
	
}


class Preview_Drawer {

    public $ID;
    public $post_title;
    public $icon;
    public function __construct( $ID, $post_title, $icon ) {

        $this->ID = $ID;
        $this->post_title = $post_title;
        $this->icon = $icon;

    }

}

add_action( 'widgets_init', 'GOLLCDT_sidebar_widgets_init' );
function GOLLCDT_sidebar_widgets_init() {

    register_sidebar(
        array(
            'name'				=> _x( "Customizer Preview", 'GOLLCDT' ),
            'id'				=> 'gollcdt-funnels-customizer',
            'before_widget'		=> '<li id="%1$s" class="gollcdt-funnels gollcdt-funnels-customizer-container %2$s mb-1">',
            'after_widget'		=> '</li>',
            'before_title'		=> '<h3 class="widget-title">',
            'after_title'		=> '</h3>',
            'theme_location'	=> 'gollcdt-funnels-menu-customizer',
        )
    );

    $args = array(
        'post_type'				=> 'gollcdt-funnels',
        'posts_per_page'		=> -1,
        'post_status'			=> 'publish',
        'orderby'				=> 'menu_order',
        'order'					=> 'ASC', 
    );

    $sidebars = get_posts( $args );

    $i=0;
    foreach ( $sidebars as $key => $sidebar) {

        $sidebar_id = "gollcdt-funnels-{$sidebar->ID}";
        
        register_sidebar(
            array(
                'name'				=> _x( "Drawers | {$sidebar->post_title} (ID: '{$sidebar->ID}')", 'GOLLCDT' ),
                'id'				=> $sidebar_id,
                'before_widget'		=> '<li id="%1$s" class="gollcdt-funnels gollcdt-funnels-' . $sidebar->ID . '-container %2$s mb-1">',
                'after_widget'		=> '</li>',
                'before_title'		=> '<h3 class="widget-title">',
                'after_title'		=> '</h3>',
                'theme_location'	=> "gollcdt-funnels-menu-{$sidebar->ID}",
            )
        );
        $i++;

    }

}

add_action( 'init', 'GOLLCDT_create_widget_posts_posttype' );
function GOLLCDT_create_widget_posts_posttype() {

    $labels = array(
        'name'					=> _x( 'Drawers', 'Post Type General Name', 'GOLLCDT' ),
        'singular_name'			=> _x( 'Drawer', 'Post Type Singular Name', 'GOLLCDT' ),
        'menu_name'				=> __( 'Drawers', 'GOLLCDT' ),
        'parent_item_colon'		=> __( 'Parent Drawer', 'GOLLCDT' ),
        'all_items'				=> __( 'All Drawers', 'GOLLCDT' ),
        'view_item'				=> __( 'View Drawer', 'GOLLCDT' ),
        'add_new_item'			=> __( 'Add New Drawer', 'GOLLCDT' ),
        'add_new'				=> __( 'Add New', 'GOLLCDT' ),
        'edit_item'				=> __( 'Edit Drawer', 'GOLLCDT' ),
        'update_item'			=> __( 'Update Drawer', 'GOLLCDT' ),
        'search_items'			=> __( 'Search Drawer', 'GOLLCDT' ),
        'not_found'				=> __( 'Not Found', 'GOLLCDT' ),
        'not_found_in_trash'	=> __( 'Not found in Trash', 'GOLLCDT' ),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'					=> __( 'Drawers', 'GOLLCDT' ),
        'description'			=> __( 'Drawer Data', 'GOLLCDT' ),
        'labels'				=> $labels,
        // Features this CPT supports in Post Editor
        'supports'				=> array( 'title', 'revisions', 'page-attributes', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'			=> array('category'),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child funnels. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'			=> false,
        'public'				=> true,
        'menu_icon'				=> 'dashicons-networking',
        'show_ui'				=> true,
        'show_in_menu'			=> true,
        'show_in_nav_menus'		=> true,
        'show_in_admin_bar'		=> true,
        'menu_position'			=> 5,
        'can_export'			=> true,
        'has_archive'			=> true,
        'exclude_from_search'	=> true,
        'publicly_queryable'	=> false,
        'capability_type'		=> 'post',
        'show_in_rest'			=> true,
    );

    // Registering your Custom Post Type
    register_post_type( 'gollcdt-funnels', $args );

}

/**
* add order column to admin listing screen for header text
*/
add_action('manage_gollcdt-funnels_posts_columns', 'GOLLCDT_add_new_funnels_column');
function GOLLCDT_add_new_funnels_column( $funnels_columns ) {

    $funnels_columns[ 'menu_order' ] = "Order";
    return $funnels_columns;

}

/**
* show custom order column values
*/
add_action('manage_gollcdt-funnels_posts_custom_column','GOLLCDT_show_menu_order_column');
function GOLLCDT_show_menu_order_column( $name ) {

    global $post;

    switch( $name ) {
        case 'menu_order':
            $order = $post->menu_order;
            echo $order;
            break;
    default:
            break;
    }

}

/**
* make column sortable
*/
add_filter('manage_edit-gollcdt-funnels_sortable_columns','GOLLCDT_menu_order_column_register_sortable');
function GOLLCDT_menu_order_column_register_sortable( $columns ) {

    $columns[ 'menu_order' ] = 'menu_order';

    return $columns;

}

add_action( 'add_meta_boxes', 'GOLLCDT_widget_posts_add_meta_box' );
function GOLLCDT_widget_posts_add_meta_box() {

    add_meta_box(
        'widget_posts_icon_meta_box_id',		// Unique ID
        'Icon',									// Box title
        'widget_posts_icon_meta_box_html',		// Content callback, must be of type callable
        'gollcdt-funnels',						// Post type
        'side'
    );

}

function widget_posts_icon_meta_box_html( $post ) {

    $value	= get_post_meta( $post->ID, '_icon_meta_key', true );
    $icon	= isset( $value[ 'icon_i_class' ]) ? $value[ 'icon_i_class' ] : '';

    ?>
    <div class="misc-pub-section">
        <label for="icon_i_class">Menu Icon <pre>.class</pre>:</label>
        <input name="icon_i_class" id="icon_i_class" class="" type="text" placeholder="Icon" value="<?php echo $icon; ?>" />
    </div>
    <?php

}

add_action( 'save_post', 'widget_posts_icon_save_meta_box' );
function widget_posts_icon_save_meta_box( $post_id ) {

    $icon_i_class	= isset( $_POST[ 'icon_i_class' ])?$_POST[ 'icon_i_class' ]:'';

    update_post_meta(
        $post_id,
        '_icon_meta_key',
        array(
            'icon_i_class'	=> $icon_i_class
        )
    );

}

function sidebars_drawers() {
	
	$is_customize_preview = is_customize_preview();
	$cpt = 'gollcdt-funnels';
	$menus = array();
	$drawers = array();
	$i = 0;
	$white_space = ' ';

	$sidebar_drawers = get_posts(
		array(
			'post_type'				=> 'gollcdt-funnels',
			'posts_per_page'		=> -1,
			'post_status'			=> 'publish',
			'orderby'				=> 'menu_order',
			'order'					=> 'ASC', 
		)
	);

	if( $is_customize_preview ) {

		$sidebar_drawers = array(
			new Preview_Drawer( 0, 'Drawer #0', 'bi bi-asterisk' ),
			new Preview_Drawer( 1, 'Drawer #1', 'bi bi-house-door-fill' ),
			new Preview_Drawer( 2, 'Drawer #2', 'bi bi-shop-window' ),
			new Preview_Drawer( 3, 'Drawer #3', null ),
			new Preview_Drawer( 4, 'Drawer #4', 'bi bi-chat-left-text-fill' ),
			new Preview_Drawer( 5, 'Drawer #5', 'bi bi-question-circle-fill' )
		);

	}
	
	foreach ( $sidebar_drawers as $key => $drawer ) {

		$id = "$cpt-{$drawer->ID}";

		if( !$is_customize_preview ) {

			$icon_meta = get_post_meta( $drawer->ID, '_icon_meta_key', true );

	 	} else {

			$icon_meta = array( 'icon_i_class' => $drawer->icon, 'icon_field' => $drawer->icon );
			$customize_preview_id = 'gollcdt-funnels-customizer';
			
		}

		$default = $i === 0 ? ' default selected active ' : '';
		$class = " {$default}$cpt";

		$icon_title = isset( $icon_meta['icon_i_class'] ) || isset( $icon_meta['icon_field'] ) ? $drawer->post_title : "Missing Icon for '{$drawer->post_title}'";

		$icon = isset( $icon_meta['icon_i_class'] ) ? $icon_meta['icon_i_class'] : $icon_meta['icon_field'] ?? 'missing-icon bi bi-slash-circle-fill';
		$icon = $white_space . $icon;

		ob_start();
		?>
		<div class="sidebar-nav-item">
			<a id="<?php echo $id; ?>-anchor"
				href="#<?php echo $id; ?>"
				class="sidebar-nav-link<?php echo $class; ?>"
				title="<?php echo _x( $icon_title, 'GOLLCDT' ); ?>">
				<i class="sidebar-nav-icon<?php echo $icon; ?>" aria-label="<?php echo $icon_title; ?>"></i>
			</a>
		</div>
		<?php
		$menus[] = ob_get_clean();

		ob_start();
		?>
		<div id="<?php echo $id; ?>" class="sidebar-drawer<?php echo "$class"; ?>">
			<?php if(true) { ?>
				<header class="sidebar-drawer-header theme-heading header mb-2">
					<div class="p-2 bg-accent">
						<h1 class="entry-title" itemprop="name">
							<?php echo _x( $drawer->post_title, 'GOLLCDT' ); ?>
						</h1>
					</div>
				</header>
			<?php } ?>
			<ul class="xoxo ">
				<?php 
					$dynamic_sidebar_id = $customize_preview_id ?? $id;
					dynamic_sidebar( $dynamic_sidebar_id );
				?>
			</ul>
		</div>
		<?php
		$drawers[] = ob_get_clean();

		$i++;
	}

	wp_reset_postdata();
	wp_reset_query();

	return array( 'menus' => $menus, 'drawers' => $drawers );

}