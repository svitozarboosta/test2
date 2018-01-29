<?php
/**
 * cleanblog Theme Customizer
 *
 * Please browse readme.txt for credits and forking information
 *
 * @package cleanblog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanblog_customize_register( $wp_customize ) {

	//get the current color value for accent color
	$color_scheme = cleanblog_get_color_scheme();
	//get the default color for current color scheme
	$current_color_scheme = cleanblog_current_color_scheme_default_color();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_section('header_image')->title = __( 'Front Page Header', 'cleanblog' );
	$wp_customize->get_section('colors')->title = __( 'Background Color', 'cleanblog' );

	//Header Background Color setting
	$wp_customize->add_setting( 'header_bg_color', array(
		'default'           => '#1b1b1b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label'       => __( 'Header Background Color', 'cleanblog' ),
		'description' => __( 'Applied to header background.', 'cleanblog' ),
		'section'     => 'header_image',
		'settings'    => 'header_bg_color',
		) ) );

	$wp_customize->add_section( 'site_identity' , array(
		'priority'   => 3,
		));

	$wp_customize->add_section( 'header_image' , array(
		'title'      => __('Front Page Header', 'cleanblog'),
		'priority'   => 4,
		));
	$wp_customize->add_control( 'display_header_text', array(
		'label'    => __( "Display Header text?", 'cleanblog' ),
		'section'  => 'header_layout',
		'type'     => 'text',
		'priority' => 1,
		) );
	$wp_customize->add_setting( 'header_image_text_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_text_color', array(
		'label'       => __( 'Header Image Headline Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the header image headline.', 'cleanblog' ),
		'priority' 			=> 2,
		'section'     => 'header_image',
		'settings'    => 'header_image_text_color',
		) ) );

	$wp_customize->add_setting( 'header_image_tagline_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_tagline_color', array(
		'label'       => __( 'Header Image Tagline Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the header tagline headline.', 'cleanblog' ),
		'section'     => 'header_image',
		'priority'   => 2,
		'settings'    => 'header_image_tagline_color',
		) ) );


	$wp_customize->add_setting( 'hero_image_title', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post',
		'capability'        => 'edit_theme_options',
		'default'  => '',
		) );

	$wp_customize->add_control( 'hero_image_title', array(
		'label'    => __( "Header Image Title", 'cleanblog' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'priority' => 1,
		) );

	$wp_customize->add_setting( 'hero_image_subtitle', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		'default'  => '',
		) );
$wp_customize->add_control( 'header_textcolor', array(
		'section'  => 'color_settings',
		) );
	$wp_customize->add_control( 'hero_image_subtitle', array(
		'label'    => __( "Header Image Tagline", 'cleanblog' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'priority' => 1,
		) );

    $wp_customize->add_setting( 'header_btn_one_text', array(
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
        ) );

    $wp_customize->add_control( 'header_btn_one_text', array(
        'label'    => __( "Button 1 (Left) Text", 'cleanblog' ),
        'section'  => 'header_image',
        'type'     => 'text',
        'priority' => 1,
        ) );
    $wp_customize->add_setting( 'header_btn_one_link', array(
        'type'              => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'capability'        => 'edit_theme_options',
        ) );

    $wp_customize->add_control( 'header_btn_one_link', array(
        'label'    => __( "Button 1 (Left) Link", 'cleanblog' ),
        'section'  => 'header_image',
        'type'     => 'text',
        'priority' => 1,
        ) );
    $wp_customize->add_setting( 'header_btn_one_background_color', array(
        'default'           => '#fff', 
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage'
        ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_btn_one_background_color', array(
        'label'       => __( 'Button 1 (Left) Border Color', 'cleanblog' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_btn_one_background_color',
        ) ) );
    $wp_customize->add_setting( 'header_btn_one_text_color', array(
        'default'           => '#fff', 
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage'
        ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_btn_one_text_color', array(
        'label'       => __( 'Button 1 (Left) Text Color', 'cleanblog' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_btn_one_text_color',
        ) ) );



    $wp_customize->add_setting( 'header_btn_two_text', array(
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
        ) );

    $wp_customize->add_control( 'header_btn_two_text', array(
        'label'    => __( "Button 2 (Right) Text", 'cleanblog' ),
        'section'  => 'header_image',
        'type'     => 'text',
        'priority' => 1,
        ) );
    $wp_customize->add_setting( 'header_btn_two_link', array(
        'type'              => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'capability'        => 'edit_theme_options',
        ) );

    $wp_customize->add_control( 'header_btn_two_link', array(
        'label'    => __( "Button 2 (Right) Link", 'cleanblog' ),
        'section'  => 'header_image',
        'type'     => 'text',
        'priority' => 1,
        ) );
    $wp_customize->add_setting( 'header_btn_two_background_color', array(
        'default'           => '#fff', 
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage'
        ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_btn_two_background_color', array(
        'label'       => __( 'Button 2 (Right) Background Color', 'cleanblog' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_btn_two_background_color',
        ) ) );
    $wp_customize->add_setting( 'header_btn_two_text_color', array(
        'default'           => '#636363', 
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage'
        ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_btn_two_text_color', array(
        'label'       => __( 'Button 2 (Right) Text Color', 'cleanblog' ),
        'section'     => 'header_image',
        'priority' => 1,
        'settings'    => 'header_btn_two_text_color',
        ) ) );




// Footer Section
	$wp_customize->add_section(
		'footer_options',
		array(
			'title'     => __('Footer','cleanblog'),
			'priority'  => 99
			)
		);

	$wp_customize->add_setting( 'footer_copyright_content', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		) );

	$wp_customize->add_control( 'footer_copyright_content', array(
		'label'    => __( "Footer Copyright Text", 'cleanblog' ),
		'description' => __( 'Replaces the copyright text in the footer.', 'cleanblog' ),
		'section'  => 'footer_options',
		'type'     => 'text',
		'priority' => 1,
		) );

	$wp_customize->add_setting( 'footer_colors', array(
		'default'           => '#212324',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_colors', array(
		'label'       => __( 'Footer Widget Background', 'cleanblog' ),
		'description' => __( 'Choose a background color for the footer widget section.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_colors',
		) ) );

	$wp_customize->add_setting( 'footer_widget_title_colors', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_title_colors', array(
		'label'       => __( 'Footer Widget Headline Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the footer widget headlines.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_widget_title_colors',
		) ) );


	$wp_customize->add_setting( 'footer_widget_text_colors', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_text_colors', array(
		'label'       => __( 'Footer Widget Text Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the footer widget text.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_widget_text_colors',
		) ) );

	$wp_customize->add_setting( 'footer_widget_link_colors', array(
		'default'           => '#7f7f7f',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_widget_link_colors', array(
		'label'       => __( 'Footer Widget Link Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the footer widget links.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_widget_link_colors',
		) ) );

	$wp_customize->add_setting( 'footer_copyright_background_color', array(
		'default'           => '#212324',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_setting( 'footer_copyright_text_color', array(
		'default'           => '#7f7f7f',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_text_color', array(
		'label'       => __( 'Footer Copyright Text Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the footer copyright section text.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_copyright_text_color',
		) ) );

	$wp_customize->add_setting( 'footer_copyright_border_color', array(
		'default'           => '#3f4042',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_border_color', array(
		'label'       => __( 'Footer Copyright Border Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the border above the copyright section.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_copyright_border_color',
		) ) );


	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_background_color', array(
		'label'       => __( 'Footer Copyright Background Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the footer copyright section background.', 'cleanblog' ),
		'section'     => 'footer_options',
		'settings'    => 'footer_copyright_background_color',
		) ) );

	$wp_customize->add_setting( 'footer_widget_text_color', array(
		'default'           => '#dedede',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );



// Blog Feed
	$wp_customize->add_section(
		'blog_feed',
		array(
			'title'     => __('Blog Feed','cleanblog'),
			'description' => __( 'Please go to a page where you can see all blog posts, to view the changes.', 'cleanblog' ),
			'priority'  => 5
			)
		);

	$wp_customize->add_setting( 'post_feed_post_background', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_background', array(
		'label'       => __( 'Posts Background Color', 'cleanblog' ),
		'description' => __( 'Choose a background color for the posts.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_background',
		) ) );

	$wp_customize->add_setting( 'post_feed_post_text', array(
		'default'           => '#949494',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_text', array(
		'label'       => __( 'Posts Text Color', 'cleanblog' ),
		'description' => __( 'Choose a text color for the posts.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_text',
		) ) );
	$wp_customize->add_setting( 'post_feed_post_headline', array(
		'default'           => '#4a4849',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_headline', array(
		'label'       => __( 'Posts Headline Color', 'cleanblog' ),
		'description' => __( 'Choose a headline color for the posts.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_headline',
		) ) );


	$wp_customize->add_setting( 'post_feed_post_date_noimage', array(
		'default'           => '#afafaf',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_date_noimage', array(
		'label'       => __( 'Posts Date Color', 'cleanblog' ),
		'description' => __( 'Choose a date color for the posts without a featured image.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_date_noimage',
		) ) );


	$wp_customize->add_setting( 'post_feed_post_button_bg', array(
		'default'           => '#4dbf99',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_button_bg', array(
		'label'       => __( 'Posts Read More Button Background Color', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_button_bg',
		) ) );
	$wp_customize->add_setting( 'post_feed_post_button_readmore_text', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_button_readmore_text', array(
		'label'       => __( 'Posts Read More Button Text Color', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_button_readmore_text',
		) ) );

	$wp_customize->add_setting( 'post_feed_post_button_text', array(
		'default'           => '#4dbf99',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_button_text', array(
		'label'       => __( 'Next/Prev Page Buttons Text Color', 'cleanblog' ),
		'description' => __( 'Choose a text color for the next/previous page buttons.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_button_text',
		) ) );


	$wp_customize->add_setting( 'post_feed_post_button', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_feed_post_button', array(
		'label'       => __( 'Next/Prev Page Buttons Background Color', 'cleanblog' ),
		'description' => __( 'Choose a background color for the next/previous page buttons.', 'cleanblog' ),
		'section'     => 'blog_feed',
		'settings'    => 'post_feed_post_button',
		) ) );

// Post and page Section
	$wp_customize->add_section(
		'post_page_options',
		array(
			'title'     => __('Post & Page','cleanblog'),
			'description' => __( 'Please go to a blog post or a page to view the changes.', 'cleanblog' ),
			'priority'  => 6
			)
		);


	$wp_customize->add_setting( 'author_line_color', array(
		'default'           => '#8c8c8c',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'author_line_color', array(
		'label'       => __( 'Author Byline Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the author byline in the top of posts and pages.', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'author_line_color',
		) ) );

	$wp_customize->add_setting( 'headline_color', array(
		'default'           => '#2f2f2f',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headline_color', array(
		'label'       => __( 'Post & Page Headline Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the post & page headline.', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'headline_color',
		) ) );
	$wp_customize->add_setting( 'post_content_color', array(
		'default'           => '#424242',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_content_color', array(
		'label'       => __( 'Post & Page Paragraph Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the post & page paragraphs.', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_content_color',
		) ) );

	$wp_customize->add_setting( 'post_link_color', array(
		'default'           => '#4dbf99',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_link_color', array(
		'label'       => __( 'Post & Page Link Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the post & page text links.', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_link_color',
		) ) );

		$wp_customize->add_setting( 'post_tags_categories_bg', array(
		'default'           => '#efefef',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_tags_categories_bg', array(
		'label'       => __( 'Post Category & Tags Text Color', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_tags_categories_bg',
		) ) );

		$wp_customize->add_setting( 'post_tags_categories_text', array(
		'default'           => '#757575',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_tags_categories_text', array(
		'label'       => __( 'Post Category & Tags Background Color', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_tags_categories_text',
		) ) );



	$wp_customize->add_setting( 'post_background_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_background_color', array(
		'label'       => __( 'Post & Page Background Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the post & page background.', 'cleanblog' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_background_color',
		) ) );




// Sidebar Section
	$wp_customize->add_section(
		'sidebar_options',
		array(
			'title'     => __('Sidebar','cleanblog'),
			'description' => __( 'Please go to a page or post to view the sidebar.', 'cleanblog' ),
			'priority'  => 7
			)
		);

	$wp_customize->add_setting( 'sidebar_background_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_background_color', array(
		'label'       => __( 'Sidebar Background Color', 'cleanblog' ),
		'description' => __( 'Choose the color of the sidebar background', 'cleanblog' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_background_color',
		) ) );

	$wp_customize->add_setting( 'sidebar_headline_colors', array(
		'default'           => '#212121',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_headline_colors', array(
		'label'       => __( 'Sidebar Headline Color', 'cleanblog' ),
		'description' => __( 'Choose the color of the sidebar titles and headlines', 'cleanblog' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_headline_colors',
		) ) );
	$wp_customize->add_setting( 'sidebar_link_color', array(
		'default'           => '#6b6b6b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_link_color', array(
		'label'       => __( 'Sidebar Link Color', 'cleanblog' ),
		'description' => __( 'Choose the color of the sidebar links', 'cleanblog' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_link_color',
		) ) );
	$wp_customize->add_setting( 'sidebar_text_color', array(
		'default'           => '#424242',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_text_color', array(
		'label'       => __( 'Sidebar Text Color', 'cleanblog' ),
		'description' => __( 'Choose the color of the sidebar text', 'cleanblog' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_text_color',
		) ) );



// Navigation Section
	$wp_customize->add_section(
		'navigation_options',
		array(
			'title'     => __('Navigation','cleanblog'),
			'priority'  => 3
			)
		);

	$wp_customize->add_setting( 'navigation_background_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navigation_background_color', array(
		'label'       => __( 'Navigation Background Color', 'cleanblog' ),
		'description' => __( 'Please go to a sub page to view the navigation.', 'cleanblog' ),
		'section'     => 'navigation_options',
		'settings'    => 'navigation_background_color',
		) ) );

	$wp_customize->add_setting( 'navigation_text_color', array(
		'default'           => '#333',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navigation_text_color', array(
		'label'       => __( 'Subpage Navigation Link Color', 'cleanblog' ),
		'description' => __( 'Please go to a sub page to view the navigation.', 'cleanblog' ),
		'section'     => 'navigation_options',
		'settings'    => 'navigation_text_color',
		'priority'  => 3,
		) ) );

	$wp_customize->add_setting( 'navigation_logo_color', array(
		'default'           => '#333',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navigation_logo_color', array(
		'label'       => __( 'Subpage Logo Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the logo text on subpages.', 'cleanblog' ),
		'section'     => 'navigation_options',
		'settings'    => 'navigation_logo_color',
		'priority'  => 3,
		) ) );

	$wp_customize->add_setting( 'navigation_frontpage_logo_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navigation_frontpage_logo_color', array(
		'label'       => __( 'Front Page Logo Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the logo text on the front page header.', 'cleanblog' ),
		'section'     => 'navigation_options',
		'settings'    => 'navigation_frontpage_logo_color',
		'priority'  => 1,
		) ) );

	$wp_customize->add_setting( 'navigation_frontpage_menu_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navigation_frontpage_menu_color', array(
		'label'       => __( 'Front Page Navigation Link Color', 'cleanblog' ),
		'description' => __( 'Choose a color for the links in the navigation on the front page header.', 'cleanblog' ),
		'section'     => 'navigation_options',
		'priority'  => 1,
		'settings'    => 'navigation_frontpage_menu_color',
		) ) );

	//Navigation section end
	$wp_customize->add_section(
		'accent_color_option',
		array(
			'title'     => __('Theme Color','cleanblog'),
			'priority'  => 2
			)
		);

	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'cleanblog_sanitize_color_scheme',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Predefined Colors', 'cleanblog' ),
		'section'  => 'accent_color_option',
		'type'     => 'select',
		'choices'  => cleanblog_get_color_scheme_choices(),
		'priority' => 3,
		) );

	// Add custom accent color.
	$wp_customize->add_setting( 'accent_color', array(
		'default'           => $current_color_scheme[0],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label'       => __( 'Theme Color', 'cleanblog' ),
		'description' => __( 'Applied to highlight elements, buttons and much more.', 'cleanblog' ),
		'section'     => 'accent_color_option',
		'settings'    => 'accent_color',
		) ) );

	//Add section for post option
	$wp_customize->add_section(
		'post_options',
		array(
			'title'     => __('Post Options','cleanblog'),
			'priority'  => 300
			)
		);

	$wp_customize->add_setting('post_display_option', array(
		'default'        => 'post-excerpt',
		'sanitize_callback' => 'cleanblog_sanitize_post_display_option',
		'transport'         => 'refresh'
		));

	$wp_customize->add_control('post_display_types', array(
		'label'      => __('How would you like to dipaly a post on post listing page?', 'cleanblog'),
		'section'    => 'post_options',
		'settings'   => 'post_display_option',
		'type'       => 'radio',
		'choices'    => array(
			'post-excerpt' => __('Post excerpt','cleanblog'),
			'full-post' => __('Full post','cleanblog'),            
			),
		));
}
add_action( 'customize_register', 'cleanblog_customize_register' );

/**
 * Register color schemes for cleanblog.
 *
 * @return array An associative array of color scheme options.
 */
