<?php
/*
 * Template Name: Checker page
 */
get_header(); ?>
<div class="single">
    <div class="container">
        <main>
            <div class="single__title"><?php the_title(); ?></div>
            <?php the_post(); the_content(); ?>
            <form id="checkerForm">
                <textarea name="text" id="checkerArea" placeholder="Paste you text here (max 2000 words)"></textarea>
                <input type="submit" id="checkerSubmit">
                <input type="hidden" value="plagiarism_check" name="action">
                <div id="checkerResult"></div>
            </form>
            <hr>
            Links:
            <br>
            First:
            <a href="https://essays.businessays.net/?utm_source=businessays.net&utm_campaign=checker-page&utm_medium=R&utm_term=1-need_original_text&utm_content=standart" class="plagiarism_cta original_text">
                I need 100% original text
            </a>
            <br>
            Second:
            <a href="https://essays.businessays.net/?utm_source=businessays.net&utm_campaign=checker-page&utm_medium=R&utm_term=2-need_plagiarism-free_content&utm_content=standart" class="plagiarism_cta free_content">
                I need Plagiarism-free content
            </a>
        </main>
    </div>
</div>
<?php do_action('checker_popup'); // Show plagiarism checker popup form Hooks.class.php ?>
<?php get_footer(); ?>