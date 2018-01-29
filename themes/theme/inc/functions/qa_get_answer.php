<?php
function qaAskAnything() {
    global $current_user;
    ?>
    <!-- begin sidebar-ask  -->
    <div class="sidebar-ask">
        <h3 class="aside__header">
            <span>Ask</span>
            <span>us</span>
            <span>anything</span>
        </h3>


        <form id="getAnswer">
            <textarea class="question"></textarea>
            <input type="hidden" class="emailForAnswer" value="<?php if (is_user_logged_in() && pmpro_getMembershipLevelForUser()) echo $current_user->user_email ?>">
            <a href="<?php echo home_url() ?>/account/levels/">Get Answer</a>
            <a href="#goToAccount" style="display: none;" class="go"></a>
            <div class="ask-error"></div>
        </form>
    </div>

    <div id="goToAccount" class="new-modal pmpro_form modal-goToAccount">
        <div class="membership__price-title">
            You have selected the <strong>Fruitful weekend</strong> level.
        </div>
        <button class="pmpro_submit__register--btn">Register account</button>
    </div>
    <!-- end sidebar-ask -->
    <?php
    doGetAnswer();
}

function doGetAnswer() {
    add_action('wp_footer', function() {

        if (is_single() && in_category('qa')) :?>

            <script>
                jQuery(document).ready(function ($) {

                    $('#getAnswer').on('click', 'a',function (e) {
                        e.preventDefault();
                        email = $(this).parent().find('.emailForAnswer').val();
                        title = $('#getAnswer').find('.question').val();
                        console.log(title );
                        if (email === '') {

                        } else {
                            ajaxurl = '/wp-admin/admin-ajax.php';
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: 'getAnswer',
                                    title: title,
                                    email: email
                                },
                                success: function(result) {
                                    if (result.success) {
                                    }
                                },
                                error:  function(xhr, str){
                                    alert('Error: ' + xhr.responseCode);
                                }
                            });
                        }
                    });
                });
            </script>
            <?php
        endif;

    });
}

add_action('wp_ajax_getAnswer', 'getAnswerF');
add_action('wp_ajax_nopriv_getAnswer', 'getAnswerF');

function getAnswerF() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $title = $_POST['title'];

        $res = addQuestionToWp($email, $title);

        if ($res) {
            if(wp_mail(Cfg::getConfig('email_user'), $data['subject'], $message, '', $files)) empty($files) ? wp_send_json_success(__('Thank you for email', 'theme')) : wp_redirect('/essay-upload/?success');
            else wp_send_json_error(__('Send email failed', 'theme'));
            wp_send_json(['success'=>true]);
        } else {
            wp_send_json(['success'=>false]);
        }
    }
}

function addQuestionToWp($email, $title) {
    $cat = get_category_by_slug('qa-category');
    if (!$cat) {
        $catid = wp_create_category('qa-category');
        $cat = get_category_by_slug('qa-category');
    }
    $args = [
        'post_title'    => rand(000000,999999) . ' - ' . $title,
        'post_content'  => '',
        'post_excerpt'   => $email,
        'post_status'   => 'private',
        'post_author'   => 1,
        'post_category' => [$cat->term_id]
    ];


    $postID = wp_insert_post($args, true);
    return $postID;
}