<?php
/**
 * Template Name: Checkout page
 */
//if (!is_user_logged_in()) header('Location: /account/register/');
get_header();
if (!(int)$_GET['level']) wp_die('You have not access.');
$level = pmpro_getLevel($_GET['level']);
$js_cta_levels_register_button = 'js_cta_click_levels_register_button';
$js_cta_levels_checkout_button = 'js_cta_click_levels_checkout_button';
global $invoices_count;
?>
<script>
    jQuery(document).ready(function ($) {
        var PmProAnalytic= new PmProAnalytics();
        PmProAnalytic.initCheckOutPage({
            currentLevelId: 'P<?= $level->id; ?>',
            currentLevelDays: '<?= cycleInDay($level); ?>D',
            currentLevelPrice: '$<?= $level->billing_amount; ?>',
            paymentCounter: '<?= $invoices_count; ?>',
            el_register_button: '<?= $js_cta_levels_register_button; ?>',
            el_checkout_button: '<?= $js_cta_levels_checkout_button; ?>'
        });
    });
</script>
<div id="pmpro_level-<?= $level->id; ?>">
    <div class="single__teaser category__teaser">
        <h1>Checkout</h1>
    </div>
    <div class="container">
        <main class="membership page">
            <?php if (!is_user_logged_in()) : ?>
            <form class="pmpro_form" action="<?= admin_url('admin-ajax.php'); ?>" method="post">
            <?php else: ?>
            <form id="pmpro_form" class="pmpro_form" action="" method="post">
            <?php endif; ?>
                <input type="hidden" id="level" name="level" value="<?= $level->id; ?>">
                <input type="hidden" id="checkjavascript" name="checkjavascript" value="<?= $level->id; ?>">

                <div id="pmpro_message" class="pmpro_message" style="display: none;"></div>
                <div class="flex-row">
                    <div class="col-xs-12">
                        <div class="membership__level">
                            Membership level:
                        </div>
                        <div class="membership__level-details">
                            <?= $level->name; ?> <a href="/account/levels/">Change</a>
                        </div>
                        <div class="membership__price-value text-right">
                            <?php
                            echo "\${$level->billing_amount} "; // Show price
                            echo "every {$level->cycle_number} "; // show count for cycle days or month
                            echo strtolower($level->cycle_period) . (strtolower($level->cycle_number) > 1 ? 's' : ''); // echo string days or month
                            ?>
                        </div>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="col-xs-12">
                        <div class="membership__left-col">
                            <div class="membership__level-selected">
                                You have selected the <strong><?= $level->name; ?></strong> level
                            </div>
                            <div class="membership__properties">
                                <ul><?= do_shortcode($level->description); ?></ul>
                            </div>
                            <div class="membership__price-title">
                                You have selected the <strong><?= $level->name; ?></strong> level.
                            </div>
                        </div>
                    </div>

                </div>
                <div class="pmpro_submit">
                    <span id="pmpro_paypalexpress_checkout">
                        <input type="hidden" name="submit-checkout" value="<?= $level->id; ?>">
                        <input type="hidden" name="javascriptok" value="<?= $level->id; ?>">
                        <?php if (!is_user_logged_in()) : ?>
                            <input class="pmpro_submit__register--email" type="email" name="email" placeholder="Your email">
                            <input type="hidden" name="_redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
                            <input type="hidden" name="action" value="register_user">
                            <input type="hidden" name="_wpnonce" value="<?= wp_create_nonce('register_user'); ?>">
                            <button class="<?= $js_cta_levels_register_button; ?> pmpro_submit__register--btn">Register account</button>
                        <?php else: ?>
                        <button class="<?= $js_cta_levels_checkout_button; ?> btn-checkout pmpro_btn-submit-checkout" title="Checkuot"> <img src="<?= get_template_directory_uri(); ?>/assets/img/PayPal.svg" alt="Checkuot">Check out</button>
                        <?php endif; ?>
                        <?php \theme\Alert::show(); ?>
                    </span>
                    <span id="pmpro_submit_span" style="display: none;">
                        <input type="hidden" name="submit-checkout" value="1"><input type="hidden" name="javascriptok" value="<?= $level->id; ?>">
                        <input type="submit" class="pmpro_btn pmpro_btn-submit-checkout" value="Submit and Check Out »">
                    </span>
                    <span id="pmpro_processing_message" style="visibility: hidden;">Processing...</span>
                </div>
            </form>
        </main>
    </div>
</div>
<?php get_footer();