<?php
use \theme\Profile;
/*
 * Template Name: Profile page
 */
get_header();
if (!is_user_logged_in()) header('Location: /');
$profile = new Profile();
if (!$profile->checkMembershipLevel()) {
	$level = new stdClass();
	$level->name = 'No membership level';
    $level->description = 'You have not membership level';
} else {
    $level = $profile->getLastLevel();
}
?>
<div class="profile__teaser">
	<div class="container">
		<div class="flex-row">
			<h1 class="profile__teaser-title"><?= strtoupper(get_the_title()); ?></h1>
			<div class="profile__teaser-userdata">
				<ul>
					<li><span id="user-name"><?= $profile->getUserName(); ?></span></li>
					<li><a href="<?= wp_logout_url(home_url()); ?>">Log out</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<main class="profile page">
	<div class="container">
		<div class="flex-row">
			<div class="col-sm-7 col-xs-12 padding-sm-right">
				<div class="membership__data-wrap">
					<div class="membership__data-top">
						<div class="membership__level">
							Current membership membership:
						</div>
						<div class="membership__level-details">
							<?= $level->name; ?>
						</div>
					</div>
					<div class="membership__data-bottom">
						<ul class="user-data" style="display: none;">
							<li>
                                    <span class="value">
                                        <span class="big">45</span>/80
                                    </span>
								Downloads
							</li>
							<li>
                                    <span class="value">
                                        <span class="big">12</span>/60
                                    </span>
								Checks
							</li>
						</ul>
						<div class="membership__properties">
                            <ul><?= do_shortcode($level->description); ?></ul>
						</div>
						<div class="membership__ends">
                            <?php if (isset($date)) { ?>
							    The term of your subscription ends in:
							    <div><strong><?= $profile->getLevelEndDate(); ?></strong></div>
                            <?php } else { ?>
                                No date expirience...
                            <?php } ?>
						</div>
						<div class="membership__btns">
							<div class="flex-row">
								<div class="col-sm-5 col-xs-12 padding-sm-right">
                                    <?php if ($profile->checkMembershipLevel()) { ?>
									<button class="btn" type="submit" onclick="window.location.href='/account/levels/'">
										PROLONG ACCESS
									</button>
                                    <?php } ?>
								</div>
								<div class="col-sm-7 col-xs-12 margin-xs-top-15">
									<a href="/account/levels/">choose subscription plan</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-5 col-flex col-xs-12 margin-xs-top-15">
				<div class="membership__history">
					<div class="membership__title">
						History
					</div>
					<div class="membership__history-items">
						<table class="table">
                            <?php if (!empty($profile->getInvoices())) { ?>
                                <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>Level</th>
                                    <th>AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($profile->getInvoices() as $invoice) :
                                    $invoice_id = $invoice->id;
                                    $invoice = new MemberOrder;
                                    $invoice->getMemberOrderByID($invoice_id);
                                    $invoice->getMembershipLevel();
                                    ?>
                                    <tr>
                                        <td><?= date_i18n(get_option("date_format"), $invoice->timestamp) ?></td>
                                        <td><?= !empty($invoice->membership_level) ? $invoice->membership_level->name : 'N/A' ?></td>
                                        <td><?= pmpro_formatPrice($invoice->total) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            <?php } else { ?>
                                <p>History is not available</p>
                            <?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="password-wrap">
			<div class="title">
				change the password
			</div>
			<form autocomplete="off" data-form="ajax">
				<div class="flex-row">
					<div class="col-sm-3 col-xs-12 padding-sm-right ">
						<div class="form-group">
							<div class="input input--animate">
								<input class="input__field input__field--animate noclean" name="name" type="text" value="<?= $profile->getUserName(); ?>">
								<label class="input__label input__label--animate">
									<span class="input__label-content input__label-content--animate">Enter your full name</span>
								</label>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-12 margin-xs-top-15 padding-sm-right ">
						<div class="form-group">
							<div class="input input--animate">
								<input class="input__field input__field--animate noclean" name="email" type="email" value="<?= $profile->getUserEmail(); ?>" disabled="disabled">
								<label class="input__label input__label--animate">
									<span class="input__label-content input__label-content--animate">Confim your e-mail</span>
								</label>
							</div>
						</div>
					</div>
                    <div class="col-sm-3 col-xs-12 margin-xs-top-15 padding-sm-right ">
                        <div class="form-group">
                            <div class="input input--animate">
                                <input class="input__field input__field--animate" name="pwd" type="password">
                                <label class="input__label input__label--animate">
                                    <span class="input__label-content input__label-content--animate">Your password</span>
                                </label>
                            </div>
                        </div>
                    </div>
					<div class="col-sm-3 col-xs-12 margin-xs-top-15 padding-sm-right ">
						<div class="form-group">
							<div class="input input--animate">
								<input class="input__field input__field--animate" name="new_pwd" type="password">
								<label class="input__label input__label--animate">
									<span class="input__label-content input__label-content--animate">New password</span>
								</label>
							</div>
						</div>
					</div>
                    <div class="col-sm-3 col-xs-12 margin-xs-top-15 padding-sm-right ">
                        <div class="form-group">
                            <div class="input input--animate">
                                <input class="input__field input__field--animate" name="new_pwd_replay" type="password">
                                <label class="input__label input__label--animate">
                                    <span class="input__label-content input__label-content--animate">Confim new password</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 margin-xs-top-15 padding-sm-right ">
                        <div class="form-group">
                            <div class="input input--animate">
                                <input type="hidden" name="action" value="update_profile">
                                <input type="hidden" name="_wpnonce" value="<?= wp_create_nonce('update_profile'); ?>">
                                <input class="btn" name="update" type="submit" value="Update">
                            </div>
                        </div>
                    </div>
				</div>
			</form>
		</div>

	</div>
</main>
<?php get_footer(); ?>