function cleanblog_get_color_schemes() {
	return apply_filters( 'cleanblog_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'cleanblog' ),
			'colors' => array(
				'#4dbf99',			
				),
			),
		'pink'    => array(
			'label'  => __( 'Pink', 'cleanblog' ),
			'colors' => array(
				'#FF4081',				
				),
			),
		'orange'  => array(
			'label'  => __( 'Orange', 'cleanblog' ),
			'colors' => array(
				'#FF5722',
				),
			),
		'green'    => array(
			'label'  => __( 'Green', 'cleanblog' ),
			'colors' => array(
				'#8BC34A',
				),
			),
		'red'    => array(
			'label'  => __( 'Red', 'cleanblog' ),
			'colors' => array(
				'#FF5252',
				),
			),
		'yellow'    => array(
			'label'  => __( 'yellow', 'cleanblog' ),
			'colors' => array(
				'#FFC107',
				),
			),
		'blue'   => array(
			'label'  => __( 'Blue', 'cleanblog' ),
			'colors' => array(
				'#03A9F4',
				),
			),
		) );
}

if(!function_exists('cleanblog_current_color_scheme_default_color')):
/**
 * Get the default hex color value for current color scheme
 *
 *
 * @return array An associative array of current color scheme hex values.
 */
function cleanblog_current_color_scheme_default_color(){
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	
	$color_schemes       = cleanblog_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; //cleanblog_current_color_scheme_default_color

if ( ! function_exists( 'cleanblog_get_color_scheme' ) ) :
/**
 * Get the current cleanblog color scheme.
 *
 *
 * @return array An associative array of currently set color hex values.
 */
function cleanblog_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$accent_color = get_theme_mod('accent_color','#4dbf99');
	$color_schemes       = cleanblog_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		$color_schemes[ $color_scheme_option ]['colors'] = array($accent_color);
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; // cleanblog_get_color_scheme

if ( ! function_exists( 'cleanblog_get_color_scheme_choices' ) ) :
/**
 * Returns an array of color scheme choices registered for cleanblog.
 *
 *
 * @return array Array of color schemes.
 */
function cleanblog_get_color_scheme_choices() {
	$color_schemes                = cleanblog_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // cleanblog_get_color_scheme_choices

if ( ! function_exists( 'cleanblog_sanitize_color_scheme' ) ) :
/**
 * Sanitization callback for color schemes.
 *
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function cleanblog_sanitize_color_scheme( $value ) {
	$color_schemes = cleanblog_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}
endif; // cleanblog_sanitize_color_scheme
add_action( 'wp_print_scripts', 'cleanblog_header_bg_color_css' );
if ( ! function_exists( 'cleanblog_sanitize_post_display_option' ) ) :
/**
 * Sanitization callback for post display option.
 *
 *
 * @param string $value post display style.
 * @return string post display style.
 */

function cleanblog_sanitize_post_display_option( $value ) {
	if ( ! in_array( $value, array( 'post-excerpt', 'full-post' ) ) )
		$value = 'post-excerpt';

	return $value;
}
endif; // cleanblog_sanitize_post_display_option
/**
 * Enqueues front-end CSS for color scheme.
 *
 *
 * @see wp_add_inline_style()
 */
function cleanblog_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	
	$color_scheme = cleanblog_get_color_scheme();

	$color = array(
		'accent_color'            => $color_scheme[0],
		);

	$color_scheme_css = cleanblog_get_color_scheme_css( $color);

	wp_add_inline_style( 'cleanblog-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'cleanblog_color_scheme_css' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function cleanblog_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'accent_color'            => '',
		) );

	$css = <<<CSS
	/* Color Scheme */

	/* Accent Color */
	a,a:visited,a:active,a:hover,a:focus,#secondary .widget #recentcomments a, #secondary .widget .rsswidget {
		color: {$colors['accent_color']};
	}

	@media (min-width:767px) {
		.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {	    
			background-color: {$colors['accent_color']} !important;
			color:#fff !important;
		}
		.dropdown-menu .current-menu-item.current_page_item a, .dropdown-menu .current-menu-item.current_page_item a:hover, .dropdown-menu .current-menu-item.current_page_item a:active, .dropdown-menu .current-menu-item.current_page_item a:focus {
			background: {$colors['accent_color']} !important;
			color:#fff !important
		}
	}
	@media (max-width:767px) {
		.dropdown-menu .current-menu-item.current_page_item a, .dropdown-menu .current-menu-item.current_page_item a:hover, .dropdown-menu .current-menu-item.current_page_item a:active, .dropdown-menu .current-menu-item.current_page_item a:focus, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li.active > a {
			border-left: 3px solid {$colors['accent_color']};
		}
	}
	.btn, .btn-default:visited, .btn-default:active:hover, .btn-default.active:hover, .btn-default:active:focus, .btn-default.active:focus, .btn-default:active.focus, .btn-default.active.focus {
		background: {$colors['accent_color']};
	}
	.cat-links a, .tags-links a {
		color: {$colors['accent_color']};
	}
	.navbar-default .navbar-nav > li > .dropdown-menu > li > a:hover, .navbar-default .navbar-nav > li > .dropdown-menu > li > a:focus {
		color: #fff;
		background-color: {$colors['accent_color']};
	}
	h5.entry-date a:hover {
		color: {$colors['accent_color']};
	}
	#respond input#submit {
		background-color: {$colors['accent_color']};
		background: {$colors['accent_color']};
	}
	blockquote {
		border-left: 5px solid {$colors['accent_color']};
	}
	.entry-title a:hover,.entry-title a:focus{
		color: {$colors['accent_color']};
	}
	.entry-header .entry-meta::after{
		background: {$colors['accent_color']};
	}
	.readmore-btn, .readmore-btn:visited, .readmore-btn:active, .readmore-btn:hover, .readmore-btn:focus {
		background: {$colors['accent_color']};
	}
	.post-password-form input[type="submit"],.post-password-form input[type="submit"]:hover,.post-password-form input[type="submit"]:focus,.post-password-form input[type="submit"]:active,.search-submit,.search-submit:hover,.search-submit:focus,.search-submit:active {
		background-color: {$colors['accent_color']};
		background: {$colors['accent_color']};
		border-color: {$colors['accent_color']};
	}
	.fa {
		color: {$colors['accent_color']};
	}
	.btn-default{
		border-bottom: 1px solid {$colors['accent_color']};
	}

	.nav-previous:hover, .nav-next:hover{
		border: 1px solid {$colors['accent_color']};
		background-color: {$colors['accent_color']};
	}
	.next-post a:hover,.prev-post a:hover{
		color: {$colors['accent_color']};
	}
	.posts-navigation .next-post a:hover .fa, .posts-navigation .prev-post a:hover .fa{
		color: {$colors['accent_color']};
	}
	#secondary .widget a:hover,	#secondary .widget a:focus{
		color: {$colors['accent_color']};
	}
	#secondary .widget_calendar tbody a {
		background-color: {$colors['accent_color']};
		color: #fff;
		padding: 0.2em;
	}
	#secondary .widget_calendar tbody a:hover{
		background-color: {$colors['accent_color']};
		color: #fff;
		padding: 0.2em;
	}	
