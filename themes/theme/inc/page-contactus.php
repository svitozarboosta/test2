<?php
/*
 * Template Name: Contact page
 */
get_header(); ?>

<div class="single">
    <div class="container">
        <main class="contact-wrap">
            <h1><?php the_title(); ?></h1>
            <div class="flex-row">
                <div class="col-sm-4 col-xs-12 contact-form">
                    <?php the_post(); the_content(); ?>
                </div>
                <div class="col-sm-8 col-xs-12 contact-form">
                    <form class="form-horizontal" id="contact_form" data-form="ajax">
                        <div class="form-group">
                                <span class="input input--animate">
                                    <input class="input__field input__field--animate" name="name" type="text" id="input-1">
                                    <label class="input__label input__label--animate" for="input-1">
                                        <span class="input__label-content input__label-content--animate" data-content="Name">Name</span>
                                </label>
                                </span>
                        </div>


                        <div class="form-group">
                                <span class="input input--animate">
                                    <input class="input__field input__field--animate" name="email" type="text" id="input-2">
                                    <label class="input__label input__label--animate" for="input-2">
                                        <span class="input__label-content input__label-content--animate" data-content="E-mail">E-mail</span>
                                </label>
                                </span>
                        </div>


                        <div class="form-group">
                                <span class="input input--animate">
                                    <input class="input__field input__field--animate" type="text" name="subject" id="input-3">
                                    <label class="input__label input__label--animate" for="input-3">
                                        <span class="input__label-content input__label-content--animate" data-content="Subject">Subject</span>
                                </label>
                                </span>
                        </div>


                        <div class="form-group">
                                <span class="input input--animate">
                                    <textarea id="input-4" class="input__field input__field--animate" rows="10" cols="45" name="message"></textarea>
					                <label class="input__label input__label--animate" for="input-4">
						                <span class="input__label-content input__label-content--animate" data-content="Message">Message</span>
                                </label>
                                </span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn" value="Submit">
                        </div>
                        <input type="hidden" name="action" value="contact_form">
                        <input type="hidden" name="_wpnonce" value="<?= wp_create_nonce('contact_form')?>">
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?>
