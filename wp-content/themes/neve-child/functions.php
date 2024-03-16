<?php

/* TODO: Move to new File */
add_shortcode('il_members', 'il_members');
function il_members($atts = array())
{


	// $wporg_atts = shortcode_atts(
	// 	array(
	// 		'title' => 'WordPress.org',
	// 	), $atts, $tag
	// );


if (gettype($atts) == 'string') {
	$atts = array('terms' => 'mitglied');
}
if (array_key_exists('terms',$atts)) {
	$terms = $atts['terms'];
} else {
	$terms = 'mitglied';
}

	$args = array(
			'post_type' => 'il_members',
			'order_by'  => 'menu_order',
			'tax_query' => array(
				array(
					'taxonomy' => 'il_member_status',
					'field' => 'slug',
					'terms' => $terms,
					'operator'  => 'IN'
				)
			),
			'posts_per_page' => -1
	);

	$query = new WP_Query($args);
	return build_members_grid($query->posts);
}
add_shortcode('il_leadership', 'il_leadership');
function il_leadership()
{
	$args = array(
		'post_type' => 'il_members',
		'order_by'  => 'menu_order',
		'tax_query' => array(
			array(
				'taxonomy' => 'il_member_status',
				'field' => 'slug',
				'terms' => 'leadership'
			)
		),
		'posts_per_page' => -1
	);

	$query = new WP_Query($args);
	return build_members_grid($query->posts, 'il-leadership');
}

function build_members_grid($members, $class = '')
{
	$membersListOut = '';
	$membersListOut  .= '<div class="il-members ' . $class . '">';


	ob_start();
	foreach ($members as $member_key => $member) {
		$profileImage = get_the_post_thumbnail($member->ID);
		if ($profileImage == null) {
			$profileImage = '<img src="http://dev.immortal-legends.net/wp-content/uploads/2023/06/cropped-iL-Logo.png" class="il-member-placeholder-img il-lower-contrast" alt="Immortal Legends">';
		}
		$htmlId = 'member-' . $member->post_name;
		$steamLink = get_field('il_member_steam', $member->ID);
		$name = get_field('il_member_name', $member->ID);
		$headline = get_field('il_member_headline', $member->ID);
		$description = get_field('il_member_description', $member->ID);
		$memberSince = get_field('il_member_since', $member->ID);
		$guardianOf = get_field('il_member_guardian_of', $member->ID)->post_title;
		$guardian = get_field('il_member_guardian', $member->ID)->post_title;

		$guardianOfHtmlId = '#member-' . get_field('il_member_guardian_of', $member->ID)->post_name;
		$guardianHtmlId = '#member-' . get_field('il_member_guardian', $member->ID)->post_name;
?>

		<div class="il-member" id='<?= $htmlId ?>'>
			<div class="il-member-image"><?= $profileImage ?></div>
			<div class="il-member-tag il-member-info">
				<?php
				if ($steamLink !== '') {
				?>
					<a href="<?= $steamLink ?>" target="_blank">
						<?= $member->post_title ?>
					</a>
				<?php
				} else {
					echo $member->post_title;
				}
				?>
			</div>
			<?php
			if ($name !== null) {
			?>
				<div class="il-member-name il-member-info"><?= $name ?></div>
			<?php
			}
			if ($headline !== null) {
			?>
				<div class="il-member-headline il-member-info"><?= $headline ?></div>
			<?php
			}
			if ($description !== null) {
			?>
				<div class="il-member-description il-member-info"><?= $description ?></div>
			<?php
			}
			if ($memberSince !== null) {
			?>
				<div class="il-member-since il-member-info">Mitglied seit <?= $memberSince ?></div>
			<?php
			}
			if ($guardianOf !== null) {
			?>
				<div class="il-member-guardian-of il-member-info">Wächter von <a href="<?= $guardianOfHtmlId ?>"><?= $guardianOf ?></a></div>
			<?php
			}
			if ($guardian !== null) {
			?>
				<div class="il-member-guardian il-member-info">Bewacht von <a href="<?= $guardianHtmlId ?>"><?= $guardian ?></a></div>
			<?php
			}
			?>
		</div>
<?php
	}
	$membersListOut .= ob_get_clean();
	$membersListOut .= '</div>';
	return $membersListOut;
}
function neve_child_enqueue_styles()
{
	wp_enqueue_style('child-style', get_template_directory_uri() . '-child/style.css');
	wp_enqueue_style('font-style', get_template_directory_uri() . '-child/fonts/fonts.css');
	wp_enqueue_script('jQuery', get_template_directory_uri() . '-child/jquery-3.7.0.min.js');
	wp_enqueue_script('cookies', get_template_directory_uri() . '-child/cookies.js');
	wp_enqueue_script('color-switch', get_template_directory_uri() . '-child/color-switch.js');
	wp_enqueue_script('gallery', get_template_directory_uri() . '-child/gallery-size.js');
}
add_action('wp_enqueue_scripts', 'neve_child_enqueue_styles', 9999999999);
