<?php get_header();
    get_template_part('inc/parts/home/home', 'head');           // Include head section for home page
    get_template_part('inc/parts/home/home', 'categories');     // Include categories section with container
    get_template_part('inc/parts/home/home', 'services');       // Include services section
    get_template_part('inc/parts/home/home', 'slider');         // Include slider section with container
    get_template_part('inc/parts/home/home', 'essays');         // Include home essays loop
    get_template_part('inc/parts/home/home', 'steps');          // Include home steps block
get_footer();