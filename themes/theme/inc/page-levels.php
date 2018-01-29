<?php
use theme\Levels;
use theme\Core;
/*
 * Template Name: Level page
 */
get_header();
$levels = pmpro_getAllLevels(false, true);
?>
<script>
    window.onload = function () {
        var PmProAnalytic= new PmProAnalytics();
        PmProAnalytic.initLevelsPage({
            'levels': [
                <?php $i = 0; foreach ($levels as $level) : $i++; ?>
                {
                    'id': 'P<?= $level->id; ?>',
                    'name': '<?= cycleInDay($level); ?>D',
                    'postion': <?= $i; ?>
                },
                <?php endforeach; ?>
            ],
            'el_level_button': 'js_cta_click_levels_button'
        });
    };
</script>
<div class="cards">
    <h2><?= Core::convertTitle(get_post_meta(get_the_ID(), 'title', true)) ?: 'Title'; ?></h2>
    <div class="cards__description">
        <?php
        while(have_posts()) : the_post();
            the_content();
        endwhile;
        ?>
    </div>
    <div class="container">
        <?php
        for($n = 1; $n <= 3; $n++) :
            if ($n == 1) {
              $i = 1;
              $var = 'Billed $19.9 today then each month';
            } elseif ($n == 2) {
              $i = 3;
              $var = 'Billed $71.4 today then every 6 months';
              $after_btn = '<i>Save $48 off the monthly plan</i>';
            } elseif ($n == 3) {
              $i = 2;
              $var = 'Billed $47.7 today and then every 3 months';
            }
            ?>
            <?php //Core::spannedPrice($levels[$i]->initial_payment);  ?>
            <div class="cards__elem">
                <div class="cards__header">
                    <div class="cards__title"><?= Core::convertLevelTitle($levels[$i]->name); ?></div>
                </div>
                <div class="cards__price"><?= Core::spannedPrice(intval(($levels[$i]->initial_payment / Levels::getDays($levels, $i) * 100)) / 100, 'round') ?></div>
                <div class="cards__price-refinement"><?= $levels[$i]->confirmation; ?></div>
                <div class="cards__advantage border"><?= $var ?></div>
                <?= do_shortcode($levels[$i]->description); ?>
                <a class="js_cta_click_levels_button button loginModal" href="/account/checkout/?level=<?= $levels[$i]->id; ?>" data-level="<?= $levels[$i]->id; ?>">Buy now</a>
                <?php if ($n == 2) echo $after_btn; ?>
            </div>

        <?php endfor; ?>
    </div>
</div>

<?php if(count($levels) > 3) : ?>
    <div class="trial">
        <h2><span>Make</span><span>a trial</span><span>run!</span></h2>
        <div class="trial__description">
            <?= do_shortcode($levels[4]->description); ?>
        </div>
        <div class="trial__banner">
            <div class="trial__left-col">
                <div class="trial__title"><?= Core::convertLevelTitle($levels[4]->name); ?></div>
                <div class="trial__access"><?= $levels[4]->confirmation; ?></div>
            </div>
            <div class="trial__middle-col">
                <div class="trial__price"><?= Core::spannedPrice($levels[4]->initial_payment, 'false', false); ?></div>
                <div class="trial__price-refinement"><?= round($levels[4]->billing_amount, 1); ?> / month</div>
            </div>
            <div class="trial__right-col"><a class="js_cta_click_levels_button button loginModal" href="/account/checkout/?level=<?= $levels[4]->id; ?>" data-level="<?= $levels[4]->id; ?>">Buy now</a>
                <div class="trial__no-limit">No download limit</div>
            </div>
        </div>
    </div>
<?php endif; ?>



<?php get_footer(); ?>
