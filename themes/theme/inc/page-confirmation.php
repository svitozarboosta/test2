<?php
/*
 * Template Name: Confirmation page
 */
get_header();
$order = new MemberOrder();
$order->getLastMemberOrder();
global $invoices_count;
?>
    <script>
        ga('ec:addProduct', {
            'id': 'P<?= $order->id; ?>',
            'name': '<?= cycleInDay($order->getMembershipLevel()); ?>D',
            'category': '<?= $invoices_count; ?>',
            'brand': 'paying by card',
            'variant': '1',

            'price': '<?= $order->total; ?>',
            'quantity': 1
        });

        ga('ec:setAction', 'purchase', {
            'id': '<?= $order->payment_transaction_id; ?>',
            'affiliation': 'PayPal',
            'revenue': '<?= $order->total; ?>',
            'tax': '0',
            'shipping': '0'
        });

        ga('send', 'pageview');
    </script>

    <div class="single">
        <div class="container">
            <main>
                <?= do_shortcode('[pmpro_confirmation]'); ?>
            </main>
        </div>
    </div>
<?php get_footer(); ?>