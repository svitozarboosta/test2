<div class="main-banner">
    <?php if(isset($_GET['message']) && $_GET['message'] === 'success') : ?>
        <div class="alert alert-success"><strong>Success</strong> Check your email.</div>
    <?php endif; ?>
    <h1>Have you been inflicted another written assignment?</h1>
    <div class="main-banner__description">Give us a topic and we will deliver it immediately!</div>
    <form class="main-banner__form" action="<?php echo home_url( '/' ); ?>" method="GET">
        <svg>
            <use xlink:href="<?= get_template_directory_uri(); ?>/assets/img/sprite.svg#ico-search"></use>
        </svg>
        <input type="text" placeholder="Papers, research projects, case studies and everything else..." name="s">
        <input type="submit" value="Search">
    </form>
    <div class="main-banner__strip">
        <div class="main-banner__advantage">Round-the-clock
            <div>Support</div>
        </div>
        <div class="main-banner__advantage">Omnipotent
            <div>Writers</div>
        </div>
        <div class="main-banner__advantage">Authentic
            <div>Works</div>
        </div>
    </div>
</div>