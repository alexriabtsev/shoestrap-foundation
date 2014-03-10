<?php global $ss_framework, $ss_settings; ?>

<?php $orientation = $ss_settings['navigation-type'] == 'off-canv-r' ? 'right' : 'left'; ?>
<div class="off-canvas-wrap">
	<div class="inner-wrap">
		<nav class="tab-bar">
			<section class="<?php echo $orientation; ?>-small">
				<a class="<?php echo $orientation; ?>-off-canvas-toggle menu-icon" ><i class="el-icon-lines"></i></a>
			</section>

			<section class="middle tab-bar-section">
				<h1><a class="brand" href="<?php echo home_url('/'); ?>"><?php echo $ss_framework->logo(); ?></a></h1>
			</section>

		</nav>

		<aside class="<?php echo $orientation; ?>-off-canvas-menu">
			<?php if ( has_nav_menu( 'primary_navigation' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'menu_class' => 'off-canvas-list no-bullet', ) );
			} ?>
		</aside>
		<section class="main-section">
		<?php
		// This simply opens the document and adds the off-canvas navigation.
		// We still have to close the opened elements.
		// See off-canvas-end.php