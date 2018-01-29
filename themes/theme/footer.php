<?php
/**
 * The template for displaying the footer.
 *
 * Please browse readme.txt for credits and forking information
 * Contains the closing of the #content div and all content after
 *
 * @package cleanblog
 */

?>

</div><!-- #content -->


	<div class="footer-wrap">

		<?php if ( is_active_sidebar( 'footer_widget_left') ||  is_active_sidebar( 'footer_widget_middle') ||  is_active_sidebar( 'footer_widget_right')  ) : ?>

		<div class="footer-widget-wrapper">
			

				
				<div class="footer-cta visible-xs visible-sm">
					<div class="footer-cta-close" id="footer-banner-close">
						<img src="<?php echo get_template_directory_uri(); ?>/images/x.svg" alt="close">
					</div>
					<div class="container">
						<div class="row">
							<div class="col-sm-6 col-xs-12 footer-cta-left">
								<p class="footer-cta-header">Haven’t found the essay you want? </p>
								<p class="footer-cta-sub-header">
									Get your custom essay sample <br> for only $13.90/page
								</p>
							</div>
							<div class="col-sm-6 col-xs-12">
								<a class="cta__btn" href="" rel="nofollow">
									<span>WRITE MY ESSAY</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				

			
			
			<div class="container">

				<div class="row">
					<div class="col-md-4">
						<?php dynamic_sidebar( 'footer_widget_left' ); ?> 
					</div>
					<div class="col-md-4">
						<?php dynamic_sidebar( 'footer_widget_middle' ); ?> 
					</div>
					<div class="col-md-4">
						<?php dynamic_sidebar( 'footer_widget_right' ); ?> 
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
			
		<footer id="colophon" class="site-footer">
			<div class="row site-info">
				<div class="copy-right-section">
				<?php if (get_theme_mod('footer_copyright_content') ) : ?>
				<?php echo wp_kses_post(get_theme_mod('footer_copyright_content')) ?>
				<?php else : ?>
				<?php echo '&copy; '.date_i18n(__('Y','cleanblog')); ?> <?php bloginfo( 'name' ); ?>
				<?php endif; ?>
				</div>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->

		<div class="header__top-cta hide">
			<?php
			//    cta href
			  if (isset($_COOKIE['email'])) {
			      $ahref = 'https://essays.paragraphica.com/fast-signup?email='.$_COOKIE['email'].'&utm_source=paragraphica.com&utm_campaign=header&utm_medium=R&utm_term=get_custom_essay&utm_content=fast-signup ';
			  } else {
			      $ahref = 'https://essays.paragraphica.com/?login-first=1&utm_source=paragraphica.com&utm_campaign=header&utm_medium=R&utm_term=get_custom_essay&utm_content=login-first';
			  }

			  // $button_name = 'Get Your <br> Custom Essay';
			  $cta_type = 'CTA';
			  $cta_postition = 'menu';
			  $btn_ga = 'Get Custom Essay';
			?>
		  <a href="<?= $ahref ?>" rel="nofollow" onclick="ga('send','event','<?= $cta_type ?>','<?= $cta_postition ?>','<?= $btn_ga ?>');">
		    Get Your <br> Custom Essay
		  </a>
		</div>

		<div class="container head-cta hide">
			<div class="row">
				<div class="col-md-4 col-md-offset-1 col-sm-7 col-xs-8 padding0 xs-padding0-right sub_header-cta-left">
					<p>Let us write you a custom essay sample</p>
					<p class="visible-sm visible-xs">for only $13.90/page</p>
				</div>
				<div class="col-md-3 col-sm-5 padding0 col-xs-4 xs-padding0-left" >
					<a class="cta__btn" href="<?= $ahref ?>" rel="nofollow" onclick="ga('send','event','<?= $cta_type ?>','<?= $cta_postition ?>','<?= $btn_ga ?>');">
						<span class="hidden-xs">Get your custom essay sample</span>
						<span class="visible-xs">Get your essay</span>
					</a>
				</div>
				<div class="col-md-4 padding0 hidden-sm hidden-xs sub_header-cta-right"><p>for only $13.90/page</p></div>
			</div>
		</div>

		<script>
			function topBanner() {
				let parent = document.querySelector('.site-header');

				if (parent) {
					let topCta = document.querySelector('.header__top-cta');
					let cloneTopCta = topCta.cloneNode(true);

					cloneTopCta.classList.remove('hide');

					parent.appendChild(cloneTopCta);
				}
			}

			function contentBanner() {
				let parent = document.querySelector('.test-cta');

				if (parent) {
					let contentCta = document.querySelector('.pgp__testi-cta');
					let cloneContentCta = contentCta.cloneNode(true);

					cloneContentCta.classList.remove('hide');

					parent.appendChild(cloneContentCta);
				}
			}

			function headBanner() {
				let parent = document.querySelector('.head-cta-wrap');

				if (parent) {
					let contentCta = document.querySelector('.head-cta');
					let cloneContentCta = contentCta.cloneNode(true);

					cloneContentCta.classList.remove('hide');

					parent.appendChild(cloneContentCta);
				}
			}

			window.onload = function() {
				topBanner();
				contentBanner();
				headBanner();
			};
		</script>

	</div>

<?php get_template_part('inc/CTA/side','left'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>



</body>
</html>