CSS;

return $css;
}

if(! function_exists('cleanblog_header_bg_color_css' ) ):
/**
* Set the header background color 
*/
function cleanblog_header_bg_color_css(){

	?>

	<style type="text/css">
		.site-header { background: <?php echo esc_attr(get_theme_mod( 'header_bg_color')); ?>; }
		.footer-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_title_colors')); ?>; }
		.site-footer { background: <?php echo esc_attr(get_theme_mod( 'footer_copyright_background_color')); ?>; }
		.footer-widget-wrapper { background: <?php echo esc_attr(get_theme_mod( 'footer_colors')); ?>; }
		.copy-right-section { color: <?php echo esc_attr(get_theme_mod( 'footer_copyright_text_color')); ?>; }
		#secondary h3.widget-title, #secondary h4.widget-title { color: <?php echo esc_attr(get_theme_mod( 'sidebar_headline_colors')); ?>; }
		.secondary-inner { background: <?php echo esc_attr(get_theme_mod( 'sidebar_background_color')); ?>; }
		#secondary .widget a, #secondary .widget a:focus, #secondary .widget a:hover, #secondary .widget a:active, #secondary .widget #recentcomments a, #secondary .widget #recentcomments a:focus, #secondary .widget #recentcomments a:hover, #secondary .widget #recentcomments a:active, #secondary .widget .rsswidget, #secondary .widget .rsswidget:focus, #secondary .widget .rsswidget:hover, #secondary .widget .rsswidget:active { color: <?php echo esc_attr(get_theme_mod( 'sidebar_link_color')); ?>; }
		.navbar-default,.navbar-default li>.dropdown-menu, .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dr { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?>; }
		.home .lh-nav-bg-transform li>.dropdown-menu:after { border-bottom-color: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?>; }
		.navbar-default .navbar-nav>li>a, .navbar-default li>.dropdown-menu>li>a, .navbar-default .navbar-nav>li>a:hover, .navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:active, .navbar-default .navbar-nav>li>a:visited, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus { color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		.navbar-default .navbar-brand, .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus { color: <?php echo esc_attr(get_theme_mod( 'navigation_logo_color')); ?>; }
		h1.entry-title, .entry-header .entry-title a, .page .container article h2, .page .container article h3, .page .container article h4, .page .container article h5, .page .container article h6, .single article h1, .single article h2, .single article h3, .single article h4, .single article h5, .single article h6, .page .container article h1, .single article h1, .single h2.comments-title, .single .comment-respond h3#reply-title, .page h2.comments-title, .page .comment-respond h3#reply-title { color: <?php echo esc_attr(get_theme_mod( 'headline_color')); ?>; }
		.single .entry-content, .page .entry-content, .single .entry-summary, .page .entry-summary, .page .post-feed-wrapper p, .single .post-feed-wrapper p, .single .post-comments, .page .post-comments, .single .post-comments p, .page .post-comments p, .single .next-article a p, .single .prev-article a p, .page .next-article a p, .page .prev-article a p, .single thead, .page thead { color: <?php echo esc_attr(get_theme_mod( 'post_content_color')); ?>; }
		.page .container .entry-date, .single-post .container .entry-date, .single .comment-metadata time, .page .comment-metadata time { color: <?php echo esc_attr(get_theme_mod( 'author_line_color')); ?>; }
		.top-widgets { background: <?php echo esc_attr(get_theme_mod( 'top_widget_background_color')); ?>; }
		.top-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'top_widget_title_color')); ?>; }
		.top-widgets, .top-widgets p { color: <?php echo esc_attr(get_theme_mod( 'top_widget_text_color')); ?>; }
		.bottom-widgets { background: <?php echo esc_attr(get_theme_mod( 'bottom_widget_background_color')); ?>; }
		.bottom-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'bottom_widget_title_color')); ?>; }
		.frontpage-site-title, .frontpage-site-title:hover, .frontpage-site-title:active, .frontpage-site-title:focus { color: <?php echo esc_attr(get_theme_mod( 'header_image_text_color')) ?>; }
		.frontpage-site-description, .frontpage-site-description:focus, .frontpage-site-description:hover, .frontpage-site-description:active { color: <?php echo esc_attr(get_theme_mod( 'header_image_tagline_color')) ?>; }
		.frontpage-site-description:before{ background: <?php echo esc_attr(get_theme_mod( 'header_image_tagline_color')) ?>; }
		.bottom-widgets, .bottom-widgets p { color: <?php echo esc_attr(get_theme_mod( 'bottom_widget_text_color')); ?>; }
		.footer-widgets, .footer-widgets p { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_text_color')); ?>; }
		.home .lh-nav-bg-transform .navbar-nav>li>a, .home .lh-nav-bg-transform .navbar-nav>li>a:hover, .home .lh-nav-bg-transform .navbar-nav>li>a:active, .home .lh-nav-bg-transform .navbar-nav>li>a:focus, .home .lh-nav-bg-transform .navbar-nav>li>a:visited { color: <?php echo esc_attr(get_theme_mod( 'navigation_frontpage_menu_color')); ?>; }
		.home .lh-nav-bg-transform.navbar-default .navbar-brand, .home .lh-nav-bg-transform.navbar-default .navbar-brand:hover, .home .lh-nav-bg-transform.navbar-default .navbar-brand:active, .home .lh-nav-bg-transform.navbar-default .navbar-brand:focus, .home .lh-nav-bg-transform.navbar-default .navbar-brand:hover { color: <?php echo esc_attr(get_theme_mod( 'navigation_frontpage_logo_color')); ?>; }
		body, #secondary h4.widget-title { background-color: <?php echo esc_attr(get_theme_mod( 'background_elements_color')); ?>; }
		.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus{color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		#secondary, #secondary .widget, #secondary p{color: <?php echo esc_attr(get_theme_mod( 'sidebar_text_color')); ?>; }
		.footer-widgets, .footer-widgets p{color: <?php echo esc_attr(get_theme_mod( 'footer_widget_text_colors')); ?>; }
		.footer-widgets a, .footer-widgets li a{color: <?php echo esc_attr(get_theme_mod( 'footer_widget_link_colors')); ?>; }
		.copy-right-section{border-top: 1px solid <?php echo esc_attr(get_theme_mod( 'footer_copyright_border_color')); ?>; }
		.copy-right-section{border-top: 1px solid <?php echo esc_attr(get_theme_mod( 'footer_copyright_border_color')); ?>; }
		.single .entry-content a, .page .entry-content a, .single .post-comments a, .page .post-comments a, .single .next-article a, .single .prev-article a, .page .next-article a, .page .prev-article a {color: <?php echo esc_attr(get_theme_mod( 'post_link_color')); ?>; }
		.single .post-content, .page .post-content, .single .comments-area, .page .comments-area, .single .post-comments, .page .single-post-content, .single .post-comments .comments-area, .page .post-comments .comments-area, .single .next-article a, .single .prev-article a, .page .next-article a, .page .prev-article a, .page .post-comments {background: <?php echo esc_attr(get_theme_mod( 'post_background_color')); ?>; }
		.article-grid-container article{background: <?php echo esc_attr(get_theme_mod( 'post_feed_post_background')); ?>; }
		.article-grid-container .post-feed-wrapper p{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_text')); ?>; }
		.post-feed-wrapper .entry-header .entry-title a{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_headline')); ?>; }
		.article-grid-container h5.entry-date, .article-grid-container h5.entry-date a{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_date_noimage')); ?>; }
		.article-grid-container .post-thumbnail-wrap .entry-date{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_date_withimage')); ?>; }
		.blog .next-post a, .blog .prev-post a{background: <?php echo esc_attr(get_theme_mod( 'post_feed_post_button')); ?>; }
		.blog .next-post a, .blog .prev-post a, .blog .next-post a i.fa, .blog .prev-post a i.fa, .blog .posts-navigation .next-post a:hover .fa, .blog .posts-navigation .prev-post a:hover .fa{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_button_text')); ?>; }
		.article-grid-container .post-thumbnail-wrap .entry-date{color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_date_withimage')); ?>; }
		.blog .btn {background: <?php echo esc_attr(get_theme_mod( 'post_feed_post_button_bg')); ?>; }
		.blog .btn {color: <?php echo esc_attr(get_theme_mod( 'post_feed_post_button_readmore_text')); ?>; }
		.header_btn_one_text, .header_btn_one_text:hover, .header_btn_one_text:active, .header_btn_one_text:focus {color: <?php echo esc_attr(get_theme_mod( 'header_btn_one_text_color')); ?>; }
		.header_btn_one_text, .header_btn_one_text:hover, .header_btn_one_text:active, .header_btn_one_text:focus {border-color: <?php echo esc_attr(get_theme_mod( 'header_btn_one_background_color')); ?>; }
		.header_btn_two_text, .header_btn_two_text:hover, .header_btn_two_text:active, .header_btn_two_text:focus {background: <?php echo esc_attr(get_theme_mod( 'header_btn_two_background_color')); ?>; }
		.header_btn_two_text, .header_btn_two_text:hover, .header_btn_two_text:active, .header_btn_two_text:focus {color: <?php echo esc_attr(get_theme_mod( 'header_btn_two_text_color')); ?>; }
		.tags-section a, .tags-section a:visited, .tags-section a:hover, .tags-section a:active, .tags-section a:focus, .post-categories li a, .post-categories li a:visited, .post-categories li a:hover, .post-categories li a:focus, .post-categories li a:active {color: <?php echo esc_attr(get_theme_mod( 'post_tags_categories_text')); ?>; }
		.tags-section a, .tags-section a:visited, .tags-section a:hover, .tags-section a:active, .tags-section a:focus, .post-categories li a, .post-categories li a:visited, .post-categories li a:hover, .post-categories li a:focus, .post-categories li a:active {background: <?php echo esc_attr(get_theme_mod( 'post_tags_categories_bg')); ?>; }
		@media (max-width:767px){	
		.home .lh-nav-bg-transform { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?> !important; }
		.navbar-default .navbar-nav .open .dropdown-menu>li>a, .navbar-default .navbar-nav .open .dropdown-menu>li>a, .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu>li>a,:focus, .navbar-default .navbar-nav .open .dropdown-menu>li>a,:visited, .home .lh-nav-bg-transform .navbar-nav>li>a, .home .lh-nav-bg-transform .navbar-nav>li>a:hover, .home .lh-nav-bg-transform .navbar-nav>li>a:visited, .home .lh-nav-bg-transform .navbar-nav>li>a:focus, .home .lh-nav-bg-transform .navbar-nav>li>a:active, .navbar-default .navbar-nav .open .dropdown-menu>li>a:active, .navbar-default .navbar-nav .open .dropdown-menu>li>a:focus, .navbar-default .navbar-nav .open .dropdown-menu>li>a:hover, .navbar-default .navbar-nav .open .dropdown-menu>li>a:visited, .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:active, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover {color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		.home .lh-nav-bg-transform.navbar-default .navbar-brand, .home .lh-nav-bg-transform.navbar-default .navbar-brand:hover, .home .lh-nav-bg-transform.navbar-default .navbar-brand:focus, .home .lh-nav-bg-transform.navbar-default .navbar-brand:active { color: <?php echo esc_attr(get_theme_mod( 'navigation_logo_color')); ?>; }
		.navbar-default .navbar-toggle .icon-bar, .navbar-default .navbar-toggle:focus .icon-bar, .navbar-default .navbar-toggle:hover .icon-bar{ background-color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		.navbar-default .navbar-nav .open .dropdown-menu > li > a {border-left-color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		}
	</style>
	<?php }
	endif;



/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 */
function cleanblog_customize_control_js() {
	wp_enqueue_script( 'cleanblog-color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20141216', true );
	wp_localize_script( 'cleanblog-color-scheme-control', 'colorScheme', cleanblog_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'cleanblog_customize_control_js' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cleanblog_customize_preview_js() {
	wp_enqueue_script( 'cleanblog_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'cleanblog_customize_preview_js' );

/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 *
 */
function cleanblog_color_scheme_css_template() {
	$colors = array(
		'accent_color'            => '{{ data.accent_color }}',
		);
	?>
	<script type="text/html" id="tmpl-cleanblog-color-scheme">
		<?php echo cleanblog_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'cleanblog_color_scheme_css_template' );
