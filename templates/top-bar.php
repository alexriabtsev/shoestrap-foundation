<?php

global $ss_framework, $ss_settings;

echo '<div class="navbar ' . apply_filters( 'shoestrap_navbar_class', '' ) . '">';
	echo '<nav class="top-bar" data-topbar data-options="mobile_show_parent_link: true">';

		echo '<ul class="title-area">';

			if ( ! is_null( $ss_settings['nav_brand'] ) && $ss_settings['nav_brand'] == 1 ) {
				echo '<li class="name">';
					echo '<h1>' . apply_filters( 'shoestrap_navbar_brand', '<a class="text" href="' . home_url('/') . '">' . get_bloginfo( 'name' ) . '</a>' ) . '</h1>';
				echo '</li>';
			}

			echo apply_filters( 'shoestrap_nav_toggler', '<li class="toggle-topbar menu-icon"><a href="#">' . __( 'Menu', 'shoestrap' ) . '</a></li>' );

		echo '</ul>';

		if ( has_action( 'shoestrap_pre_main_nav' ) ) {

			echo '<div class="nav-extras">';
				do_action( 'shoestrap_pre_main_nav' );
			echo '</div>';

		}

		echo '<section class="top-bar-section">';

		do_action( 'shoestrap_inside_nav_begin' );

		if ( has_nav_menu( 'primary_navigation' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'menu_class' => apply_filters( 'shoestrap_nav_class', 'left' ) ) );
		}

		do_action( 'shoestrap_inside_nav_end' );

		echo '</section>';

		do_action( 'shoestrap_post_main_nav' );

	echo '</nav>';
echo '</div>';