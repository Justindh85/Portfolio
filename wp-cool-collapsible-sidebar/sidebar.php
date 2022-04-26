<?php $sidebar = sidebars_drawers(); ?>
<aside id="sidebar" role="complementary">
	<div id="sidebar-menus" class="">
		<div class="sidebar-menus-sections sidebar-menus-top">
			<a class="sidebar-drawer-toggle" href="#">
				<i class="open-drawer show bi-arrow-right-short" aria-label="Open"></i>
				<i class="close-drawer bi bi-arrow-left-short" aria-label="Close"></i>
			</a>
		</div>
		<div id="sidebar-nav" class="sidebar-menus-sections">
			<?php foreach( $sidebar[ 'menus' ] as $key => $drawer ) { echo $drawer; } ?>
		</div>
		<div class="sidebar-menus-sections sidebar-menus-bottom">
			<a class="sidebar-drawer-toggle" href="#">
				<i class="open-drawer show bi-arrow-right-short" aria-label="Open"></i>
				<i class="close-drawer bi bi-arrow-left-short" aria-label="Close"></i>
			</a>
		</div>
	</div>
	<div id="sidebar-drawers">
		<?php foreach( $sidebar[ 'drawers' ] as $key => $drawer ) { echo $drawer; } ?>
	</div>
</aside>