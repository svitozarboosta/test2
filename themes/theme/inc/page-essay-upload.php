<?php
/*
 * Template Name: Upload page
 */
session_start();
get_header(); ?>

    <div class="single">
        <div class="container">
            <main>
                <h1 class="single__title">STUDENT ESSAY UPLOAD FORM</h1>
                <div class="upload-form-wrap">
                    <form action="/wp-admin/admin-ajax.php" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                        <div class="upload-form">
                            <div class="upload-form__title"><strong>YOUR DEATAILS:</strong></div>
                            <p>
                                <label>Name:
                                    <br>
                                    <input type="text" name="name" required="" aria-required="true">
                                </label>
                            </p>
                            <p>
                                <label>E-mail address:
                                    <br>
                                    <input type="email" name="email" required="" aria-required="true">
                                </label>
                            </p>
                        </div>
                        <div class="upload-form">
                            <div class="upload-form__title"><strong>DETAILS:</strong></div>
                            <p>
                                <label>Essay Description
                                    <br>
                                    <textarea name="message" cols="30" rows="10"></textarea>
                                </label>
                            </p>
                            <p>
                                <label for="files">Attach your Essay (doc, docx):</label>
                                <br>
                                <input type="file" name="files">
                            </p>
                            <p>
                                <input id="upload-btn" type="submit" value="Send">
                            </p>
                        </div>
                        <input type="hidden" name="action" value="upload_form">
                        <input type="hidden" name="_wpnonce" value="<?= wp_create_nonce('upload_form')?>">
                        <?php \theme\Alert::show(); ?>
                    </form>
                </div>
            </main>
        </div>
    </div>

<?php get_footer(); ?>