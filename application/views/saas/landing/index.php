<?php
$wl = getWhiteLabel();
$site_name = '';
$footer = '';
$favicon = '';
$phone = '';
$email = '';
if($wl){
	$phone = isset($wl->phone) && $wl->phone?$wl->phone:'';
	$email = isset($wl->email) && $wl->email?$wl->email:'';
	 
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->footer){
        $footer = $wl->footer;
    }
    if($wl->system_logo){
        $system_logo = base_url()."images/".$wl->system_logo;
    }
    if($wl->favicon){
        $favicon = base_url()."images/".$wl->favicon;
    }else{
        $favicon = base_url()."images/favicon.ico";
    }
}
$company = getMainCompany();

$social_links = isset($company->social_link_details) && $company->social_link_details?json_decode($company->social_link_details):'';
$customer_reviewers = isset($company->customer_reviewers) && $company->customer_reviewers?json_decode($company->customer_reviewers):'';
$counter_details = isset($company->counter_details) && $company->counter_details?json_decode($company->counter_details):'';
?>

<!DOCTYPE html>
<html lang="en-US" class="no-js no-svg">  
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- responsive meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- For IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
	<style>
		img:is([sizes="auto" i], [sizes^="auto," i]) {
			contain-intrinsic-size: 3000px 1500px
		}
	</style>

	<!-- This site is optimized with the Yoast SEO plugin v24.0 - https://yoast.com/wordpress/plugins/seo/ -->
	<title><?php echo escape_output($site_name)?></title>
	<link rel="canonical" href="<?php echo base_url()?>">
	<meta property="og:locale" content="en_US">
	<meta property="og:type" content="software">
	<meta property="og:title" content="<?php echo escape_output($site_name)?>">
	<meta property="og:url" content="<?php echo base_url()?>">
	<meta property="og:site_name" content="<?php echo escape_output($company->business_name)?>">
	<meta property="article:publisher" content="<?php echo base_url()?>"> 
	<meta property="og:image" content="<?php echo escape_output($system_logo)?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:label1" content="Est. reading time">
	<meta name="twitter:data1" content="34 minutes">
	<script src="<?php echo base_url()?>assets/landing/js/jquery-3.6.0.min.js"></script>
 
	<style id="wp-emoji-styles-inline-css" type="text/css">
		img.wp-smiley,
		img.emoji {
			display: inline !important;
			border: none !important;
			box-shadow: none !important;
			height: 1em !important;
			width: 1em !important;
			margin: 0 0.07em !important;
			vertical-align: -0.1em !important;
			background: none !important;
			padding: 0 !important;
		}
	</style>
	<style id="classic-theme-styles-inline-css" type="text/css">
		/*! This file is auto-generated */
		.wp-block-button__link {
			color: #fff;
			background-color: #32373c;
			border-radius: 9999px;
			box-shadow: none;
			text-decoration: none;
			padding: calc(.667em + 2px) calc(1.333em + 2px);
			font-size: 1.125em
		}

		.wp-block-file__button {
			background: #32373c;
			color: #fff;
			text-decoration: none
		}
	</style>
	<style id="global-styles-inline-css" type="text/css">
		:root {
			--wp--preset--aspect-ratio--square: 1;
			--wp--preset--aspect-ratio--4-3: 4/3;
			--wp--preset--aspect-ratio--3-4: 3/4;
			--wp--preset--aspect-ratio--3-2: 3/2;
			--wp--preset--aspect-ratio--2-3: 2/3;
			--wp--preset--aspect-ratio--16-9: 16/9;
			--wp--preset--aspect-ratio--9-16: 9/16;
			--wp--preset--color--black: #000000;
			--wp--preset--color--cyan-bluish-gray: #abb8c3;
			--wp--preset--color--white: #ffffff;
			--wp--preset--color--pale-pink: #f78da7;
			--wp--preset--color--vivid-red: #cf2e2e;
			--wp--preset--color--luminous-vivid-orange: #ff6900;
			--wp--preset--color--luminous-vivid-amber: #fcb900;
			--wp--preset--color--light-green-cyan: #7bdcb5;
			--wp--preset--color--vivid-green-cyan: #00d084;
			--wp--preset--color--pale-cyan-blue: #8ed1fc;
			--wp--preset--color--vivid-cyan-blue: #0693e3;
			--wp--preset--color--vivid-purple: #9b51e0;
			--wp--preset--color--strong-yellow: #f7bd00;
			--wp--preset--color--strong-white: #fff;
			--wp--preset--color--light-black: #242424;
			--wp--preset--color--very-light-gray: #797979;
			--wp--preset--color--very-dark-black: #000000;
			--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
			--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
			--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
			--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
			--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
			--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
			--wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
			--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
			--wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
			--wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
			--wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
			--wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
			--wp--preset--font-size--small: 10px;
			--wp--preset--font-size--medium: 20px;
			--wp--preset--font-size--large: 24px;
			--wp--preset--font-size--x-large: 42px;
			--wp--preset--font-size--normal: 15px;
			--wp--preset--font-size--huge: 36px;
			--wp--preset--spacing--20: 0.44rem;
			--wp--preset--spacing--30: 0.67rem;
			--wp--preset--spacing--40: 1rem;
			--wp--preset--spacing--50: 1.5rem;
			--wp--preset--spacing--60: 2.25rem;
			--wp--preset--spacing--70: 3.38rem;
			--wp--preset--spacing--80: 5.06rem;
			--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
			--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
			--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
			--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
			--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
		}

		:where(.is-layout-flex) {
			gap: 0.5em;
		}

		:where(.is-layout-grid) {
			gap: 0.5em;
		}

		body .is-layout-flex {
			display: flex;
		}

		.is-layout-flex {
			flex-wrap: wrap;
			align-items: center;
		}

		.is-layout-flex> :is(*, div) {
			margin: 0;
		}

		body .is-layout-grid {
			display: grid;
		}

		.is-layout-grid> :is(*, div) {
			margin: 0;
		}

		:where(.wp-block-columns.is-layout-flex) {
			gap: 2em;
		}

		:where(.wp-block-columns.is-layout-grid) {
			gap: 2em;
		}

		:where(.wp-block-post-template.is-layout-flex) {
			gap: 1.25em;
		}

		:where(.wp-block-post-template.is-layout-grid) {
			gap: 1.25em;
		}

		.has-black-color {
			color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-color {
			color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-color {
			color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-color {
			color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-color {
			color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-color {
			color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-color {
			color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-color {
			color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-color {
			color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-color {
			color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-color {
			color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-color {
			color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-black-background-color {
			background-color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-background-color {
			background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-background-color {
			background-color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-background-color {
			background-color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-background-color {
			background-color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-background-color {
			background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-background-color {
			background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-background-color {
			background-color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-background-color {
			background-color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-background-color {
			background-color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-background-color {
			background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-background-color {
			background-color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-black-border-color {
			border-color: var(--wp--preset--color--black) !important;
		}

		.has-cyan-bluish-gray-border-color {
			border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
		}

		.has-white-border-color {
			border-color: var(--wp--preset--color--white) !important;
		}

		.has-pale-pink-border-color {
			border-color: var(--wp--preset--color--pale-pink) !important;
		}

		.has-vivid-red-border-color {
			border-color: var(--wp--preset--color--vivid-red) !important;
		}

		.has-luminous-vivid-orange-border-color {
			border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-amber-border-color {
			border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
		}

		.has-light-green-cyan-border-color {
			border-color: var(--wp--preset--color--light-green-cyan) !important;
		}

		.has-vivid-green-cyan-border-color {
			border-color: var(--wp--preset--color--vivid-green-cyan) !important;
		}

		.has-pale-cyan-blue-border-color {
			border-color: var(--wp--preset--color--pale-cyan-blue) !important;
		}

		.has-vivid-cyan-blue-border-color {
			border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
		}

		.has-vivid-purple-border-color {
			border-color: var(--wp--preset--color--vivid-purple) !important;
		}

		.has-vivid-cyan-blue-to-vivid-purple-gradient-background {
			background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
		}

		.has-light-green-cyan-to-vivid-green-cyan-gradient-background {
			background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
		}

		.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
			background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
		}

		.has-luminous-vivid-orange-to-vivid-red-gradient-background {
			background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
		}

		.has-very-light-gray-to-cyan-bluish-gray-gradient-background {
			background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
		}

		.has-cool-to-warm-spectrum-gradient-background {
			background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
		}

		.has-blush-light-purple-gradient-background {
			background: var(--wp--preset--gradient--blush-light-purple) !important;
		}

		.has-blush-bordeaux-gradient-background {
			background: var(--wp--preset--gradient--blush-bordeaux) !important;
		}

		.has-luminous-dusk-gradient-background {
			background: var(--wp--preset--gradient--luminous-dusk) !important;
		}

		.has-pale-ocean-gradient-background {
			background: var(--wp--preset--gradient--pale-ocean) !important;
		}

		.has-electric-grass-gradient-background {
			background: var(--wp--preset--gradient--electric-grass) !important;
		}

		.has-midnight-gradient-background {
			background: var(--wp--preset--gradient--midnight) !important;
		}

		.has-small-font-size {
			font-size: var(--wp--preset--font-size--small) !important;
		}

		.has-medium-font-size {
			font-size: var(--wp--preset--font-size--medium) !important;
		}

		.has-large-font-size {
			font-size: var(--wp--preset--font-size--large) !important;
		}

		.has-x-large-font-size {
			font-size: var(--wp--preset--font-size--x-large) !important;
		}

		:where(.wp-block-post-template.is-layout-flex) {
			gap: 1.25em;
		}

		:where(.wp-block-post-template.is-layout-grid) {
			gap: 1.25em;
		}

		:where(.wp-block-columns.is-layout-flex) {
			gap: 2em;
		}

		:where(.wp-block-columns.is-layout-grid) {
			gap: 2em;
		}

		:root :where(.wp-block-pullquote) {
			font-size: 1.5em;
			line-height: 1.6;
		}
	</style>
	<link rel="stylesheet" id="contact-form-7-css" href="<?php echo base_url()?>assets/landing/saas_new/styles.css" type="text/css"
		media="all">
	<style id="contact-form-7-inline-css" type="text/css">
		.wpcf7 .wpcf7-recaptcha iframe {
			margin-bottom: 0;
		}

		.wpcf7 .wpcf7-recaptcha[data-align="center"]>div {
			margin: 0 auto;
		}

		.wpcf7 .wpcf7-recaptcha[data-align="right"]>div {
			margin: 0 0 0 auto;
		}
	</style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
		integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" id="moko-minified-style-css" href="<?php echo base_url()?>assets/landing/saas_new/style.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-google-fonts-css" href="<?php echo base_url()?>assets/landing/saas_new/css(2)" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-bootstrap-css" href="<?php echo base_url()?>assets/landing/saas_new/bootstrap.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-fontawesome-all-css" href="<?php echo base_url()?>assets/landing/saas_new/fontawesome-all.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-flaticon-css" href="<?php echo base_url()?>assets/landing/saas_new/flaticon.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-animate-css" href="<?php echo base_url()?>assets/landing/saas_new/animate.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-owl-css" href="<?php echo base_url()?>assets/landing/saas_new/owl.css" type="text/css" media="all">
	<link rel="stylesheet" id="moko-animation-css" href="<?php echo base_url()?>assets/landing/saas_new/animation.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-jquery-ui-css" href="<?php echo base_url()?>assets/landing/saas_new/jquery-ui.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-custom-animate-css" href="<?php echo base_url()?>assets/landing/saas_new/custom-animate.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-jquery-fancybox-css" href="<?php echo base_url()?>assets/landing/saas_new/jquery.fancybox.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-jquery-bootstrap-touchspin-css"
		href="<?php echo base_url()?>assets/landing/saas_new/jquery.bootstrap-touchspin.css" type="text/css" media="all">
	<link rel="stylesheet" id="moko-jquery-mcustomscrollbar-css"
		href="<?php echo base_url()?>assets/landing/saas_new/jquery.mCustomScrollbar.min.css" type="text/css" media="all">
	<link rel="stylesheet" id="moko-moko-main-style-css" href="<?php echo base_url()?>assets/landing/saas_new/style.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-moko-custom-css" href="<?php echo base_url()?>assets/landing/saas_new/custom.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-moko-gutenberg-css" href="<?php echo base_url()?>assets/landing/saas_new/gutenberg.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-moko-tut-css" href="<?php echo base_url()?>assets/landing/saas_new/tut.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="moko-moko-responsive-css" href="<?php echo base_url()?>assets/landing/saas_new/responsive.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="moko-moko-woocommerce-css" href="<?php echo base_url()?>assets/landing/saas_new/woocommerce.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="elementor-icons-css" href="<?php echo base_url()?>assets/landing/saas_new/elementor-icons.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/landing/saas_new/dialog.min.css">
	<link rel="stylesheet" id="elementor-frontend-css" href="<?php echo base_url()?>assets/landing/saas_new/frontend.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="elementor-post-5-css" href="<?php echo base_url()?>assets/landing/saas_new/post-5.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="widget-heading-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-heading.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="widget-icon-list-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-icon-list.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="swiper-css" href="<?php echo base_url()?>assets/landing/saas_new/swiper.min.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="e-swiper-css" href="<?php echo base_url()?>assets/landing/saas_new/e-swiper.min.css" type="text/css"
		media="all">
	<link rel="stylesheet" id="widget-image-carousel-css"
		href="<?php echo base_url()?>assets/landing/saas_new/widget-image-carousel.min.css" type="text/css" media="all">
	<link rel="stylesheet" id="widget-text-editor-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-text-editor.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="widget-image-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-image.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="widget-icon-box-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-icon-box.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="e-animation-fadeInLeft-css" href="<?php echo base_url()?>assets/landing/saas_new/fadeInLeft.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="e-animation-fadeInRight-css" href="<?php echo base_url()?>assets/landing/saas_new/fadeInRight.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="widget-divider-css" href="<?php echo base_url()?>assets/landing/saas_new/widget-divider.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="elementor-post-3409-css" href="<?php echo base_url()?>assets/landing/saas_new/post-3409.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="google-fonts-1-css" href="<?php echo base_url()?>assets/landing/saas_new/css(3)" type="text/css"
		media="all">
	<link rel="stylesheet" id="elementor-icons-shared-0-css" href="<?php echo base_url()?>assets/landing/saas_new/fontawesome.min.css"
		type="text/css" media="all">
	<link rel="stylesheet" id="elementor-icons-fa-solid-css" href="<?php echo base_url()?>assets/landing/saas_new/solid.min.css"
		type="text/css" media="all">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
	<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/devtools-detect.js.download"
		id="devtools-detect-js"></script>
	<script bis_use="true" type="text/javascript" charset="utf-8"
		data-bis-config="[&quot;facebook.com/&quot;,&quot;twitter.com/&quot;,&quot;youtube-nocookie.com/embed/&quot;,&quot;//vk.com/&quot;,&quot;//www.vk.com/&quot;,&quot;linkedin.com/&quot;,&quot;//www.linkedin.com/&quot;,&quot;//instagram.com/&quot;,&quot;//www.instagram.com/&quot;,&quot;//www.google.com/recaptcha/api2/&quot;,&quot;//hangouts.google.com/webchat/&quot;,&quot;//www.google.com/calendar/&quot;,&quot;//www.google.com/maps/embed&quot;,&quot;spotify.com/&quot;,&quot;soundcloud.com/&quot;,&quot;//player.vimeo.com/&quot;,&quot;//disqus.com/&quot;,&quot;//tgwidget.com/&quot;,&quot;//js.driftt.com/&quot;,&quot;friends2follow.com&quot;,&quot;/widget&quot;,&quot;login&quot;,&quot;//video.bigmir.net/&quot;,&quot;blogger.com&quot;,&quot;//smartlock.google.com/&quot;,&quot;//keep.google.com/&quot;,&quot;/web.tolstoycomments.com/&quot;,&quot;moz-extension://&quot;,&quot;chrome-extension://&quot;,&quot;/auth/&quot;,&quot;//analytics.google.com/&quot;,&quot;adclarity.com&quot;,&quot;paddle.com/checkout&quot;,&quot;hcaptcha.com&quot;,&quot;recaptcha.net&quot;,&quot;2captcha.com&quot;,&quot;accounts.google.com&quot;,&quot;www.google.com/shopping/customerreviews&quot;,&quot;buy.tinypass.com&quot;,&quot;gstatic.com&quot;,&quot;secureir.ebaystatic.com&quot;,&quot;docs.google.com&quot;,&quot;contacts.google.com&quot;,&quot;github.com&quot;,&quot;mail.google.com&quot;,&quot;chat.google.com&quot;,&quot;audio.xpleer.com&quot;,&quot;keepa.com&quot;,&quot;static.xx.fbcdn.net&quot;,&quot;sas.selleramp.com&quot;,&quot;1plus1.video&quot;,&quot;console.googletagservices.com&quot;,&quot;//lnkd.demdex.net/&quot;,&quot;//radar.cedexis.com/&quot;,&quot;//li.protechts.net/&quot;,&quot;challenges.cloudflare.com/&quot;,&quot;ogs.google.com&quot;]"
		src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/executers/vi-tr.js"></script>
	<script type="text/javascript" id="jquery-core-js-extra">
		/* <![CDATA[ */
		var moko_data = { "ajaxurl": "https:\/\/doorsoft.co\/wp-admin\/admin-ajax.php", "nonce": "266615d8b4" };
		/* ]]> */
	</script>
	 <script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
	 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
	<link href="<?php echo base_url()?>assets/landing/saas_new/font.css" rel="stylesheet">
	<link href="<?php echo base_url()?>frequent_changing/slick-slider/slick-slider.css" rel="stylesheet">
	<link href="<?php echo base_url()?>frequent_changing/slick-slider/custom_css_azhar.css" rel="stylesheet">

	
	<style>

	</style>
	<meta name="generator"
		content="Elementor 3.26.0; features: additional_custom_breakpoints, e_element_cache; settings: css_print_method-external, google_font-enabled, font_display-auto">
	<style>
		.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
		.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
			background-image: none !important;
		}

		@media screen and (max-height: 1024px) {

			.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
			.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
				background-image: none !important;
			}
		}

		@media screen and (max-height: 640px) {

			.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
			.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
				background-image: none !important;
			}
		}
	</style>
	<!-- Meta Pixel Code -->
	<script>
		!function (f, b, e, v, n, t, s) {
			if (f.fbq) return; n = f.fbq = function () {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
			n.queue = []; t = b.createElement(e); t.async = !0;
			t.src = v; s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1342751913119369');
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=1342751913119369&ev=PageView&noscript=1" /></noscript>
	<!-- End Meta Pixel Code -->
	<meta name="facebook-domain-verification" content="phr3tszdq6xu1il6q0gndflcqymfkt">
	<link rel="icon" href="<?php echo escape_output($favicon) ?>">
	<link rel="apple-touch-icon" href="https://doorsoft.co/cont_mas_zak_naz/uploads/2022/01/doorsoft-fav.png">
	<meta name="msapplication-TileImage"
		content="https://doorsoft.co/cont_mas_zak_naz/uploads/2022/01/doorsoft-fav.png">
	<style type="text/css" id="wp-custom-css">
		/* Font uploads  */
		@import url('https://fonts.googleapis.com/css2?family=Anek+Telugu:wght@300;400;500;600;700;800&family=Russo+One&family=Saira:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,500;1,600;1,700&display=swap');

		/* Custom bangla fonts for bdsat */
		.page-id-42 h1,
		.page-id-42 h2,
		.page-id-42 h3,
		.page-id-42 h4,
		.page-id-42 h5,
		.page-id-42 p,
		.page-id-42 .elementor-widget-text-editor .elementor-widget-container {
			font-family: "SolaimanLipi", Arial, sans-serif !important;
		}

		/* Custom bangla fonts for bdrestora 01 
.postid-3564  h1,.postid-3564  h2,.postid-3564  h3,
.postid-3564  h4,
.postid-3564  h5,
.postid-3564  p,
.postid-3564  .elementor-widget-text-editor .elementor-widget-container,  .postid-3564 .elementor-widget-container  .elementor-icon-list-text,  .elementor-element .elementor-button-text, .elementor-widget-container .elementor-image-carousel-caption{
    font-family: "SolaimanLipi", Arial, sans-serif!important;
}*/

		/* Custom bangla fonts for bdrestora */
		.page-id-3409 h1,
		.page-id-3409 h2,
		.page-id-3409 h3,
		.page-id-3409 h4,
		.page-id-3409 h5,
		.page-id-3409 p,
		.page-id-3409 .elementor-widget-text-editor .elementor-widget-container,
		.page-id-3409 .elementor-widget-container .elementor-icon-list-text,
		.elementor-element .elementor-button-text,
		.elementor-widget-container .elementor-image-carousel-caption {
			font-family: "SolaimanLipi", Arial, sans-serif !important;
		}

		/* Custom boxshadow for hero slide in bdrestora 
.page-id-3409  .elementor-widget-container img {
box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}*/
		/* Custom bangla fonts for asthaCommerce */
		.page-id-44 h1,
		.page-id-44 h2,
		.page-id-44 h3,
		.page-id-44 h4,
		.page-id-44 h5,
		.page-id-44 p,
		.page-id-44 .elementor-widget-text-editor .elementor-widget-container,
		.page-id-44 .elementor-widget-container .elementor-icon-list-text {
			font-family: "SolaimanLipi", Arial, sans-serif !important;
		}

		/* Custom bangla fonts for biiponi */
		.page-id-40 h1,
		.page-id-40 h2,
		.page-id-40 h3,
		.page-id-40 h4,
		.page-id-40 h5,
		.page-id-40 p,
		.page-id-40 .elementor-widget-text-editor .elementor-widget-container,
		.page-id-40 .elementor-widget-container .elementor-icon-list-text {
			font-family: "SolaimanLipi", Arial, sans-serif !important;
		}

		/* Custom Bangla fonts for utpadoni*/
		.page-id-4297 h1,
		.page-id-4297 h2,
		.page-id-4297 h3,
		.page-id-4297 h4,
		.page-id-4297 h5,
		.page-id-4297 p,
		.page-id-4297 .elementor-widget-text-editor .elementor-widget-container,
		.page-id-4297 .elementor-widget-container .elementor-icon-list-text {
			font-family: "SolaimanLipi", Arial, sans-serif !important;
		}

		/* animation */
		@keyframes fadeInUp {
			from {
				opacity: 0;
				-webkit-transform: translate3d(0, 100%, 0);
				transform: translate3d(0, 100%, 0)
			}

			to {
				opacity: 1;
				-webkit-transform: translate3d(0, 0, 0);
				transform: translate3d(0, 0, 0)
			}
		}

		@keyframes movebounce {
			0% {
				transform: translateY(0px);
			}

			50% {
				transform: translateY(20px);
			}

			100% {
				transform: translateY(0px);
			}
		}

		nav.main-menu.navbar-expand-md {
			float: right;
		}

		/* products icons */
		.features-icons .elementor-icon i {
			width: 100%;
			height: 100%;
		}

		/* page banner title */
		section.page-title {
			background: #F0FAFF !important;
		}

		.page-title div[class*='pattern-layer-'] {
			display: none;
		}

		.page-title h2,
		.page-breadcrumb li:after,
		.page-breadcrumb li {
			color: #333;
		}

		.page-breadcrumb li a {
			color: #0c5889;
		}

		/* main header css */
		.main-header {
			padding-top: 0px;
		}

		/* project page header */
		.project-template .main-header,
		.page-template .main-header:not(.home .main-header),
		.single-post .main-header {
			position: relative;
			padding: 0;
		}

		.page-title {
			padding: 100px 0px 100px;
		}

		.page-breadcrumb {
			display: none;
		}

		/* navigation */
		.main-menu ul li.menu-item-has-children>a:after {
			content: '+';
			display: inline-block;
			letter-spacing: 0;
			font-size: 14px;
			color: inherit;
			position: relative;
			font-weight: 500;
			top: -1px;
			margin-left: 5px;
		}

		.main-menu .navigation>li>ul>li>a:before {
			display: none !important;
		}

		.main-menu .navigation>li>ul>li:hover>a {
			color: #1519b2;
		}

		.sticky-header .main-menu .navigation>li:hover>a,
		.sticky-header .main-menu .navigation>li.current>a {
			color: #1519b2;
		}

		/* hero banner css */
		.elementor-widget-moko_slider_v1 .patern-layer-one {
			animation-name: rotateme;
			animation-duration: 15s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
			-webkit-animation-name: rotateme;
			-webkit-animation-duration: 15s;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-timing-function: linear;
			-moz-animation-name: rotateme;
			-moz-animation-duration: 15s;
			-moz-animation-iteration-count: infinite;
			-moz-animation-timing-function: linear;
			-ms-animation-name: rotateme;
			-ms-animation-duration: 15s;
			-ms-animation-iteration-count: infinite;
			-ms-animation-timing-function: linear;
			-o-animation-name: rotateme;
			-o-animation-duration: 15s;
			-o-animation-iteration-count: infinite;
			-o-animation-timing-function: linear;
			position: absolute;
			left: -200px;
			width: 400px;
			height: 300px;
			background-repeat: no-repeat;
			top: 100px;
			background-size: contain;
		}

		.banner-section-four .owl-carousel .owl-item img,
		.back-to-top.show-back-to-top {
			-webkit-animation: movebounce 3s linear infinite;
			animation: movebounce 3s linear infinite;
			max-width: 100%;
			margin-left: auto;

		}

		.banner-section-four .owl-carousel .owl-item img {
			padding-right: 60px
		}

		.banner-section-four .content-column .inner-column {
			/*     padding-top: 160px; */
			padding-top: 0px;
		}

		.banner-section-four .slide {
			padding-bottom: 50px
		}

		.banner-section-four .content-column h1 {
			font-size: 60px;
		}

		.banner-section-four .content-column .title {
			font-family: 'Saira', sans-serif;
			font-size: 47px;
			line-height: 45px;
		}

		.banner-section-four .content-column h1 {
			font-family: 'Russo One', sans-serif;

		}

		.banner-section-four .content-column .title,
		.banner-section-four .content-column h1 {
			color: #202C53;
		}

		/* Header menu */
		.main-menu .navigation>li>a {
			color: #3D4856;
		}

		.main-menu .navigation>li>ul>li>a {
			text-transform: none;

		}

		.main-header .header-upper .logo-box .logo {
			height: 70px;
			display: flex;
			align-items: center;
		}

		/* buttons style */

		.theme-btn {
			border-radius: 4px !important;
			padding: 16px 32px !important;
		}

		.btn-box .btn-style-one:hover,
		.btn-box .btn-style-two,
		.btn-box .btn-style-two:hover {
			color: #ffffff;
		}

		.btn-style-ten,
		/* .btn-style-nine, */
		.btn-style-eight,
		.btn-style-seven {
			color: #fff !important;
		}

		.btn-style-nine {
			border: 1.5px solid #01A0DC;
			color: #01A0DC !important;
		}

		.btn-style-nine:hover,
		.btn-style-nine:before {
			background: #01A0DC !important;
			color: #fff !important;
			border-color: #01A0DC;
		}

		.btn-style-eight,
		.btn-style-ten {
			background: #01A0DC !important;
			border: 1.5px solid #01A0DC;
		}

		.btn-style-eight:hover,
		.btn-style-eight:before,
		.btn-style-ten:hover,
		.btn-style-ten:before {
			background: #fff;
			color: #01A0DC !important;
			border-color: #01A0DC !important;
		}

		.banner-section-four .image-column .images-icons img {
			display: none;
		}

		.sec-title h2 {
			font-size: 16px;
		}

		.services-section-two.style-two .lower-box .text {
			color: #ffffff;
			background: linear-gradient(to right, #e82a6a 0%, #e82a6a 100%);
		}

		.services-section-two.style-two .lower-box .text a {
			color: #0c5889;
		}

		/* global section title */
		.section-title.elementor-widget .elementor-widget-container .elementor-heading-title,
		.sec-title .title {
			position: relative;
			color: #01A0DC;
			font-size: 40px;
			font-weight: 600;
			padding-right: 60px;
			padding-left: 60px;
			display: inline-block;
			text-transform: uppercase;
			/*     font-family: 'Poppins', sans-serif; */
			font-family: 'Saira', sans-serif;
			line-height: 29px;
		}

		.section-title.elementor-widget .elementor-widget-container .elementor-heading-title:before {
			position: absolute;
			content: '';
			right: 0px;
			top: 4px;
			width: 43px;
			height: 15px;
			background: url(/wp-content/uploads/2022/02/blue-title-icon.png) no-repeat;
		}

		.section-title.elementor-widget .elementor-widget-container .elementor-heading-title:after,
		.mixitup-gallery .section-title .title:after,
		.sec-title .title:after {
			position: absolute;
			content: '';
			left: 0px;
			top: 4px;
			width: 43px;
			height: 15px;
			background: url(/wp-content/uploads/2022/02/blue-title-icon.png) no-repeat;
		}

		.sec-title .title:before {
			background: url(/wp-content/uploads/2022/02/blue-title-icon.png) no-repeat;
		}

		.sec-title.centered .title {}

		.sec-title.centered .title:after,
		.mixitup-gallery .section-title .title:after,
		.sec-title .title:after {
			background: url(/wp-content/uploads/2022/02/blue-title-icon.png) no-repeat;
		}

		.team-block-two .inner-box::after {
			background: #151ab2;
			background: -webkit-linear-gradient(to right, #151ab2 0%, #4c68e2 100%);
			background: -moz-linear-gradient(to right, #151ab2 0%, #4c68e2 100%);
			background: linear-gradient(to right, #151ab2 0%, #4c68e2 100%);
		}

		/* services boxs */
		.service-block.style-two .inner-box .color-layer:after,
		.service-block.style-two .inner-box .color-layer:before {}

		.inner-container .clearfix {
			display: flex;
			flex-wrap: wrap;
		}

		.service-block.style-two .inner-box .arrow-icon {
			background-color: #01a0dc;
			background: -webkit-linear-gradient(313.92deg, #08AEEC 10.47%, #08AEEC 90.77%);
			background: -moz-linear-gradient(313.92deg, #08AEEC 10.47%, #08AEEC 90.77%);
			background: linear-gradient(313.92deg, #08AEEC 10.47%, #08AEEC 90.77%);
		}

		.service-block-two.style-two .inner-box .color-layer:before,
		.service-block-two.style-two .inner-box .color-layer:after {
			background-color: #01a0dc;
			background: -webkit-linear-gradient(to bottom, #01a0dc 0%, #01a0dc 100%);
			background: -moz-linear-gradient(to bottom, #01a0dc 0%, #01a0dc 100%);
			background: linear-gradient(to bottom, #01a0dc 0%, #01a0dc 100%);
		}

		/* counter section */
		.counter-section.style-two .inner-container {

			background: #f0faff;
			background: -webkit-linear-gradient(to bottom, #f0faff 0%, #f0faff 100%);
			background: -moz-linear-gradient(to bottom, #f0faff 0%, #f0faff 100%);
			background: linear-gradient(to bottom, #f0faff 0%, #f0faff 100%);
			background: linear-gradient(to bottom, #f0faff 0%, #f0faff 100%);
		}

		.fact-counter .column .inner .count-outer {
			color: #01a0dc;
		}

		.fact-counter .column .inner .counter-title {
			color: #01a0dc;
		}

		.fact-counter .column .inner .content:before {
			color: #01a0dc;
		}

		/* team section css */
		.team-section-two {
			padding: 120px 0px 100px;
		}

		/*projects cutom css*/
		.mixitup-gallery .sec-title {
			text-align: center;
		}

		.tab-content.filter-lists>.active {
			display: flex;
		}

		/* recent project  */
		.recent_project_item_wrapper {
			flex-wrap: wrap;
			transition: all 0.3s ease-in;
			border-radius: 10px
		}

		.recent_project_item_wrapper.row>[class*='col-'] {
			display: flex;
			flex-direction: column;
		}

		.recent_project_item_wrapper .inner-box {
			border-radius: 10px;
			background: #f5f7f8;
			border: 1px solid #f5f7f8;

			padding: 3.125rem;
			height: 100%;
			-webkit-transition: all 0.3s ease-in;
			transition: all 0.3s ease-in;
			overflow: hidden;
		}

		/* .recent_project_item_wrapper.single_item:nth-of-type(odd) .project-image{
    background: #fcb737;
} */
		/* .recent_project_item_wrapper.single_item:nth-of-type(even) .project-image{
    background: #2ebbff;
} */
		/* .recent_project_item_wrapper.single_item:nth-of-type(odd):hover .inner-box {
    border: 1px solid #fcb737;
	background:#fff;
} */
		/* .recent_project_item_wrapper.single_item:nth-of-type(even):hover .inner-box {
    border: 1px solid #2ebbff;
} */
		.recent_project_item_wrapper.single_item .inner-box:hover {

			-webkit-box-shadow: 0 2.76726px 2.21381px rgb(25 51 82 / 2%), 0 6.6501px 5.32008px rgb(25 51 82 / 3%), 0 12.5216px 10.0172px rgb(25 51 82 / 4%), 0 22.3363px 17.869px rgb(25 51 82 / 4%), 0 41.7776px 33.4221px rgb(25 51 82 / 5%), 0 100px 80px rgb(25 51 82 / 7%);
			box-shadow: 0 2.76726px 2.21381px rgb(25 51 82 / 2%), 0 6.6501px 5.32008px rgb(25 51 82 / 3%), 0 12.5216px 10.0172px rgb(25 51 82 / 4%), 0 22.3363px 17.869px rgb(25 51 82 / 4%), 0 41.7776px 33.4221px rgb(25 51 82 / 5%), 0 100px 80px rgb(25 51 82 / 7%);
		}

		.recent_project_item_wrapper.single_item .project-image {
			text-align: center;
			border-top-right-radius: 10px;
			border-bottom-right-radius: 10px;
			border-bottom-left-radius: 0;
			border-top-left-radius: 0;
			overflow: hidden;
		}

		.project_content .lower-content h5 {
			font-size: 16px;
			text-transform: uppercase;
			color: #0c5889;
			margin-bottom: 15px;
		}

		.gallery-logos {
			flex-wrap: wrap;
		}

		.gallery-logos li {
			margin-right: 30px;
			margin-bottom: 20px;
		}

		/* recent product tabs */
		ul.nav.nav-pills.recent-projects {
			justify-content: center;
			margin-bottom: 32px;
			display: none;
		}

		ul.nav.nav-pills.recent-projects li {
			width: 50%;
			text-align: center;
		}

		ul.nav.nav-pills.recent-projects li a {
			font-weight: 500;
			font-size: 16px;
			line-height: 26px;
			letter-spacing: 1px;
			text-transform: capitalize;
			color: #000000;
			opacity: 1;
			box-shadow: 0px 2px 0px #F2F7F1;
			border-radius: 0;
			padding: 15px 0;
		}

		ul.nav.nav-pills.recent-projects li a.active {
			background: transparent;
			color: #01A0DC;
			box-shadow: 0px 2px 0px #01A0DC;
		}

		.gallery-block .inner-box {
			background: #FFFFFF;
			box-shadow: 0px 0px 32px rgba(70, 139, 202, 0.16);
			border-radius: 8px;
			padding: 16px 20px 24px;
		}

		.gallery-block .inner-box .image-box a {
			display: block;
			min-height: 56px;
		}

		.gallery-block .inner-box .image-box img {
			width: auto;
			margin: 0 auto;
		}

		.gallery-block .inner-box .image-box {
			padding: 50px 0 50px 0;
		}

		.pp_price {
			position: absolute;
			top: 0;
			right: 0;
			background: linear-gradient(313.92deg, #08AEEC 10.47%, #20E2AD 90.77%);
			padding: 5px 12px;
			color: #fff;
		}

		.gallery-block .inner-box .title a {
			font-size: 24px;
			line-height: 30px;
			letter-spacing: 0.5px;
			color: #468bca;
			margin-bottom: 4px;
		}

		.gallery-block .inner-box .sub-title {
			font-size: 18px;
			line-height: 26px;
			letter-spacing: 0.5px;
			color: #000000;
			margin-bottom: 24px;
			font-family: "SolaimanLipi", Arial, sans-serif;
			font-weight: 600;
		}

		.gallery-block .inner-box .pp-content p {
			font-family: "SolaimanLipi", Arial, sans-serif;
			font-size: 17px;
			line-height: 27px;
			color: #3D4856;
			text-align: justify;

		}

		.pp-footer a {
			font-weight: 500;
			font-size: 16px;
			line-height: 26px;
			letter-spacing: 1px;
			text-transform: capitalize;
			color: #01A0DC;
			display: flex;
			align-items: center;
			transition: all 0.3s ease-in;
		}

		.pp-footer {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.pp-footer a:hover {
			font-weight: 500;
		}

		.pp-footer a i {
			font-size: 18px;
			line-height: 21px;
			margin-right: 10px
		}

		.pp-footer a i:before {
			content: "\f879";
		}

		/* client testimonial */
		.clients-section li.slide-item h3 {
			padding: 10px;
			color: #202C53;
			font-size: 30px;
			line-height: 40px;
			/* 	font-weight:600; */
			text-align: center;
			cursor: pointer;
			transition: all 0.5s ease-in-out;
			font-family: 'Anek Telugu', sans-serif;
			text-shadow: 2px 7px 5px rgba(0, 0, 0, 0.3),
				0px -4px 10px rgba(255, 255, 255, 0.3);

		}

		.clients-section li.slide-item h3:hover {
			color: #01A0DC;

		}

		.clients-section .owl-carousel.owl-drag .owl-item .slide-item {
			margin-left: 10px;
		}

		/* our blog  */
		.news-block.style-two .inner-box .image .overlay-box {
			display: none;
		}

		.testimonial-block .inner-box .rating {
			color: #3598db;
		}

		.news-block .inner-box .image .overlay-box,
		.sidebar .popular-posts .post .post-thumb .overlay-box {
			background-color: rgb(12 88 137 / 50%);
		}

		.news-block .inner-box .image .overlay-box .icon:hover {
			background-color: #01a0dc;
			color: #ffffff;
		}

		.news-block .inner-box .image .overlay-box .icon {
			color: #3598db;
		}

		.sidebar .popular-posts .post a:hover,
		.news-block .inner-box .lower-content h5 a:hover,
		.sidebar-widget ul li a:hover,
		.author-widget .widget-content .social-box li a:hover {
			color: #01a0dc;
		}

		.sidebar .search-box .form-group button,
		.footer-widget .search-box .form-group button {
			background: #01a0dc;
		}

		.author-widget .widget-content {
			background: #01a0dc !important;
		}

		.sidebar-title h4:before {
			background: url(/wp-content/uploads/2022/02/blue-title-icon.png) no-repeat;

		}

		/* blog css */
		.news-block .inner-box .lower-content .post-meta {
			display: none;
		}

		@media(min-width:1025px) {
			.news-section .sec-title .pull-left {
				width: 80%;
			}
		}

		/* contact form  */
		input[type="submit"].btn-style-three {

			background: -webkit-linear-gradient(to right, #0c5889 0%, #01a0dc 100%);
			background: -moz-linear-gradient(to right, #0c5889 0%, #01a0dc 100%);
			background: linear-gradient(to right, #0c5889 0%, #01a0dc 100%);
		}

		.contact-form .form-group .icon,
		.contact-info-section .info-box .box-inner .icon {
			color: #0777ad;
		}

		.contact-info-section .social-box li a {
			background: #0777ad;
		}

		.contact-info-section .social-box li a:hover {
			background: #01A0DC;
		}

		.contact-form .form-group input[type="text"]:focus,
		.contact-form .form-group input[type="tel"]:focus,
		.contact-form .form-group input[type="email"]:focus,
		.contact-form .form-group textarea:focus {
			border-color: #0777ad;
		}

		/* footer css */
		.back-to-top {
			background: #0c5889;
		}

		.list-style-two li .icon {
			color: #01a0dc;
		}

		.back-to-top::before {
			border-bottom: 20px solid #0c5889;
		}

		.back-to-top::after {
			border-bottom: 20px solid #01a0dc;
		}

		.main-footer.style-three,
		.main-footer {
			background: #F0FAFF;
		}

		.main-footer .footer-widget h4 {
			font-size: 24px;
			font-family: 'Poppins', sans-serif;
		}

		.footer-widget ul li a,
		.footer-widget ul li,
		.footer-widget .textwidget p,
		.main-footer .logo-widget .text {
			font-family: 'Archivo', sans-serif;
		}

		.main-footer .footer-widget h4:before {
			background: #01a0dc;
		}

		.main-footer .logo-widget .text,
		.main-footer .footer-widget h4,
		footer.main-footer ul.menu li a,
		.footer-widget ul li a,
		.footer-widget ul li,
		.footer-widget .textwidget p,
		.main-footer.style-three .list-style-two li .icon {
			color: #333;
		}

		footer.main-footer ul li a:before {
			display: none;
		}

		.copyright {
			color: #333;
		}

		.main-footer .footer-bottom .copyright a {
			color: #478BCA;
		}

		@media (min-width: 768px) and (max-width:991px) {
			.section-padding {
				padding: 60px 40px !important;
			}
		}

		@media (min-width: 992px) {
			.main-footer .widgets-section .footer-column {
				width: 33.33%;
			}
		}

		@media (max-width:991px) {
			.main-header {
				background-color: #ffffff;
			}

			.nav-outer .mobile-nav-toggler {
				color: #01a0dc;

			}
		}

		@media(max-width:767px) {
			.main-header .header-upper .auto-container {
				display: flex;
				align-items: center;
			}

			.section-title.elementor-widget .elementor-widget-container .elementor-heading-title,
			.sec-title .title {
				font-size: 30px;
				line-height: 35px;
				text-align: center;
				margin: 0 auto;
				width: 100%;
			}

			.gallery-section {
				padding: 60px 0px 10px;
			}

			.about-section .image-column {

				margin-bottom: 0px;
			}

			.section-padding {
				padding: 40px 20px !important;
			}

			.features-icons .elementor-icon i {
				width: 1em;
				height: 1em;
				margin-top: 20px;
			}

			.main-footer .widgets-section {
				padding: 40px 0px 0px;
			}

			.faq-page-section {
				padding: 0px 0px 40px;
			}

			.testimonial-section,
			.news-section {

				padding: 40px 0px 40px;
			}
		}

		.sticky-header .logo {
			padding: 15px 0px 2px;
		}


		.pricing-plan {
  margin-top: 100px;
  text-align: center;
  position: relative;
}

.pricing-plan h2.title {
  font-weight: bold;
  margin-bottom: 50px;
  font-size: 40px;
}

.pricing-plan .pricing-plan-wrapper .b.highlight-plan .plan header {
  background-color: #ADD8E6; /* Replace $light-blue */
}

.pricing-plan .pricing-plan-wrapper .b.highlight-plan .plan .plan-btn {
  background-image: linear-gradient(to right, #ADD8E6, #D8BFD8); /* Replace $light-blue and $light-purple */
  color: white !important;
}

.pricing-plan .pricing-plan-wrapper .b .plan {
  border: 1px solid #ADD8E6; /* Replace $light-blue */
  border-radius: 20px;
  overflow: hidden;
}

.pricing-plan .pricing-plan-wrapper .b .plan header {
  background-color: #545454;
  color: white;
  height: 100px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.pricing-plan .pricing-plan-wrapper .b .plan header .title {
  margin: 0;
  text-transform: uppercase;
}

.pricing-plan .pricing-plan-wrapper .b .plan ul {
  margin: 20px 0;
  padding: 0;
}

.pricing-plan .pricing-plan-wrapper .b .plan ul li {
  padding: 10px 0;
}

.pricing-plan .pricing-plan-wrapper .b .plan ul li:nth-child(1) {
  font-weight: bold;
  font-size: 25px;
}

.pricing-plan .pricing-plan-wrapper .b .plan .plan-btn {
  margin-bottom: 40px;
  border: none;
  outline: none;
  text-decoration: none;
  border: 1px solid #ADD8E6; /* Replace $light-blue */
  background-color: transparent;
  text-transform: uppercase;
  height: 50px;
  width: 180px;
  line-height: 50px;
  display: inline-block;
  border-radius: 5px;
  color: #ADD8E6; /* Replace $light-blue */
}
.div_btn_middle{
    background-color: #f1f1f1;
    border-radius: 5px;
    padding: 8px;
}
.div_btn_middle a{
    color: #404040;
    text-decoration: none;
}
.div_active{
    background-color: white;
    padding: 7px;
    border-radius: 8px;
    color: #0d0d0d !important;
}
.show_div_2{
    font-weight: bold;
    font-size: 25px;
}
.show_div_2 del{
    color: #9d9d9d;
    font-size: 18px;
}
.yearly_pay{
    margin-top: 18px;
    font-size: 14px;
    text-align: left;
    padding-left: 14%;
}

.contact_title{
	text-align: center; 
	font-size: 40px !important;
	font-weight: bold !important;
	margin-bottom: 50px;
}
	</style>

<style>
  

        /* Button Styles */
        .custom_ds_saas-open-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none !important;
            padding: 15px 30px !important;
            font-size: 18px !important;
            border-radius: 50px !important;
            cursor: pointer !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
        }

        .custom_ds_saas-open-btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .custom_ds_saas-open-btn:active {
            transform: translateY(0) !important;
        }

        /* Modal Styles */
        .custom_ds_saas-modal-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.3s ease !important;
            z-index: 1000 !important;
            backdrop-filter: blur(5px) !important;
        }

        .custom_ds_saas-modal-overlay.active {
            opacity: 1 !important;
            visibility: visible !important;
        }

        .custom_ds_saas-modal-container {
            background: white !important;
            border-radius: 16px !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
            width: 100% !important;
            max-width: 500px !important;
            transform: translateY(50px) scale(0.9) !important;
            opacity: 0 !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .custom_ds_saas-modal-overlay.active .custom_ds_saas-modal-container {
            transform: translateY(0) scale(1) !important;
            opacity: 1 !important;
        }

        .custom_ds_saas-modal-header {
            padding: 25px 30px !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            position: relative !important;
        }

        .custom_ds_saas-modal-title {
            font-weight: 600 !important;
            font-size: 24px !important;
            margin-bottom: 5px !important;
		line-height:unset !important
        }

        .custom_ds_saas-modal-subtitle {
            opacity: 0.9 !important;
            font-size: 14px !important;
        }

        .custom_ds_saas-close-btn {
            position: absolute !important;
            top: 20px !important;
            right: 20px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border: none !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
		padding:unset !important;	
        }

        .custom_ds_saas-close-btn:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: rotate(90deg) !important;
        }

        .custom_ds_saas-close-icon {
            width: 16px !important;
            height: 16px !important;
            fill: white !important;
        }

        .custom_ds_saas-modal-content {
            padding: 30px !important;
        }

        .custom_ds_saas-modal-text {
            color: #555 !important;
            line-height: 1.6 !important;
            margin-bottom: 20px !important;
        }

        /* Select2 Dropdown Styles */
        .custom_ds_saas-outlet-select {
            width: 100% !important;
        }

        .select2-container .custom_ds_saas-outlet-select {
            margin-bottom: 20px !important;
        }

        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            padding: 10px 15px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
            color: #333 !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2) !important;
        }

        .select2-dropdown {
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .select2-results__option {
            padding: 10px 15px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #667eea !important;
        }

        .custom_ds_saas-modal-footer {
            display: flex !important;
            justify-content: flex-end !important;
            padding: 0 30px 30px !important;
            gap: 15px !important;
        }

        .custom_ds_saas-modal-action-btn {
            padding: 12px 24px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            border: none !important;
		font-size: unset !important;
        }

        .custom_ds_saas-cancel-btn {
            background: #f1f1f1 !important;
            color: #555 !important;
        }

        .custom_ds_saas-cancel-btn:hover {
            background: #e0e0e0 !important;
        }

        .custom_ds_saas-confirm-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
        }

        .custom_ds_saas-confirm-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4) !important;
        }

        /* Animation for modal content */
        @keyframes customFadeIn {
            from { opacity: 0 !important; transform: translateY(10px) !important; }
            to { opacity: 1 !important; transform: translateY(0) !important; }
        }

        .custom_ds_saas-modal-content > * {
            animation: customFadeIn 0.5s ease forwards !important;
        }

        .custom_ds_saas-modal-content > *:nth-child(1) { animation-delay: 0.1s !important; }
        .custom_ds_saas-modal-content > *:nth-child(2) { animation-delay: 0.2s !important; }
        .custom_ds_saas-modal-content > *:nth-child(3) { animation-delay: 0.3s !important; }
        .custom_ds_saas-modal-footer { animation: customFadeIn 0.5s ease 0.4s forwards !important; }
    </style>

<style>
        .back-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 12px 25px;
            background-color: #ff1010;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background-color: #d40000;
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        .back-button:active {
            transform: scale(0.95);
        }

        .back-button i {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .back-button:hover i {
            transform: translateX(-3px);
        }
    </style>
    
	<script src="<?php echo base_url()?>assets/landing/saas_new/wp-emoji-release.min.js.download" defer=""></script>
	<script src="<?php echo base_url(); ?>frequent_changing/notify/toastr.js"></script>
	<link href="<?php echo base_url(); ?>frequent_changing/notify/toastr.css" rel="stylesheet" type="text/css" />	
</head>


<body
	class="page-template-default page page-id-3409 wp-custom-logo menu-layer elementor-default elementor-kit-5 elementor-page elementor-page-3409 e--ua-blink e--ua-chrome e--ua-webkit"
	__processed_93483d10-524f-4e2b-a234-de0e3cf6fdba__="true"
	bis_register=""
	data-elementor-device-mode="desktop" data-new-gr-c-s-check-loaded="14.1215.0" data-gr-ext-installed="">


	<input type="hidden" id="base_url_ajax" value="<?php echo base_url()?>">
<input type="hidden" name="hidden_alert" id="hidden_alert" class="hidden_alert"
       value="<?php echo lang('alert'); ?>!">
<input type="hidden" name="hidden_ok" id="hidden_ok" class="hidden_ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" name="package_type" id="package_type" class="package_type" value="1">
<input type="hidden" name="update_plan" id="update_plan" class="update_plan" value="<?php echo escape_output($update_plan)?>">


	<div class="" bis_skin_checked="1">
		<div class="page-wrapper hidden-bar-wrapper   " bis_skin_checked="1">


			<!-- Main Header-->
			<header class="main-header">
				<!--Header-Upper-->
				<div class="header-upper" bis_skin_checked="1">
					<div class="auto-container clearfix" bis_skin_checked="1">
						<div class="pull-left logo-box" bis_skin_checked="1">
							<div class="logo" bis_skin_checked="1"><a href="<?php echo base_url()?>" title=""><img
										src="<?php echo escape_output($system_logo)?>" alt="logo"></a></div>
						</div>

						<div class="nav-outer clearfix" bis_skin_checked="1">
							<!--Mobile Navigation Toggler-->
							<div class="mobile-nav-toggler" bis_skin_checked="1"><span
									class="icon flaticon-menu"></span></div>

							<!-- Main Menu -->
							<nav class="main-menu navbar-expand-md">
								 
								<div class="navbar-collapse collapse clearfix" id="navbarSupportedContent"
									bis_skin_checked="1">
									<ul class="navigation clearfix">
										<li id="menu-item-24"
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Home" href="<?php echo base_url()?>" class="hvr-underline-from-left1"
												data-scroll="" data-options="easing: easeOutQuart">Home</a>
										</li>
										<li
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Features" href="#features" class="hvr-underline-from-left1"
												data-scroll="" data-options="easing: easeOutQuart">Features</a>
										</li>
										<li
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Customer Review" href="#customer_review" class="hvr-underline-from-left1"
												data-scroll="" data-options="easing: easeOutQuart">Customer Review</a>
										</li>
										 
										<li
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Pricing" href="#pricing" class="hvr-underline-from-left1"
												data-scroll="" data-options="easing: easeOutQuart">Pricing</a>
										</li>
										 
										<li
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Online Order" href="#" class="hvr-underline-from-left1 setOnlineOrder">Online Order</a>
										</li>
										<li
											class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-24">
											<a title="Reservation" href="<?php echo base_url()?>reservation" class="hvr-underline-from-left1"
												data-scroll="" data-options="easing: easeOutQuart">Reservation</a>
										</li>
										 
									
										<li id="menu-item-1859"
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1859">
											<a title="Contact Us" href="#contact_us"
												class="hvr-underline-from-left1" data-scroll=""
												data-options="easing: easeOutQuart">Contact Us</a>
										</li>
									</ul>
								</div>
							</nav>

							<!-- Main Menu End-->
							<div class="outer-box clearfix" bis_skin_checked="1">

							</div>
						</div>
					</div>
				</div>
				<!--End Header Upper-->

				<!-- Sticky Header  -->
				<div class="sticky-header" bis_skin_checked="1">
					<div class="auto-container clearfix" bis_skin_checked="1">
						<!--Logo-->
						<div class="logo pull-left" bis_skin_checked="1">
						<a href="<?php echo base_url()?>" title=""><img
						src="<?php echo escape_output($system_logo)?>" alt="logo"></a>
						</div>
						<!--Right Col-->
						<div class="pull-right" bis_skin_checked="1">
							<!-- Main Menu -->
							<nav class="main-menu">
								<!--Keep This Empty / Menu will come through Javascript-->

								<div class="navbar-header" bis_skin_checked="1">
									<!-- Toggle Button -->
									<button class="navbar-toggler" type="button" data-toggle="collapse"
										data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
										aria-expanded="false" aria-label="Toggle navigation">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>
 
								<!-- Main Menu End-->
								<!-- Main Menu End-->
								<div class="outer-box clearfix" bis_skin_checked="1">

								</div>
						</div>
					</div>
				</div><!-- End Sticky Menu -->

				<!-- Mobile Menu  -->
				<div class="mobile-menu" bis_skin_checked="1">
					<div class="menu-backdrop" bis_skin_checked="1"></div>
					<div class="close-btn" bis_skin_checked="1"><span class="icon flaticon-multiply"></span></div>
					<nav class="menu-box mCustomScrollbar _mCS_1 mCS_no_scrollbar">
						<div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside"
							style="max-height: 678px;" tabindex="0" bis_skin_checked="1">
							<div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y"
								style="position:relative; top:0; left:0;" dir="ltr" bis_skin_checked="1">
								<div class="nav-logo" bis_skin_checked="1"><a href="<?php echo base_url()?>" title=""><img
								src="<?php echo escape_output($system_logo)?>" alt="logo"></a></div>
								<div class="menu-outer" bis_skin_checked="1">
									<!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
									<div class="navbar-header" bis_skin_checked="1">
										</ul>
									</div>
								</div>
							</div>
							<div id="mCSB_1_scrollbar_vertical"
								class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical"
								style="display: none;" bis_skin_checked="1">
								<div class="mCSB_draggerContainer" bis_skin_checked="1">
									<div id="mCSB_1_dragger_vertical" class="mCSB_dragger"
										style="position: absolute; min-height: 30px; height: 0px; top: 0px;"
										oncontextmenu="return false;" bis_skin_checked="1">
										<div class="mCSB_dragger_bar" bis_skin_checked="1" style="line-height: 30px;">
										</div>
										<div class="mCSB_draggerRail" bis_skin_checked="1"></div>
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div><!-- End Mobile Menu -->
			</header>
			<!-- End Main Header -->


			<!-- sidebar-page-container -->
			<section class="sidebar-page-container sec-pad-2 blog-standard">
				<div class="">
				<div class="auto-container-" bis_skin_checked="1">
					<div class="row clearfix" bis_skin_checked="1">

						<div class="content-side col-xs-12 col-sm-12 col-md-12" bis_skin_checked="1">
							<div class="thm-unit-test" bis_skin_checked="1">

								<div data-elementor-type="wp-page" data-elementor-id="3409"
									class="elementor elementor-3409" bis_skin_checked="1">
									<div class="main_banner">
										<div class="main_banner_inner">
											<div class="left_part_banner">
												<h1><?php echo escape_output($site_name)?></h1>
											</div>
											<div class="row">
												<div class="col-md-6">
													<ul class="left_side_list">
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Even if the internet goes down, the POS stays on</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Order cancel and delete report to prevent fraud</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Records of wasted raw materials to prevent fraud</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Daily A-Z Report, Item Analysis Report, Profit/Loss Analysis</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Customer Self Order System via QR Code</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Free Waiter App, Online Ordering, Floor Plan Design</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Recipe Management, Food Cost Calculation, Stock Auto Deduct</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Stock and Stock Alerts, Powerful POS</li>
														<li><span><i class="fas fa-chevron-circle-right"></i></span> Premade production and stock as well as premade food used in the preparation of other foods</li>
													</ul>
													<div class="call_email">
														<a class="first_call" href="tel:<?php echo escape_output($phone)?>"> <span><i class="fas fa-phone-alt"></i></span> <?php echo escape_output($phone)?></a>
														<a href="mailto:<?php echo escape_output($email)?>"> <span><i class="fas fa-envelope"></i></span> <?php echo escape_output($email)?></a>
													</div>
													<div class="signup_login">
														<a class="active_btn" href="<?php echo base_url()?>#pricing">Sign Up Here</a>
														<a class="def_btn" href="<?php echo base_url()?>Authentication">Login</a>
													</div>
												</div>
												<div class="col-md-6">
													<div class="banner_slider">
														<div class="hero_area bg_2" 
															role="img" aria-label="Banner Image">
															<img src="<?php echo base_url('assets/landing/saas_new/Even-if-the-internet-goes-down-the-POS-stays-on-1.png') ?>" alt="">
														</div>
														<div class="hero_area bg_2" 
															role="img" aria-label="Banner Image">
															<img src="<?php echo base_url('assets/landing/saas_new/Order-cancel-and-delete-report-to-prevent-fraud.png') ?>" alt="">
														</div>
														<div class="hero_area bg_2" 
															role="img" aria-label="Banner Image">
															<img src="<?php echo base_url('assets/landing/saas_new/Daily A-Z Report.png') ?>" alt="">
														</div>
														<div class="hero_area bg_2" 
															role="img" aria-label="Banner Image">
															<img src="<?php echo base_url('assets/landing/saas_new/Customer-Self-Order-System-via-QR-Code.png') ?>" alt="">
														</div> 
														<div class="hero_area bg_2" 
															role="img" aria-label="Banner Image">
															<img src="<?php echo base_url('assets/landing/saas_new/Floor-Plan-Design.png') ?>" alt="">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-64054646 elementor-hidden-desktop elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="64054646" data-element_type="section"
										data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6a421f02"
												data-id="6a421f02" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-d5a1a62 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="d5a1a62" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-5916738a"
																data-id="5916738a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-77c9c6a1 elementor-widget elementor-widget-heading"
																		data-id="77c9c6a1" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h1
																				class="elementor-heading-title elementor-size-default">
																				বিডি-রেস্তোরা (রেস্টুরেন্ট ম্যানেজমেন্ট
																				সফটওয়্যার)</h1>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1814c2c9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1814c2c9" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-a6581f9"
																data-id="a6581f9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-469539e8 elementor-widget elementor-widget-heading"
																		data-id="469539e8" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h2
																				class="elementor-heading-title elementor-size-default">
																				মূল্য মাত্র ১২০০০ টাকা (এককালীন)
																			</h2>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-4ef8f31d elementor-widget elementor-widget-text-editor"
																		data-id="4ef8f31d" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p><span style="font-weight: 400;">ইন্টারনেট
																					চলে গেলেও সফটওয়্যার চালু থাকে,
																					রেসিপি ম্যানেজমেন্ট, রেসিপি অনুযায়ী
																					খাবার তৈরির ব্যয় অটো ক্যালকুলেশন,
																					খাবার সেল হলে রেসিপি অনুযায়ী
																					কাঁচামালের স্টক অটো কমে যায়, QR
																					কোডের মাধ্যমে কাস্টমার নিজেই অর্ডার
																					প্লেস করতে পারে, ফ্রি ওয়েটার অ্যাপ,
																					রানিং অর্ডার প্যানেল, অনলাইন
																					অর্ডারিং, কাঁচামালের স্টক এবং স্টক
																					এ্যালার্ট, অনলাইন টেবিল রিজার্ভেশন,
																					খাবার আগে এবং পরে দুইভাবেই বিল
																					পরিশোধের ব্যবস্থা, কাঁচামালের ডাবল
																					ইউনিট ফিচার(e.g: 3Kg 600g),
																					মাইগ্রেশন ইজি সফটওয়্যার, প্রোডাক্ট
																					ভেরিয়েশন, ডাইন-ইন এবং ডেলিভারির
																					আলাদা মূল্য নির্ধারন, টেবিল এবং
																					এরিয়া ম্যানেজমেন্ট, টপিংস/নোট,
																					সার্ভিস এবং ডেলিভারি চার্জ
																					কনফিগারেশন, পাওয়ারফুল POS, ফুড
																					কম্বো, প্রমোশন এবং ডিসকাউন্ট,
																					ক্যাটাগরি অনুযায়ী KOT প্রিন্টার,
																					ক্যাটাগরি অনুযায়ী কিচেন প্যানেল –
																					KDS, ডেলিভারি ম্যানেজমেন্ট, স্প্লিট
																					বিল, প্রিমেইড প্রডাকশন এবং স্টক সেই
																					সাথে প্রিমেইড ফুড অন্য ফুড তৈরীতে
																					ব্যবহার করা, এসএমএস ইন্টিগ্রেশন,
																					অর্ডার ক্যানসেল এবং ডিলিট লগ, Z
																					রিপোর্ট, নষ্ট হওয়া কাঁচামাল
																					ট্র্যাকিং, আইটেম এনালাইসিস
																					রিপোর্ট</span><span
																					style="font-weight: 400;">,
																				</span><span
																					style="font-weight: 400;">কাস্টমার
																					ডিসপ্লে</span><span
																					style="font-weight: 400;">,</span><span
																					style="font-weight: 400;"> অর্ডার
																					স্ট্যাটাস স্ক্রীন, একটি বিক্রয়ে
																					একাধিক পেমেন্ট(ক্যাশ, কার্ড, বিকাশ
																					etc), স্টক ট্রান্সফার, স্টক
																					এডজাস্টমেন্ট, কাস্টমার প্রোফাইল,
																					কাস্টমার লয়্যালটি পয়েন্ট, কাস্টমার
																					বকেয়া ট্র্যাকিং, কাঁচামাল ক্রয়,
																					সাপ্লাইয়ার বকেয়া ট্র্যাকিং, ব্যয়
																					ট্র্যাকিং, ক্যাশ রেজিস্টার, কর্মচারী
																					ম্যানেজমেন্ট এবং হাজিরা, প্রফিট/লস
																					রিপোর্ট, বিজনেস ইন্টেলিজেন্স
																					ড্যাশবোর্ড</span></p>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3d34de4b elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
																		data-id="3d34de4b" data-element_type="widget"
																		data-widget_type="icon-list.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<ul class="elementor-icon-list-items">
																				<li class="elementor-icon-list-item">
																					<a href="tel:<?php echo escape_output($phone)?>">

																						<span
																							class="elementor-icon-list-icon">
																							<i aria-hidden="true"
																								class="fas fa-phone-alt"></i>
																						</span>
																						<span
																							class="elementor-icon-list-text"><?php echo escape_output($phone)?></span>
																					</a>
																				</li>
																				<li class="elementor-icon-list-item">
																					<a href="mailto:<?php echo escape_output($email)?>">

																						<span
																							class="elementor-icon-list-icon">
																							<i aria-hidden="true"
																								class="fas fa-envelope"></i>
																						</span>
																						<span
																							class="elementor-icon-list-text">Email:
																							<?php echo escape_output($email)?></span>
																					</a>
																				</li>
																			</ul>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3205b623 elementor-mobile-align-justify elementor-widget__width-auto elementor-widget-tablet__width-inherit elementor-tablet-align-justify elementor-widget elementor-widget-button"
																		data-id="3205b623" data-element_type="widget"
																		data-widget_type="button.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<div class="elementor-button-wrapper"
																				bis_skin_checked="1">
																				<a class="elementor-button elementor-button-link elementor-size-sm"
																					href="<?php echo base_url()?>#featured">
																					<span
																						class="elementor-button-content-wrapper">
																						<span
																							class="elementor-button-text">ফিচার
																							দেখুন</span>
																					</span>
																				</a>
																			</div>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-18ae26c2 elementor-mobile-align-justify elementor-widget__width-auto elementor-widget-tablet__width-inherit elementor-tablet-align-justify elementor-widget elementor-widget-button"
																		data-id="18ae26c2" data-element_type="widget"
																		data-widget_type="button.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<div class="elementor-button-wrapper"
																				bis_skin_checked="1">
																				<a class="elementor-button elementor-button-link elementor-size-sm"
																					href="https://dsbeta.work/demol/bdrestora/"
																					target="_blank">
																					<span
																						class="elementor-button-content-wrapper">
																						<span
																							class="elementor-button-text">ডেমো
																						</span>
																					</span>
																				</a>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1dea3c95"
																data-id="1dea3c95" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7a1bd2ac elementor-widget elementor-widget-image"
																		data-id="7a1bd2ac" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img fetchpriority="high" decoding="async"
																				width="525" height="418"
																				src="<?php echo base_url()?>assets/landing/saas_new/bdrestora_banner.png"
																				class="attachment-full size-full wp-image-3498"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/bdrestora_banner.png 525w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/bdrestora_banner-300x239.png 300w"
																				sizes="(max-width: 525px) 100vw, 525px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
										
									</section>
									
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-3b2da34f elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="3b2da34f" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-7e22f650 animated fadeInLeft"
												data-id="7e22f650" data-element_type="column"
												data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInLeft&quot;}"
												bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<div class="elementor-element elementor-element-3915b2e6 elementor-position-left elementor-view-default elementor-mobile-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
														data-id="3915b2e6" data-element_type="widget"
														data-widget_type="icon-box.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<div class="elementor-icon-box-wrapper"
																bis_skin_checked="1">

																<div class="elementor-icon-box-icon"
																	bis_skin_checked="1">
																	<span class="elementor-icon elementor-animation-">
																		<i aria-hidden="true" class="fas fa-users"></i>
																	</span>
																</div>

																<div class="elementor-icon-box-content"
																	bis_skin_checked="1">

																	<h4 class="elementor-icon-box-title">
																		<span>
																			1250+ international restaurant Client
																		</span>
																	</h4>


																</div>

															</div>
														</div>
													</div>
												</div>
												
											</div>
											<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-5c9f0788 animated fadeInRight"
												data-id="5c9f0788" data-element_type="column"
												data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInRight&quot;}"
												bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<div class="elementor-element elementor-element-7c36a38e elementor-position-left elementor-tablet-position-left elementor-view-default elementor-mobile-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
														data-id="7c36a38e" data-element_type="widget"
														data-widget_type="icon-box.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<div class="elementor-icon-box-wrapper"
																bis_skin_checked="1">

																<div class="elementor-icon-box-icon"
																	bis_skin_checked="1">
																	<span class="elementor-icon elementor-animation-">
																		<i aria-hidden="true" class="fas fa-star"></i>
																	</span>
																</div>

																<div class="elementor-icon-box-content"
																	bis_skin_checked="1">

																	<h4 class="elementor-icon-box-title">
																		<span>
																			4.37/5 Clients Review </span>
																	</h4>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="customer_review"></div>
									</section>
									
									<section class="customer_review_wrapper">
										<h2 class="recommendation_title">Client Recommendation</h2>
										<div id="features"></div>
										<div class="container">
											<div class="client_review">
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
												<div class="client_review_el"role="img" aria-label="review-image">
													<img src="<?php echo base_url('assets/landing/saas_new/5.png'); ?>" alt="review-img">
												</div>
											</div>
											
										</div>
										
									</section>
									
									<section
										 class="elementor-section elementor-top-section elementor-element elementor-element-e239354 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="e239354" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-987d260"
												data-id="987d260" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<div class="elementor-element elementor-element-880e15e elementor-widget elementor-widget-heading"
														data-id="880e15e" data-element_type="widget"
														data-widget_type="heading.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<h2 class="elementor-heading-title elementor-size-default">
																Key Features</h2>
														</div>
													</div>
													<div class="elementor-element elementor-element-381b0c5 elementor-widget-divider--separator-type-pattern elementor-widget-divider--no-spacing elementor-widget-divider--view-line elementor-widget elementor-widget-divider"
														data-id="381b0c5" data-element_type="widget"
														data-widget_type="divider.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<div class="elementor-divider"
																style="--divider-pattern-url: url(&quot;data:image/svg+xml,%3Csvg xmlns=&#39;http://www.w3.org/2000/svg&#39; preserveAspectRatio=&#39;xMidYMid meet&#39; overflow=&#39;visible&#39; height=&#39;100%&#39; viewBox=&#39;0 0 120 26&#39; fill=&#39;black&#39; stroke=&#39;none&#39;%3E%3Cpolygon points=&#39;0,14.4 0,21 11.5,12.4 21.3,20 30.4,11.1 40.3,20 51,12.4 60.6,20 69.6,11.1 79.3,20 90.1,12.4 99.6,20 109.7,11.1 120,21 120,14.4 109.7,5 99.6,13 90.1,5 79.3,14.5 71,5.7 60.6,12.4 51,5 40.3,14.5 31.1,5 21.3,13 11.5,5 	&#39;/%3E%3C/svg%3E&quot;);"
																bis_skin_checked="1">
																<span class="elementor-divider-separator">
																</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-18b0beb9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="18b0beb9" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-6f590aa9"
												data-id="6f590aa9" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-466b4d8e elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="466b4d8e" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7e5dc5b5"
																data-id="7e5dc5b5" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5f2e3b4d elementor-widget elementor-widget-image"
																		data-id="5f2e3b4d" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img decoding="async" width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/01.-Offline-sync-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3438"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-30b3f707"
																data-id="30b3f707" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-23450085 elementor-widget elementor-widget-text-editor"
																		data-id="23450085" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Even if the internet goes down, the POS
																				stays on</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-43979bc"
												data-id="43979bc" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3166b36 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3166b36" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f3b4670"
																data-id="f3b4670" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1ec123b elementor-widget elementor-widget-image"
																		data-id="1ec123b" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img decoding="async" width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/32.-cancel-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3465"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-0d42b7c"
																data-id="0d42b7c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-491136b elementor-widget elementor-widget-text-editor"
																		data-id="491136b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Order Cancel & Delete Log</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-18fb0b8"
												data-id="18fb0b8" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-a612318 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="a612318" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-79b4eb8"
																data-id="79b4eb8" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-bdb0c4c elementor-widget elementor-widget-image"
																		data-id="bdb0c4c" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/32.-erp-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3466"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-erp.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-29d4b3d"
																data-id="29d4b3d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1eca6d1 elementor-widget elementor-widget-text-editor"
																		data-id="1eca6d1" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Z-Report</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-3e55dfc"
												data-id="3e55dfc" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-46574ff elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="46574ff" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5445bc5"
																data-id="5445bc5" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-56bc808 elementor-widget elementor-widget-image"
																		data-id="56bc808" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/34.-medical-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3468"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-ee1f69d"
																data-id="ee1f69d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-caf878e elementor-widget elementor-widget-text-editor"
																		data-id="caf878e" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Item Analysis Report, Profit/Loss
																				Analysis</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-f1c956d elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="f1c956d" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-db026d0"
												data-id="db026d0" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-ed34078 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="ed34078" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-47d710e"
																data-id="47d710e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-09482b4 elementor-widget elementor-widget-image"
																		data-id="09482b4" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/05-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3442"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-a4e66bd"
																data-id="a4e66bd" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-afba5e0 elementor-widget elementor-widget-text-editor"
																		data-id="afba5e0" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customer Self Order System via QR Code
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-ce12d18"
												data-id="ce12d18" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3b7b96b elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3b7b96b" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f244e60"
																data-id="f244e60" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-9287fcb elementor-widget elementor-widget-image"
																		data-id="9287fcb" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/06.-food-delivery-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3443"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c43c194"
																data-id="c43c194" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4ad3323 elementor-widget elementor-widget-text-editor"
																		data-id="4ad3323" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Free waiter app</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-bab07d5"
												data-id="bab07d5" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-240baee elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="240baee" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c0e754e"
																data-id="c0e754e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-0e94c9d elementor-widget elementor-widget-image"
																		data-id="0e94c9d" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/08.-online-order-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3445"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5dd1532"
																data-id="5dd1532" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5f91e01 elementor-widget elementor-widget-text-editor"
																		data-id="5f91e01" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Online Ordering</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-5cf8e14"
												data-id="5cf8e14" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-255d722 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="255d722" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-edd5cf2"
																data-id="edd5cf2" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-c8e6cc0 elementor-widget elementor-widget-image"
																		data-id="c8e6cc0" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/18.-business-management-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3452"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-a5fb9d0"
																data-id="a5fb9d0" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-42e4245 elementor-widget elementor-widget-text-editor"
																		data-id="42e4245" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Floor Plan Design</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-668bc27 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="668bc27" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-b339173"
												data-id="b339173" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-cb721a3 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="cb721a3" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c0254d7"
																data-id="c0254d7" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-9ab0572 elementor-widget elementor-widget-image"
																		data-id="9ab0572" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/02.-recipe-book-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3439"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-9dfb0b8"
																data-id="9dfb0b8" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-72468ce elementor-widget elementor-widget-text-editor"
																		data-id="72468ce" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Recipe Management, Food Cost Calculation,
																				Stock Auto Deduct</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-d36fb03"
												data-id="d36fb03" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-60d2268 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="60d2268" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-937f7e4"
																data-id="937f7e4" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4008436 elementor-widget elementor-widget-image"
																		data-id="4008436" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/09.-ingredients-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3446"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-be98ecd"
																data-id="be98ecd" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3333e19 elementor-widget elementor-widget-text-editor"
																		data-id="3333e19" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Stocks and Stock Alerts</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-1d9e67e"
												data-id="1d9e67e" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-8a02adc elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="8a02adc" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-faca82d"
																data-id="faca82d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-973127c elementor-widget elementor-widget-image"
																		data-id="973127c" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/22.-pos-terminal-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3455"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-923677f"
																data-id="923677f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-83be6d0 elementor-widget elementor-widget-text-editor"
																		data-id="83be6d0" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Powerful POS</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-dfc3c19"
												data-id="dfc3c19" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1b01b08 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1b01b08" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-0c66599"
																data-id="0c66599" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4bb83ab elementor-widget elementor-widget-image"
																		data-id="4bb83ab" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/31.-production-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3464"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-58f5a03"
																data-id="58f5a03" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1672520 elementor-widget elementor-widget-text-editor"
																		data-id="1672520" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Premade production and stock as well as
																				premade food used in the preparation of
																				other foods</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-1497478 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="1497478" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-54fbfaf"
												data-id="54fbfaf" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-aa9393d elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="aa9393d" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7ce8070"
																data-id="7ce8070" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-c0b95c2 elementor-widget elementor-widget-image"
																		data-id="c0b95c2" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/33.-food-waste-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3467"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-97aa505"
																data-id="97aa505" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-b8e2551 elementor-widget elementor-widget-text-editor"
																		data-id="b8e2551" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Tracking Wasted Raw Materials</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8098606"
												data-id="8098606" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-fee22ca elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="fee22ca" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-d7b3cf5"
																data-id="d7b3cf5" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-d686a9f elementor-widget elementor-widget-image"
																		data-id="d686a9f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/36.-order-tracking-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3470"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f94bd1f"
																data-id="f94bd1f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-9f8cc96 elementor-widget elementor-widget-text-editor"
																		data-id="9f8cc96" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Order Status Screen</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-9b671d5"
												data-id="9b671d5" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-0302e64 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="0302e64" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c949fca"
																data-id="c949fca" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5d70492 elementor-widget elementor-widget-image"
																		data-id="5d70492" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/35.-communication-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3469"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-9e30aa1"
																data-id="9e30aa1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2d4adbd elementor-widget elementor-widget-text-editor"
																		data-id="2d4adbd" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customer Display</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-39a7d6b"
												data-id="39a7d6b" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-f05b9ca elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="f05b9ca" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-eeca844"
																data-id="eeca844" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-df8e998 elementor-widget elementor-widget-image"
																		data-id="df8e998" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/kilograms-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3482"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7535248"
																data-id="7535248" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6aec718 elementor-widget elementor-widget-text-editor"
																		data-id="6aec718" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Double unit feature of raw material(e.g:
																				3Kg 600g)</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-85c7df0 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="85c7df0" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-59a21ad"
												data-id="59a21ad" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-15b5293 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="15b5293" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f2e8737"
																data-id="f2e8737" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-0c62e1d elementor-widget elementor-widget-image"
																		data-id="0c62e1d" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/11.-e-payment-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3448"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e438243"
																data-id="e438243" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5329497 elementor-widget elementor-widget-text-editor"
																		data-id="5329497" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Bill payment options both before and
																				after the meal</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-196dd95"
												data-id="196dd95" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1a3fdaa elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1a3fdaa" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e647adc"
																data-id="e647adc" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-65c4a73 elementor-widget elementor-widget-image"
																		data-id="65c4a73" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/07.-order-processed-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3444"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-b26d566"
																data-id="b26d566" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-74b4a94 elementor-widget elementor-widget-text-editor"
																		data-id="74b4a94" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Running Order Panel</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-ae5af2d"
												data-id="ae5af2d" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-51efc71 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="51efc71" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1d196fc"
																data-id="1d196fc" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-04c25c9 elementor-widget elementor-widget-image"
																		data-id="04c25c9" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/10.-reservation-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3447"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c61e2db"
																data-id="c61e2db" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-300709e elementor-widget elementor-widget-text-editor"
																		data-id="300709e" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Online Table Reservation</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-9e3288a"
												data-id="9e3288a" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-e8a09aa elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="e8a09aa" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f45eb30"
																data-id="f45eb30" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-fcedabc elementor-widget elementor-widget-image"
																		data-id="fcedabc" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/13.-data-storage-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3450"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6826b32"
																data-id="6826b32" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-49ce615 elementor-widget elementor-widget-text-editor"
																		data-id="49ce615" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Migration Easy Software</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-1e22cd9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="1e22cd9" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-4650417"
												data-id="4650417" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3edec73 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3edec73" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f3e16b1"
																data-id="f3e16b1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-b59130f elementor-widget elementor-widget-image"
																		data-id="b59130f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/16.-product-range-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3449"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-dd3a493"
																data-id="dd3a493" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-51ffa67 elementor-widget elementor-widget-text-editor"
																		data-id="51ffa67" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Product Variation</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-299fcb4"
												data-id="299fcb4" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-d07b215 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="d07b215" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-0d5f17e"
																data-id="0d5f17e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-030a41b elementor-widget elementor-widget-image"
																		data-id="030a41b" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/17.-price-tag-1-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3451"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-12f09e3"
																data-id="12f09e3" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-bd3e8d5 elementor-widget elementor-widget-text-editor"
																		data-id="bd3e8d5" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Separate pricing for Dine-in and Delivery
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8a7b2a4"
												data-id="8a7b2a4" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-edb949b elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="edb949b" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-96162be"
																data-id="96162be" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-e8d3bd2 elementor-widget elementor-widget-image"
																		data-id="e8d3bd2" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/19.-sauce-bottle-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3453"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-76af601"
																data-id="76af601" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-abb5106 elementor-widget elementor-widget-text-editor"
																		data-id="abb5106" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Toppings/Notes</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-1b6ad36"
												data-id="1b6ad36" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-f360c37 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="f360c37" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-a6ee7e9"
																data-id="a6ee7e9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-35390ec elementor-widget elementor-widget-image"
																		data-id="35390ec" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/20.-delivery-man-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3454"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-55d0b58"
																data-id="55d0b58" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-cb98035 elementor-widget elementor-widget-text-editor"
																		data-id="cb98035" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Service and Delivery Charge Configuration
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-2e402d6 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="2e402d6" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-96810d9"
												data-id="96810d9" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-db3c8f8 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="db3c8f8" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-54870a3"
																data-id="54870a3" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3d4f716 elementor-widget elementor-widget-image"
																		data-id="3d4f716" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/23.-business-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3456"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-d2df937"
																data-id="d2df937" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-24bdb39 elementor-widget elementor-widget-text-editor"
																		data-id="24bdb39" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Food Combo</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-7401e10"
												data-id="7401e10" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-4ecdee3 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="4ecdee3" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-54f492d"
																data-id="54f492d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-dfdc8d8 elementor-widget elementor-widget-image"
																		data-id="dfdc8d8" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/24.-shopping-online-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3457"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-dc290aa"
																data-id="dc290aa" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-c147718 elementor-widget elementor-widget-text-editor"
																		data-id="c147718" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Promotion & Discount</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-c93557a"
												data-id="c93557a" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-04acd41 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="04acd41" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-b5eb74f"
																data-id="b5eb74f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-efe028b elementor-widget elementor-widget-image"
																		data-id="efe028b" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/26.-printer-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3459"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-be3fe9c"
																data-id="be3fe9c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-8cc8f1b elementor-widget elementor-widget-text-editor"
																		data-id="8cc8f1b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>KOT Printer by category</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-be0ba7e"
												data-id="be0ba7e" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7a2122f elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7a2122f" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-b68f80e"
																data-id="b68f80e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1b0273a elementor-widget elementor-widget-image"
																		data-id="1b0273a" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/27.-kitchen-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3460"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-0e9f194"
																data-id="0e9f194" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-99e3011 elementor-widget elementor-widget-text-editor"
																		data-id="99e3011" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Kitchen Panels by Category – KDS</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-4371c4f elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="4371c4f" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-c41f97d"
												data-id="c41f97d" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-23d8714 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="23d8714" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-166c61e"
																data-id="166c61e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1d30ce5 elementor-widget elementor-widget-image"
																		data-id="1d30ce5" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/28.-material-management-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3461"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-d63c45b"
																data-id="d63c45b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-78209b6 elementor-widget elementor-widget-text-editor"
																		data-id="78209b6" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Delivery Management</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-2b5a730"
												data-id="2b5a730" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1e16369 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1e16369" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-382e581"
																data-id="382e581" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1ed7e27 elementor-widget elementor-widget-image"
																		data-id="1ed7e27" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/30.-bill-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3462"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e2f7898"
																data-id="e2f7898" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1f5dafc elementor-widget elementor-widget-text-editor"
																		data-id="1f5dafc" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Split Bill</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8bbd50e"
												data-id="8bbd50e" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-19dd331 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="19dd331" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-cc2ef2b"
																data-id="cc2ef2b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-c068702 elementor-widget elementor-widget-image"
																		data-id="c068702" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/sms-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-2282"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4f15288"
																data-id="4f15288" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3e93cd6 elementor-widget elementor-widget-text-editor"
																		data-id="3e93cd6" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>SMS Integration</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-35d9508"
												data-id="35d9508" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-a8707d4 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="a8707d4" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-8f06082"
																data-id="8f06082" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-abf9571 elementor-widget elementor-widget-image"
																		data-id="abf9571" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/payment-method-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3483"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-b917273"
																data-id="b917273" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-727758c elementor-widget elementor-widget-text-editor"
																		data-id="727758c" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Multiple Payments in a Sale(Cash, Card,
																				bKash etc)</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-46abf82 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="46abf82" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-7cfeef1"
												data-id="7cfeef1" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-c2e38df elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="c2e38df" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f6652e9"
																data-id="f6652e9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-e598cfa elementor-widget elementor-widget-image"
																		data-id="e598cfa" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/38.-transfer-data-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3471"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c43de9a"
																data-id="c43de9a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-fa8847b elementor-widget elementor-widget-text-editor"
																		data-id="fa8847b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Stock Transfer</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-4e5f96e"
												data-id="4e5f96e" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-d4bc64c elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="d4bc64c" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e3cfa2f"
																data-id="e3cfa2f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-8f95b77 elementor-widget elementor-widget-image"
																		data-id="8f95b77" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/39.-admin-panel-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3472"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-db04c16"
																data-id="db04c16" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-41f6542 elementor-widget elementor-widget-text-editor"
																		data-id="41f6542" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Stock Adjustment</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-36a3335"
												data-id="36a3335" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1a0e2cd elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1a0e2cd" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f74be3b"
																data-id="f74be3b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-54a4637 elementor-widget elementor-widget-image"
																		data-id="54a4637" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/40.-profile-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3474"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-ac7de41"
																data-id="ac7de41" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-9021e2d elementor-widget elementor-widget-text-editor"
																		data-id="9021e2d" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customer Profile</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-88ac396"
												data-id="88ac396" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-d18b1f9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="d18b1f9" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-feb3174"
																data-id="feb3174" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-9aac776 elementor-widget elementor-widget-image"
																		data-id="9aac776" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/25.-customer-loyalty-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3458"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-37840a1"
																data-id="37840a1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-108dd3f elementor-widget elementor-widget-text-editor"
																		data-id="108dd3f" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customer Loyalty Point</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-a055bff elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="a055bff" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-53251ea"
												data-id="53251ea" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-4b11b77 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="4b11b77" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-cf95d3a"
																data-id="cf95d3a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-ddd02eb elementor-widget elementor-widget-image"
																		data-id="ddd02eb" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/42.-due-date-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3475"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c5f2cda"
																data-id="c5f2cda" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3871084 elementor-widget elementor-widget-text-editor"
																		data-id="3871084" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customer Due Tracking</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-85b00cf"
												data-id="85b00cf" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3cf6570 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3cf6570" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-f112e09"
																data-id="f112e09" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-a91b70c elementor-widget elementor-widget-image"
																		data-id="a91b70c" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/43.-food-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3476"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-bb7909c"
																data-id="bb7909c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-8b61c13 elementor-widget elementor-widget-text-editor"
																		data-id="8b61c13" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Raw material purchase</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-4d391af"
												data-id="4d391af" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-79fbdd7 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="79fbdd7" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-8894777"
																data-id="8894777" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-0e5bb7f elementor-widget elementor-widget-image"
																		data-id="0e5bb7f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/42.-due-date-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3475"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-ad4b825"
																data-id="ad4b825" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-af8fb21 elementor-widget elementor-widget-text-editor"
																		data-id="af8fb21" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Supplier Due Tracking</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8a7b111"
												data-id="8a7b111" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-ce9e11d elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="ce9e11d" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c10e410"
																data-id="c10e410" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-e56495d elementor-widget elementor-widget-image"
																		data-id="e56495d" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/44.-expenses-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3477"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-ee73819"
																data-id="ee73819" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-080b180 elementor-widget elementor-widget-text-editor"
																		data-id="080b180" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Expense Tracking</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-ba5cc13 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="ba5cc13" data-element_type="section">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-2684c41"
												data-id="2684c41" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-52848f9 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="52848f9" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2565e4a"
																data-id="2565e4a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5fea0c5 elementor-widget elementor-widget-image"
																		data-id="5fea0c5" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/45.-cash-register-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3478"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e6dcb53"
																data-id="e6dcb53" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-47cf7df elementor-widget elementor-widget-text-editor"
																		data-id="47cf7df" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Cash Register</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-abcf581"
												data-id="abcf581" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-e1a9d01 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="e1a9d01" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-bb7e95e"
																data-id="bb7e95e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-44f36e3 elementor-widget elementor-widget-image"
																		data-id="44f36e3" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/46.-employee-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3479"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1b8d55c"
																data-id="1b8d55c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-31d63ad elementor-widget elementor-widget-text-editor"
																		data-id="31d63ad" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Employee Management and Attendance</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-a6544f1"
												data-id="a6544f1" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-165c670 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="165c670" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-8df3167"
																data-id="8df3167" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-889a422 elementor-widget elementor-widget-image"
																		data-id="889a422" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="60" height="60"
																				src="<?php echo base_url()?>assets/landing/saas_new/48.-business-intelligence-60x60.png"
																				class="attachment-moko_60x60 size-moko_60x60 wp-image-3481"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence.png 512w"
																				sizes="(max-width: 60px) 100vw, 60px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4523348"
																data-id="4523348" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-a754b0d elementor-widget elementor-widget-text-editor"
																		data-id="a754b0d" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Business Intelligence Dashboard</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>



											
											<div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-84befc2"
												data-id="84befc2" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-ee1f316 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="ee1f316" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-29c2e28"
																data-id="29c2e28" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-517310a"
																data-id="517310a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-326636a6 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
										data-id="326636a6" data-element_type="section" id="featured">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d3c7a5e"
												data-id="d3c7a5e" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<div class="elementor-element elementor-element-d669de elementor-widget elementor-widget-heading"
														data-id="d669de" data-element_type="widget"
														data-widget_type="heading.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<h2 class="elementor-heading-title elementor-size-default">
																Feature
															</h2>
														</div>
													</div>
													<div class="elementor-element elementor-element-542f5e7b elementor-widget-divider--separator-type-pattern elementor-widget-divider--no-spacing elementor-widget-divider--view-line elementor-widget elementor-widget-divider"
														data-id="542f5e7b" data-element_type="widget"
														data-widget_type="divider.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<div class="elementor-divider"
																style="--divider-pattern-url: url(&quot;data:image/svg+xml,%3Csvg xmlns=&#39;http://www.w3.org/2000/svg&#39; preserveAspectRatio=&#39;xMidYMid meet&#39; overflow=&#39;visible&#39; height=&#39;100%&#39; viewBox=&#39;0 0 120 26&#39; fill=&#39;black&#39; stroke=&#39;none&#39;%3E%3Cpolygon points=&#39;0,14.4 0,21 11.5,12.4 21.3,20 30.4,11.1 40.3,20 51,12.4 60.6,20 69.6,11.1 79.3,20 90.1,12.4 99.6,20 109.7,11.1 120,21 120,14.4 109.7,5 99.6,13 90.1,5 79.3,14.5 71,5.7 60.6,12.4 51,5 40.3,14.5 31.1,5 21.3,13 11.5,5 	&#39;/%3E%3C/svg%3E&quot;);"
																bis_skin_checked="1">
																<span class="elementor-divider-separator">
																</span>
															</div>
														</div>
													</div>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-406fdb1e section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="406fdb1e" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-52e87115"
																data-id="52e87115" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5b9fca83 elementor-widget elementor-widget-heading"
																		data-id="5b9fca83" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Even if the internet goes down, the POS
																				stays on
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3612b084 elementor-widget elementor-widget-text-editor"
																		data-id="3612b084" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is no fear of POS shutdown if the
																				internet suddenly goes down. Even if the
																				internet goes down, this POS will
																				continue to run offline and save all
																				data. As a result, sales will not stop.
																				Later, when the Internet comes, all the
																				data will be automatically uploaded
																				online again.<br><strong>Note: The
																					system automatically detects when
																					the internet goes out and comes back
																					on.</strong></p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-26520fc6"
																data-id="26520fc6" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-211e23a8 elementor-widget elementor-widget-image"
																		data-id="211e23a8" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/01.-Offline-sync.png"
																				class="attachment-full size-full wp-image-3438"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/01.-Offline-sync-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-68838a8f section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="68838a8f" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-12e3dfb3"
																data-id="12e3dfb3" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6f38364 elementor-widget elementor-widget-image"
																		data-id="6f38364" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/32.-cancel.png"
																				class="attachment-full size-full wp-image-3465"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/32.-cancel-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-55f9f5c8"
																data-id="55f9f5c8" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-35d3eff9 elementor-widget elementor-widget-heading"
																		data-id="35d3eff9" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Order Cancel and Delete Log Facility
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-39a025ab elementor-widget elementor-widget-text-editor"
																		data-id="39a025ab" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Restaurant employees often commit fraud
																				by deleting sales records or showing
																				sales cancellations. Order cancellation
																				and order deletion reports are there to
																				prevent these frauds. Admins can view
																				these reports, and reports can be
																				filtered by date or user information,
																				which is helpful in preventing losses in
																				restaurants.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-a5ee01a section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="a5ee01a" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6a1e7fd9"
																data-id="6a1e7fd9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2cd8a86b elementor-widget elementor-widget-heading"
																		data-id="2cd8a86b" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Daily A-Z Report</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-7c462226 elementor-widget elementor-widget-text-editor"
																		data-id="7c462226" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>A Z-report is a summary of all financial
																				transactions for a specific day. Through
																				this, the admin can view the details of
																				all transactions for a specific day at
																				once. Such as sales reports, current
																				balance by payment method at the end of
																				the day (eg: Cash, Card, bKash etc),
																				sales reports by item, reports of all
																				types of transactions including
																				Purchase, Expense.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7bd7afc"
																data-id="7bd7afc" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4f6e066 elementor-widget elementor-widget-image"
																		data-id="4f6e066" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/47.-reporting-1.png"
																				class="attachment-full size-full wp-image-3480"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/47.-reporting-1-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-46d1bfbd section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="46d1bfbd" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-cdcaf2d"
																data-id="cdcaf2d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-582b8dcc elementor-widget elementor-widget-image"
																		data-id="582b8dcc" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/34.-medical.png"
																				class="attachment-full size-full wp-image-3468"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/34.-medical-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-bf41a72"
																data-id="bf41a72" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6408cfd5 elementor-widget elementor-widget-heading"
																		data-id="6408cfd5" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Item Analysis Report Facility
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3e98408a elementor-widget elementor-widget-text-editor"
																		data-id="3e98408a" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is an item analysis report, through
																				which you can monitor the current sales
																				or sales trends of the item. In
																				addition, comparative accounting of
																				restaurant profits can be monitored over
																				different time ranges, which helps in
																				making business decisions.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-4c987dd8 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="4c987dd8" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3dd1e507"
																data-id="3dd1e507" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2ad54384 elementor-widget elementor-widget-heading"
																		data-id="2ad54384" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Customer Self Order System via QR Code
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-aa025 elementor-widget elementor-widget-text-editor"
																		data-id="aa025" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>After generating a separate QR code for
																				each table, it can be printed and placed
																				on the table. The customer will be able
																				to order the food of their choice by
																				scanning the QR code with their phone.
																				This facility allows the restaurant to
																				operate with fewer waiters and reduces
																				waiter costs. By ordering through QR
																				code, cashier will get notification and
																				can accept or cancel, customer can ask
																				for new food by QR code.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6486db2"
																data-id="6486db2" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-664372f4 elementor-widget elementor-widget-image"
																		data-id="664372f4" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/05.png"
																				class="attachment-full size-full wp-image-3442"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/05-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3221c81c section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3221c81c" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-322aed65"
																data-id="322aed65" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-699210a6 elementor-widget elementor-widget-image"
																		data-id="699210a6" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/06.-food-delivery.png"
																				class="attachment-full size-full wp-image-3443"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/06.-food-delivery-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-19953394"
																data-id="19953394" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-74393ef7 elementor-widget elementor-widget-heading"
																		data-id="74393ef7" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Free Waiter App
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-434e5296 elementor-widget elementor-widget-text-editor"
																		data-id="434e5296" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>A waiter app with the restaurant's own
																				brand logo is provided for free. Using
																				the app, the waiter can go to the
																				customer and take the order in a very
																				short time. Which will immediately go to
																				the cashier and kitchen. This process
																				saves time in taking the order and there
																				is no possibility of mistakes.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-214e4b80 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="214e4b80" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3fcafad0"
																data-id="3fcafad0" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-70eb5285 elementor-widget elementor-widget-heading"
																		data-id="70eb5285" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Online Ordering
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-7da80289 elementor-widget elementor-widget-text-editor"
																		data-id="7da80289" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customers will be able to place their own
																				orders online. In this case, the
																				customer can set the date, time, food,
																				etc. according to his needs. Cashier
																				Get notification of that and call
																				Confirm order and send delivery
																				Can arrange. Besides, customers
																				Registration facility is available to
																				all customers
																				Order history is saved.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-688c7532"
																data-id="688c7532" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-551b3a6f elementor-widget elementor-widget-image"
																		data-id="551b3a6f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/08.-online-order.png"
																				class="attachment-full size-full wp-image-3445"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/08.-online-order-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-76092ac9 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="76092ac9" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-554f4456"
																data-id="554f4456" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-471b55e6 elementor-widget elementor-widget-image"
																		data-id="471b55e6" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/18.-business-management.png"
																				class="attachment-full size-full wp-image-3452"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/18.-business-management-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-21b006a2"
																data-id="21b006a2" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7f0237be elementor-widget elementor-widget-heading"
																		data-id="7f0237be" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Floor Plan Design
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3f04127b elementor-widget elementor-widget-text-editor"
																		data-id="3f04127b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is an innovative floor plan design
																				system. With this feature, the
																				restaurant floor can be designed exactly
																				as it looks through the software, and
																				the number of tables with the same
																				number of seats can be designed. Later,
																				orders can be placed by quickly
																				selecting a table from the layout on the
																				POS table selection screen.
																				Any moment can be said
																				The table is empty and in some
																				The customer is sitting. When the meal
																				is over, the invoice can be selected and
																				invoiced.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-4369e308 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="4369e308" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-54902611"
																data-id="54902611" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-24dee60b elementor-widget elementor-widget-heading"
																		data-id="24dee60b" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Recipe Management, Food Cost Calculation, Stock Auto Deduct</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-30736156 elementor-widget elementor-widget-text-editor"
																		data-id="30736156" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>The amount of raw materials to be used in preparing food (which is basically called a recipe) can be set while adding the food menu, and there is also the facility to set the unit in which the raw materials will be used. The system automatically calculates the cost of the raw materials to be used in the food recipe. And based on this, the total cost of the recipe can be calculated. The price of the food can be easily determined by looking at the price of the recipe. Since the recipe of each food can be set, due to which the stock of raw materials will be automatically reduced according to the recipe when the food is sold. As a result, there is no need to subtract raw materials from the stock separately and an error-free calculation is obtained.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-12cc3309"
																data-id="12cc3309" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5019c843 elementor-widget elementor-widget-image"
																		data-id="5019c843" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/02.-recipe-book.png"
																				class="attachment-full size-full wp-image-3439"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/02.-recipe-book-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-5142389 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="5142389" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-279b51f4"
																data-id="279b51f4" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2825398b elementor-widget elementor-widget-image"
																		data-id="2825398b" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/09.-ingredients.png"
																				class="attachment-full size-full wp-image-3446"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/09.-ingredients-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-29dc8fb5"
																data-id="29dc8fb5" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-22d53cae elementor-widget elementor-widget-heading"
																		data-id="22d53cae" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Raw Material Stock and Low Stock Alert
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3dfafa09 elementor-widget elementor-widget-text-editor"
																		data-id="3dfafa09" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Stock will auto update when new raw material is purchased, food item is made, item is sold, raw material is transferred or destroyed. In addition, if the quantity of any raw material decreases, it will be displayed in the form of a Low alert in the stock notification.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-54b0e745 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="54b0e745" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-51d7092e"
																data-id="51d7092e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6ad5e64b elementor-widget elementor-widget-heading"
																		data-id="6ad5e64b" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Powerful POS</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-69635c02 elementor-widget elementor-widget-text-editor"
																		data-id="69635c02" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>State-of-the-art POS feature that can process orders even when the internet is down and allows you to view all types of items with a single click, view and export register information, and add and remove items from running orders. Also Dine-in, Take Away, Delivery Management, Select Table by Viewing Floor Plan, Preparation Notes on Items, KOT Print with Toppings Add, and Kitchen Screen. Payment can be made using loyalty points along with a bill payment through cash and bKash. Facility to retain customer dues and pay later. System to view order cancellation or deletion and accept or reject the order yourself.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-26264a16"
																data-id="26264a16" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-70fc0a8f elementor-widget elementor-widget-image"
																		data-id="70fc0a8f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/22.-pos-terminal.png"
																				class="attachment-full size-full wp-image-3455"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/22.-pos-terminal-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7ee0e572 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7ee0e572" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7b1a614c"
																data-id="7b1a614c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6dcea565 elementor-widget elementor-widget-image"
																		data-id="6dcea565" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/31.-production-300x300.png"
																				class="attachment-medium size-medium wp-image-3464"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/31.-production.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-20b38b88"
																data-id="20b38b88" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7d017462 elementor-widget elementor-widget-heading"
																		data-id="7d017462" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Premade food production and stock as well as use of premade food in other food production
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-7ae27cb2 elementor-widget elementor-widget-text-editor"
																		data-id="7ae27cb2" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Many food items require some items to be pre-made. For example: Beef Tikka for burgers, Pizza dough, Kebab skewers, etc., which are called premade food. The software has a facility to add such premade food along with recipes. There is a facility for production of all these premade food. When production is done, the related raw materials are reduced according to the recipe and the premade food stock increases. Later, that premade food can also be used to make any made food and when that main food is sold, the premade food stock decreases.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-e0b1288 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="e0b1288" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-481b4e66"
																data-id="481b4e66" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6ded2658 elementor-widget elementor-widget-heading"
																		data-id="6ded2658" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Facility to view records of wasted raw materials</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-443707ca elementor-widget elementor-widget-text-editor"
																		data-id="443707ca" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>It is a common problem in restaurants that employees forge raw materials and say that they are spoiled. To prevent this, there is a record facility for spoiled raw materials. As a result, a record of how much raw material is available, how much raw material has been used, and how much has been spoiled can be regularly monitored. If any raw material is spoiled, it is automatically reduced from the stock and added to the loss account. By regularly monitoring this account, fraud can be prevented in restaurants.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-854fb20"
																data-id="854fb20" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-43f73a4f elementor-widget elementor-widget-image"
																		data-id="43f73a4f" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/33.-food-waste.png"
																				class="attachment-full size-full wp-image-3467"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/33.-food-waste-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-5599f9d9 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="5599f9d9" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-697b3d6f"
																data-id="697b3d6f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1d4cf774 elementor-widget elementor-widget-image"
																		data-id="1d4cf774" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/36.-order-tracking.png"
																				class="attachment-full size-full wp-image-3470"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/36.-order-tracking-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-649238e8"
																data-id="649238e8" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-c634332 elementor-widget elementor-widget-heading"
																		data-id="c634332" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Order Status Screen</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3fe75767 elementor-widget elementor-widget-text-editor"
																		data-id="3fe75767" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>An order status screen can be easily set up within the customer's line of sight. As soon as an order is placed, it will be displayed on the screen in the Ongoing Orders section. Then, when the order is ready in the kitchen, it will be displayed in the Ready section, and the customer will be able to go up and get the food from the serving section.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-69933c5f section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="69933c5f" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-293eac3a"
																data-id="293eac3a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-589bdd0c elementor-widget elementor-widget-heading"
																		data-id="589bdd0c" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Customer Display Facility</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-26175bc0 elementor-widget elementor-widget-text-editor"
																		data-id="26175bc0" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p><span style="font-weight: 400;">There is a customer-friendly display function that is very easy to set up for customers. It helps customers see what items a cashier is adding to the cart, how many, and what the total bill is during billing.</span></p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2451ff77"
																data-id="2451ff77" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-527aeaba elementor-widget elementor-widget-image"
																		data-id="527aeaba" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/35.-communication.png"
																				class="attachment-full size-full wp-image-3469"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/35.-communication-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3b5be400 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3b5be400" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3bdeecf"
																data-id="3bdeecf" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-41ad5668 elementor-widget elementor-widget-image"
																		data-id="41ad5668" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/kilograms.png"
																				class="attachment-full size-full wp-image-3482"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/kilograms-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-156f703"
																data-id="156f703" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1c7d94f9 elementor-widget elementor-widget-heading"
																		data-id="1c7d94f9" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Double unit feature of raw material</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-b4fe752 elementor-widget elementor-widget-text-editor"
																		data-id="b4fe752" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There are two ways to add raw materials in a restaurant. First, the purchase unit of raw materials and the unit used to prepare food are the same, for example: if a raw material is purchased in Kg units and used in preparing food in Kg units, this will reduce the raw material from stock to consumption units as Kg. Second, the purchase unit of raw materials and the unit used to prepare food may be different, for example: if a raw material is purchased in dozen units and used in preparing food in piece units. In this case, there is a system to set the conversion rate, which will reduce the raw material from stock to pieces of the unit used to prepare food. For example: 2 dozen were purchased and used as pieces where the conversion rate is 12. Then, if 2 food menus are served, the raw material stock will show 1 dozen and 10 pieces.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-724d09e9 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="724d09e9" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5847c10d"
																data-id="5847c10d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-199034d8 elementor-widget elementor-widget-heading"
																		data-id="199034d8" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Two types of bill payment systems: Pay First and Pay After Meal</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-592e9651 elementor-widget elementor-widget-text-editor"
																		data-id="592e9651" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p><span style="font-weight: 400;">Customers can pay before the meal (Pay First) and after the meal. This makes it suitable for Pay First restaurants as well.</span></p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7fd977f5"
																data-id="7fd977f5" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2fb151b2 elementor-widget elementor-widget-image"
																		data-id="2fb151b2" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/11.-e-payment.png"
																				class="attachment-full size-full wp-image-3448"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/11.-e-payment-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1b927ca0 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1b927ca0" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-17a08852"
																data-id="17a08852" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-35e431fe elementor-widget elementor-widget-image"
																		data-id="35e431fe" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/07.-order-processed.png"
																				class="attachment-full size-full wp-image-3444"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/07.-order-processed-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1364e955"
																data-id="1364e955" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-57d6e3c1 elementor-widget elementor-widget-heading"
																		data-id="57d6e3c1" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Running Order Panel
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3820b84d elementor-widget elementor-widget-text-editor"
																		data-id="3820b84d" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p style="text-align: left;">All the orders that are currently ongoing can be seen in one panel. From there, new food can be added or removed to any order according to the customer's needs. Details of any order can be seen at any time. KOT can be printed for the kitchen and any order can be finalized and billed.
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-49273e11 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="49273e11" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-765ea01c"
																data-id="765ea01c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4d86dd4d elementor-widget elementor-widget-heading"
																		data-id="4d86dd4d" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Online Table Reservation</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-44739ed3 elementor-widget elementor-widget-text-editor"
																		data-id="44739ed3" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Through the website, customers can book tables online and select various information such as the date the table will be booked, at what time, for how many people, etc.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-61effc87"
																data-id="61effc87" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-53fc34c elementor-widget elementor-widget-image"
																		data-id="53fc34c" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/10.-reservation.png"
																				class="attachment-full size-full wp-image-3447"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/10.-reservation-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7543c6a7 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7543c6a7" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-21b2ea9c"
																data-id="21b2ea9c" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-610184a2 elementor-widget elementor-widget-image"
																		data-id="610184a2" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/13.-data-storage.png"
																				class="attachment-full size-full wp-image-3450"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/13.-data-storage-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6a54418"
																data-id="6a54418" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7e350005 elementor-widget elementor-widget-heading"
																		data-id="7e350005" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Migration Easy Software</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-18531362 elementor-widget elementor-widget-text-editor"
																		data-id="18531362" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>All data can be easily transferred from any software. Raw materials, food menus, recipes, customer information can be uploaded in bulk to the software through Excel files. In addition, there is no need to upload data as separate categories, units, the software automatically understands and adds it to the system.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-36f414cf section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="36f414cf" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2e7911b2"
																data-id="2e7911b2" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7ef392e9 elementor-widget elementor-widget-heading"
																		data-id="7ef392e9" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Product/Food Variation</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-4b73875b elementor-widget elementor-widget-text-editor"
																		data-id="4b73875b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>If there are multiple variations of a food, different recipes can be set for each variation. For example, size, flavor, color, etc., and different prices can be set for different variations.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5267c009"
																data-id="5267c009" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-57ac5831 elementor-widget elementor-widget-image"
																		data-id="57ac5831" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/16.-product-range.png"
																				class="attachment-full size-full wp-image-3449"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/16.-product-range-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-729f79dd section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="729f79dd" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-491bd8b0"
																data-id="491bd8b0" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-673745f5 elementor-widget elementor-widget-image"
																		data-id="673745f5" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/17.-price-tag-1.png"
																				class="attachment-full size-full wp-image-3451"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/17.-price-tag-1-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-32ce5247"
																data-id="32ce5247" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5582bef3 elementor-widget elementor-widget-heading"
																		data-id="5582bef3" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Separate pricing facility for Dine In, Take Away & Delivery</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-4d6b42ba elementor-widget elementor-widget-text-editor"
																		data-id="4d6b42ba" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Separate prices can be set for Dine-in, Take Away, and Delivery. If you have multiple delivery partners, you can set different delivery prices for them.
																			</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-5091b395 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="5091b395" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6757f060"
																data-id="6757f060" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1afb378d elementor-widget elementor-widget-heading"
																		data-id="1afb378d" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Toppings - Modifiers - Notes</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-76f55503 elementor-widget elementor-widget-text-editor"
																		data-id="76f55503" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There are item modifiers and text modifiers, as well as the facility to give food preparation notes and the facility to add toppings. Recipes can be set for toppings and based on that, the toppings can be set to be free or priced accordingly.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-48f7df08"
																data-id="48f7df08" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-226e9409 elementor-widget elementor-widget-image"
																		data-id="226e9409" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/19.-sauce-bottle.png"
																				class="attachment-full size-full wp-image-3453"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/19.-sauce-bottle-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-46bcfaf8 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="46bcfaf8" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1bddcfe1"
																data-id="1bddcfe1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-598a5aa3 elementor-widget elementor-widget-image"
																		data-id="598a5aa3" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="512" height="512"
																				src="<?php echo base_url()?>assets/landing/saas_new/20.-delivery-man.png"
																				class="attachment-full size-full wp-image-3454"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man.png 512w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/20.-delivery-man-110x110.png 110w"
																				sizes="(max-width: 512px) 100vw, 512px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-15aa09a0"
																data-id="15aa09a0" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-45d79aa4 elementor-widget elementor-widget-heading"
																		data-id="45d79aa4" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Configuration of Service Charge and Delivery Charge</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3a9647f5 elementor-widget elementor-widget-text-editor"
																		data-id="3a9647f5" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>You can add a fixed charge or percentage charge for service or delivery. There is also a service and delivery charge report.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-3c2ac6cd section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="3c2ac6cd" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6a23968b"
																data-id="6a23968b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-8d90968 elementor-widget elementor-widget-heading"
																		data-id="8d90968" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Food Combo</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-7f43ad84 elementor-widget elementor-widget-text-editor"
																		data-id="7f43ad84" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Facility to create combo items by combining multiple items, separate pricing of combo items, and auto-reduction of stock of all items when combo items are sold.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-65822975"
																data-id="65822975" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-23cf32e2 elementor-widget elementor-widget-image"
																		data-id="23cf32e2" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/23.-business-300x300.png"
																				class="attachment-medium size-medium wp-image-3456"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/23.-business.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-34e5d4f4 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="34e5d4f4" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-263d0e75"
																data-id="263d0e75" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5626d920 elementor-widget elementor-widget-image"
																		data-id="5626d920" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/24.-shopping-online-300x300.png"
																				class="attachment-medium size-medium wp-image-3457"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/24.-shopping-online.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3cdd5302"
																data-id="3cdd5302" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6f36f9db elementor-widget elementor-widget-heading"
																		data-id="6f36f9db" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Powerful Promotions & Discounts</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-8479344 elementor-widget elementor-widget-text-editor"
																		data-id="8479344" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a powerful promotion feature where promotions can be set in various ways. For example: Benefits like Buy 2 Get 1, Buy 3 Get 1 (Same or Different Item) and Item Discount etc. Also, the promotion date range can be set.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-34f885a2 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="34f885a2" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2a7f9422"
																data-id="2a7f9422" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-75686a9d elementor-widget elementor-widget-heading"
																		data-id="75686a9d" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				KOT Printer by Food Category
																			</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-245b0878 elementor-widget elementor-widget-text-editor"
																		data-id="245b0878" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a system of KOT printers according to different types of food categories, where 56mm. and 80mm. Thermal printers are supported and the printer along with the print server network supports, and there are also all kinds of printer related facilities. Even if there are many items in an order at once, the items are automatically printed on the specific KOT printer according to the category.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6b163a43"
																data-id="6b163a43" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-13784378 elementor-widget elementor-widget-image"
																		data-id="13784378" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/26.-printer-300x300.png"
																				class="attachment-medium size-medium wp-image-3459"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/26.-printer.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1f178cfa section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1f178cfa" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-530fd618"
																data-id="530fd618" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3eef060e elementor-widget elementor-widget-image"
																		data-id="3eef060e" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/27.-kitchen-300x300.png"
																				class="attachment-medium size-medium wp-image-3460"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/27.-kitchen.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4f6fc08b"
																data-id="4f6fc08b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4a33c41b elementor-widget elementor-widget-heading"
																		data-id="4a33c41b" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Kitchen Panel by Food Category - KDS</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-18dc305 elementor-widget elementor-widget-text-editor"
																		data-id="18dc305" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a facility of multiple kitchen panels according to categories. Even if there are many items in an order at once, the items are automatically displayed in specific panels according to the category.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-6c809cbd section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="6c809cbd" data-element_type="section">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3bb0370a"
																data-id="3bb0370a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1cc3d944 elementor-widget elementor-widget-heading"
																		data-id="1cc3d944" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Delivery Management</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-44de779c elementor-widget elementor-widget-text-editor"
																		data-id="44de779c" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a facility to set multiple delivery partners. Also, different prices for food can be set for each delivery partner. There is a facility to keep multiple delivery addresses for a customer and the address can be changed during order delivery.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-681cc8e8"
																data-id="681cc8e8" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1a5d88bb elementor-widget elementor-widget-image"
																		data-id="1a5d88bb" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/28.-material-management-300x300.png"
																				class="attachment-medium size-medium wp-image-3461"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/28.-material-management.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-30a04977 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="30a04977" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2c3a116b"
																data-id="2c3a116b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-11b0d78a elementor-widget elementor-widget-image"
																		data-id="11b0d78a" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/30.-bill-300x300.png"
																				class="attachment-medium size-medium wp-image-3462"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/30.-bill.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5ea8c6b3"
																data-id="5ea8c6b3" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2b0ce635 elementor-widget elementor-widget-heading"
																		data-id="2b0ce635" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Split Bill</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-776bed43 elementor-widget elementor-widget-text-editor"
																		data-id="776bed43" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customers can pay individually if they want, or even if the order is only one, each customer can split the bill and pay separately.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7da913fe section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7da913fe" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1c33317f"
																data-id="1c33317f" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-689651ff elementor-widget elementor-widget-heading"
																		data-id="689651ff" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				SMS Integration</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3a07c94b elementor-widget elementor-widget-text-editor"
																		data-id="3a07c94b" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a facility to send invoices to customers through SMS, there is also a facility to wish customers on their birthdays and wedding anniversaries through SMS. Again, custom SMS can also be sent to customers.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-26cd3133"
																data-id="26cd3133" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-73f81e53 elementor-widget elementor-widget-image"
																		data-id="73f81e53" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/sms-300x300.png"
																				class="attachment-medium size-medium wp-image-2282"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2022/02/sms.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-2901347b section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="2901347b" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2e096113"
																data-id="2e096113" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2e99b8c3 elementor-widget elementor-widget-image"
																		data-id="2e99b8c3" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/payment-method-300x300.png"
																				class="attachment-medium size-medium wp-image-3483"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/payment-method.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-ca7ada1"
																data-id="ca7ada1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3fcb86d5 elementor-widget elementor-widget-heading"
																		data-id="3fcb86d5" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Paying bills for the same order using multiple payment methods</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-66172052 elementor-widget elementor-widget-text-editor"
																		data-id="66172052" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Customers can pay for an order in various ways, such as: if the bill is 1000 taka, they can pay 500 taka in cash and the rest via card or online mobile payment bKash or Nagad.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-e7af046 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="e7af046" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-47b32ce0"
																data-id="47b32ce0" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-39f3f64 elementor-widget elementor-widget-heading"
																		data-id="39f3f64" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Stock Transfer</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-3ae62b3c elementor-widget elementor-widget-text-editor"
																		data-id="3ae62b3c" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Multiple branches can be managed and raw materials and food can be easily transferred from one branch to another, and in that case, when raw materials and food are transferred, it will decrease from the first stock and increase in the other stock.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1d53b07a"
																data-id="1d53b07a" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6a858ce8 elementor-widget elementor-widget-image"
																		data-id="6a858ce8" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/38.-transfer-data-300x300.png"
																				class="attachment-medium size-medium wp-image-3471"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/38.-transfer-data.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-619d65dd section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="619d65dd" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-88c05db"
																data-id="88c05db" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2952bed8 elementor-widget elementor-widget-image"
																		data-id="2952bed8" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/39.-admin-panel-300x300.png"
																				class="attachment-medium size-medium wp-image-3472"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/39.-admin-panel.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-411743e"
																data-id="411743e" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-502a6cd6 elementor-widget elementor-widget-heading"
																		data-id="502a6cd6" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Stock Adjustment</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-5a18aac9 elementor-widget elementor-widget-text-editor"
																		data-id="5a18aac9" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Due to mistake or any other reason (like many raw materials cannot be accurately measured eg: salt, pepper, spices etc) if there is any difference in raw material stock it can be easily adjusted manually by addition and subtraction.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-32da8de2 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="32da8de2" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1e7ba758"
																data-id="1e7ba758" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-25fa2f4e elementor-widget elementor-widget-heading"
																		data-id="25fa2f4e" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Customer Profile </h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-349c05ab elementor-widget elementor-widget-text-editor"
																		data-id="349c05ab" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>The customer profile will contain all the customer's information, such as name, contact number, multiple addresses, date of birth, wedding anniversary, etc. In addition, the discount amount can be set separately for a specific customer.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-144a2909"
																data-id="144a2909" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-1a6225d elementor-widget elementor-widget-image"
																		data-id="1a6225d" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/40.-profile-300x300.png"
																				class="attachment-medium size-medium wp-image-3474"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/40.-profile.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-630b3fe1 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="630b3fe1" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2f07dbf1"
																data-id="2f07dbf1" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-310de67 elementor-widget elementor-widget-image"
																		data-id="310de67" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/25.-customer-loyalty-300x300.png"
																				class="attachment-medium size-medium wp-image-3458"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/25.-customer-loyalty.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6ddac024"
																data-id="6ddac024" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-779b46e elementor-widget elementor-widget-heading"
																		data-id="779b46e" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Loyalty Point </h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-56475392 elementor-widget elementor-widget-text-editor"
																		data-id="56475392" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Loyalty points can be enabled/disabled and the value of each point can be set, separate points can be set for each item, and there is also a system for paying with points. There is also a loyalty report.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1f4faf78 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1f4faf78" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5dc2b5eb"
																data-id="5dc2b5eb" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-12c6d3d5 elementor-widget elementor-widget-heading"
																		data-id="12c6d3d5" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Customer Due Tracking</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-29771114 elementor-widget elementor-widget-text-editor"
																		data-id="29771114" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>If a customer makes a purchase on account, all the accounts of the money owed by that customer can be easily viewed here. There is a system for paying outstanding money, and there is also the facility to view the customer ledger and the list of all outstanding customers together.
																			</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7e6a7186"
																data-id="7e6a7186" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-42f9817a elementor-widget elementor-widget-image"
																		data-id="42f9817a" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/42.-due-date-300x300.png"
																				class="attachment-medium size-medium wp-image-3475"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-118c2d9c section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="118c2d9c" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4e66b855"
																data-id="4e66b855" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-fca4697 elementor-widget elementor-widget-image"
																		data-id="fca4697" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/43.-food-300x300.png"
																				class="attachment-medium size-medium wp-image-3476"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/43.-food.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-6f21aa44"
																data-id="6f21aa44" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2da89ade elementor-widget elementor-widget-heading"
																		data-id="2da89ade" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Raw Material Purchase</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-31a876e3 elementor-widget elementor-widget-text-editor"
																		data-id="31a876e3" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a system for purchasing raw materials at current prices and purchasing them on a rolling basis, all the items purchased from the person or organization supplying the raw materials.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-1d9880b9 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="1d9880b9" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1fbb946b"
																data-id="1fbb946b" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-57eb7bca elementor-widget elementor-widget-heading"
																		data-id="57eb7bca" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Supplier Due Tracking</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-481b9328 elementor-widget elementor-widget-text-editor"
																		data-id="481b9328" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a facility to purchase raw materials on account from the raw material supplier or organization and later view the records/reports of those outstanding amounts. There is also a facility to keep a record of the payment of the outstanding amount to the supplier. There is a facility to view the supplier ledger and all the records of the suppliers that are outstanding together.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-307f3dc3"
																data-id="307f3dc3" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2722fb21 elementor-widget elementor-widget-image"
																		data-id="2722fb21" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/42.-due-date-300x300.png"
																				class="attachment-medium size-medium wp-image-3475"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/42.-due-date.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7ba1789f section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7ba1789f" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-325365e9"
																data-id="325365e9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2d86af44 elementor-widget elementor-widget-image"
																		data-id="2d86af44" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/44.-expenses-300x300.png"
																				class="attachment-medium size-medium wp-image-3477"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/44.-expenses.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-41465adf"
																data-id="41465adf" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-5d7922ba elementor-widget elementor-widget-heading"
																		data-id="5d7922ba" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Expense Tracking</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-55b4b3e9 elementor-widget elementor-widget-text-editor"
																		data-id="55b4b3e9" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Category-wise (Rent, Salary, Bills, Entertainment etc.) expense entry facility and detailed expense report view facility.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-7726fbea section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="7726fbea" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-96ed0e2"
																data-id="96ed0e2" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-7ce556ab elementor-widget elementor-widget-heading"
																		data-id="7ce556ab" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Cash Register Tracking</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-2ba326a4 elementor-widget elementor-widget-text-editor"
																		data-id="2ba326a4" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a system to set how much cash a cashier has in the cash register and when his duty is over, it automatically calculates income, expenses, outstanding payments, etc. and later view the register report.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-10e3b7b9"
																data-id="10e3b7b9" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-3b132821 elementor-widget elementor-widget-image"
																		data-id="3b132821" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/45.-cash-register-300x300.png"
																				class="attachment-medium size-medium wp-image-3478"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/45.-cash-register.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-68df4555 section-padding elementor-reverse-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="68df4555" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-2e01f0ad"
																data-id="2e01f0ad" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-2aead6f8 elementor-widget elementor-widget-image"
																		data-id="2aead6f8" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/46.-employee-300x300.png"
																				class="attachment-medium size-medium wp-image-3479"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/46.-employee.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4eca430d"
																data-id="4eca430d" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-4ecef34f elementor-widget elementor-widget-heading"
																		data-id="4ecef34f" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Employee Management and Attendance</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-524c0f96 elementor-widget elementor-widget-text-editor"
																		data-id="524c0f96" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>There is a powerful employee management feature that includes access control. There is also a facility to take employee attendance and view their work track record and attendance reports.</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
													
													<section
														class="elementor-section elementor-inner-section elementor-element elementor-element-27a41809 section-padding elementor-section-boxed elementor-section-height-default elementor-section-height-default"
														data-id="27a41809" data-element_type="section"
														data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
														<div class="elementor-container elementor-column-gap-default"
															bis_skin_checked="1">
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-15f16da7"
																data-id="15f16da7" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-6c34ca02 elementor-widget elementor-widget-heading"
																		data-id="6c34ca02" data-element_type="widget"
																		data-widget_type="heading.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<h3
																				class="elementor-heading-title elementor-size-default">
																				Business Intelligence Dashboard</h3>
																		</div>
																	</div>
																	<div class="elementor-element elementor-element-1006ae90 elementor-widget elementor-widget-text-editor"
																		data-id="1006ae90" data-element_type="widget"
																		data-widget_type="text-editor.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<p>Innovative Analytical Dashboard, where you can monitor the entire restaurant's performance at a glance. For example: comparative picture of all transactions in a time period, Dine In/Take Away/Delivery comparison, stock alerts, top customers, monthly sales comparison chart and much more.</p>
																		</div>
																	</div>
																</div>
															</div>
															<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-5c5d5439"
																data-id="5c5d5439" data-element_type="column"
																bis_skin_checked="1">
																<div class="elementor-widget-wrap elementor-element-populated"
																	bis_skin_checked="1">
																	<div class="elementor-element elementor-element-73e1d1fe elementor-widget elementor-widget-image"
																		data-id="73e1d1fe" data-element_type="widget"
																		data-widget_type="image.default"
																		bis_skin_checked="1">
																		<div class="elementor-widget-container"
																			bis_skin_checked="1">
																			<img loading="lazy" decoding="async"
																				width="300" height="300"
																				src="<?php echo base_url()?>assets/landing/saas_new/48.-business-intelligence-300x300.png"
																				class="attachment-medium size-medium wp-image-3481"
																				alt=""
																				srcset="https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-300x300.png 300w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-150x150.png 150w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-112x112.png 112w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-60x60.png 60w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-120x120.png 120w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-105x105.png 105w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-80x80.png 80w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-100x100.png 100w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence-110x110.png 110w, https://doorsoft.co/cont_mas_zak_naz/uploads/2024/01/48.-business-intelligence.png 512w"
																				sizes="(max-width: 300px) 100vw, 300px">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</section>

									<div id="pricing" class="pricing-plan" data-bs-spy="scroll" data-bs-target="#main-navbar" data-bs-offset="0">
										<div class="container">
											<h2 class="title">Best Pricing Plans</h2>
											<div class="pricing-plan-wrapper">
											<div class="row">
												<div class="col-sm-12 col-md-4">

												</div>
												<div class="col-sm-12 col-md-4 div_btn_middle">
													<a href="#" class="payment_type div_active" type="1">Pay Monthly</a>
													<a href="#" class="payment_type" type="2">Pay Yearly</a>
												</div>
												<div class="col-sm-12 col-md-4">

												</div>
											</div>

											<div class="row">
												<!-- Dynamic -->
												<?php
													$getPricingPlan  = getPricingPlan();
													if(isset($getPricingPlan) && $getPricingPlan):
													foreach ($getPricingPlan as $value):


												?>
												<div class="b my-4 col-sm-12 col-md-4 <?php echo isset($value->is_recommended) && $value->is_recommended=="Yes"?"highlight-plan":''?>">
													<div class="plan">
													<header>
														<h3 class="title"><?php echo escape_output($value->plan_name)?></h3>
													</header>
													<ul>
														<li class="show_div_1">$<?php echo !$value->monthly_cost?'0':escape_output($value->monthly_cost)?><sup>/
															<?php
															echo lang('month');
															?></sup></li>

															<?php 
															$is_less_in_yearly_charge = 0;
															$is_less_in_yearly_charge_amount = 0;
															$tmp_amount = ($value->monthly_cost*12) - $value->price_for_month2;
															if($tmp_amount>0){
																$is_less_in_yearly_charge = $tmp_amount;
																$is_less_in_yearly_charge_amount = number_format($tmp_amount?$value->monthly_cost*12:0,2,'.','');
															}
															?>

														<li style="display:none" class="display_none show_div_2"><?php echo $is_less_in_yearly_charge?'<del>$'.($is_less_in_yearly_charge_amount).'</del>':''?> <?php echo !$value->price_for_month2?'$0':' $'.escape_output($value->price_for_month2)?><sup>/
															<?php
															echo lang('year');
															?></sup>
														</li>

														<li><?php echo escape_output($value->number_of_maximum_users)?> <?php echo lang('users')?> (<?php echo lang('monthly_limit')?>)</li>
														<li><?php echo escape_output($value->number_of_maximum_outlets)?> <?php echo lang('outlets')?> (<?php echo lang('monthly_limit')?>)</li>
														<li><?php echo escape_output($value->number_of_maximum_invoices)?> <?php echo lang('invoices')?> (<?php echo lang('monthly_limit')?>)</li>
														<li>  
														<?php
															$month_access = 0;
															$yearly_access = 0;
															if($value->free_trial_status=="Yes"):
															$month_access = $value->trail_days;
															$yearly_access = $value->trail_days;
															else:
																$month_access = 30;
																$yearly_access = 365;
															endif;

															?>
														<span class="update_details" data-div_1="<?php echo escape_output($month_access)?>" data-div_2="<?php echo escape_output($yearly_access)?>"><?php echo escape_output($month_access)?></span> Days Access
															
														</li>
													</ul>
													<?php
														$update_plan = isset($update_plan) && $update_plan?"/?update_plan=".$update_plan:'';
													?>
													<a class="plan-btn set_url" data-id="<?php echo escape_output($value->id)?>" href="<?php base_url()?>plan/<?php echo escape_output($value->id)."/1".$update_plan?>">get Started</a>
													</div>
												</div>
													<?php
													endforeach;
													endif;
													?>

											</div>
											</div>
										</div>
									</div>
									<p>&nbsp;</p>
									<section
										class="elementor-section elementor-top-section elementor-element elementor-element-2a039f36 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
										data-id="2a039f36" data-element_type="section"
										data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
										<div class="elementor-container elementor-column-gap-default"
											bis_skin_checked="1">
											<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2bb9a517"
												data-id="2bb9a517" data-element_type="column" bis_skin_checked="1">
												<div class="elementor-widget-wrap elementor-element-populated"
													bis_skin_checked="1">
													<div class="elementor-element elementor-element-2eaaed38 elementor-widget elementor-widget-heading"
														data-id="2eaaed38" data-element_type="widget"
														data-widget_type="heading.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<h2 class="elementor-heading-title elementor-size-default">
																So why is it late? Call Now</h2>
														</div>
													</div>
													<div class="elementor-element elementor-element-1283ccf2 elementor-align-center elementor-widget elementor-widget-button"
														data-id="1283ccf2" data-element_type="widget"
														data-widget_type="button.default" bis_skin_checked="1">
														<div class="elementor-widget-container" bis_skin_checked="1">
															<div class="elementor-button-wrapper" bis_skin_checked="1">
																<a class="elementor-button elementor-button-link elementor-size-md"
																	href="tel:<?php echo escape_output($phone)?>" target="_blank">
																	<span class="elementor-button-content-wrapper">
																		<span
																			class="elementor-button-text"><?php echo escape_output($phone)?></span>
																	</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>

								<div class="clearfix" bis_skin_checked="1"></div>
							</div>
						</div>

					</div>
				</div>
				<div id="contact_us"></div>
												</div>
			</section><!-- blog section with pagination -->



					<div id="contact" data-bs-spy="scroll" data-bs-target="#main-navbar,#page-list" data-bs-offset="0">
						<div class="container">
							<h2 class="contact_title">Contact Us</h2>
							<form class="row" id="contact_us_form" action="#">
								<div class="mb-4 col-md-12 col-lg-6">
								<input type="text" id="name" name="name" class="form-control required_check" placeholder="Name">
								</div>
								<div class="mb-4 col-md-12 col-lg-6">
								<input type="email" name="email" id="email" class="form-control required_check" placeholder="Email">
								</div>
								<div class="mb-4 col-md-12 col-lg-6">
								<input type="text" id="phone" name="phone" class="form-control required_check" placeholder="Phone Number">
								</div>
								<div class="mb-4 col-md-12 col-lg-6">
								<input type="text" id="subject" name="subject" class="form-control required_check" placeholder="Subject">
								</div>
								<div class="mb-4 col-md-12">
								<textarea name="message" id="message" class="form-control required_check" placeholder="Write Message"></textarea>
								</div>
								<div class="col-md-12 text-center">
								<button class="submit-btn send_mail">Send Message</button>
								</div>
							</form>
						</div>
						</div>


			<div class="clearfix" bis_skin_checked="1"></div>


			<!-- Main Footer -->
			<footer class="main-footer style-three">
				<div class="pattern-layer"
					style="background-image: url(https://doorsoft.co/cont_mas_zak_naz/themes/moko/assets/images/background/pattern-3.png)"
					bis_skin_checked="1"></div>
				<div class="pattern-layer-two"
					style="background-image: url(https://doorsoft.co/cont_mas_zak_naz/themes/moko/assets/images/background/pattern-4.png)"
					bis_skin_checked="1"></div>
				<div class="pattern-layer-three"
					style="background-image: url(https://doorsoft.co/cont_mas_zak_naz/themes/moko/assets/images/background/pattern-5.png)"
					bis_skin_checked="1"></div>

				<div class="auto-container" bis_skin_checked="1">
					<!--Widgets Section-->
					<div class="widgets-section" bis_skin_checked="1">
						<div class="row clearfix" bis_skin_checked="1">
							<div class="footer-column col-lg-3 col-md-6 col-sm-12" bis_skin_checked="1">
								<div id="moko_about_company_v1-1" class="footer-widget widget_moko_about_company_v1"
									bis_skin_checked="1">
									<div class="logo-widget" bis_skin_checked="1">
										<div class="logo" bis_skin_checked="1">
											<a href="<?php echo base_url()?>"><img
													src="<?php echo escape_output($system_logo)?>"
													alt=""></a>
										</div>
										<div class="text" bis_skin_checked="1"><?php echo (isset($wl->footer_description) && $wl->footer_description?$wl->footer_description:'')?></div>

										<!-- Social Box -->

										 
									</div>

								</div>
							</div>
							<div class="footer-column col-lg-3 col-md-6 col-sm-12" bis_skin_checked="1">
								<div id="moko_contact_info_v1-1" class="footer-widget widget_moko_contact_info_v1"
									bis_skin_checked="1">
									<div class="links-widget" bis_skin_checked="1">
										<h4>Contact Info</h4>
										<ul class="list-style-two">
											<li><span class="icon flaticon-wall-clo"><i class="fa-regular fa-clock"></i></span><?php echo (isset($wl->support_time) && $wl->support_time?$wl->support_time:'')?></li>
  
											<li><span class="icon flaticon-ema"><i class="fa-regular fa-envelope"></i></span><a target="_blank"
													href="mailto:<?php echo (isset($wl->email) && $wl->email?$wl->email:'')?>"><?php echo (isset($wl->email) && $wl->email?$wl->email:'')?></a></li>
									
											<li><span class=" icon whatsapp fab fa-whatsapp"></span><a target="_blank"
													href="https://wa.me/<?php echo (isset($wl->whatsapp_number) && $wl->whatsapp_number?$wl->whatsapp_number:'')?>"><?php echo (isset($wl->whatsapp_number) && $wl->whatsapp_number?$wl->whatsapp_number:'')?></a></li>

											<li><span class="icon flaticon-maps-and-fla"><i class="fa-solid fa-location-dot"></i></span><?php echo (isset($wl->footer_address) && $wl->footer_address?$wl->footer_address:'')?></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="footer-column col-lg-3 col-md-6 col-sm-12" bis_skin_checked="1">
								<div id="block-7" class="footer-widget widget_block" bis_skin_checked="1">
									<p><iframe src="<?php echo (isset($wl->google_map) && $wl->google_map?$wl->google_map:'')?>" width="450" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
								</div>
							</div>
						</div>
					</div>

					<!-- Footer Bottom -->
					<div class="footer-bottom" bis_skin_checked="1">
						<div class="copyright" bis_skin_checked="1">
							<div class="copyright" bis_skin_checked="1"><?php echo (isset($wl->footer_copy_right_text) && $wl->footer_copy_right_text?$wl->footer_copy_right_text:'')?></div>
						</div>
					</div>
				</div>
			</footer>
			<!-- End Main Footer -->

		</div><!-- End Page Wrapper -->

		<!-- Search Popup -->
		<div class="search-popup" bis_skin_checked="1">
			<button class="close-search style-two"><span class="flaticon-multiply"></span></button>
			<button class="close-search"><span class="fa fa-arrow-up"></span></button>

			<form method="post" action="<?php echo base_url()?>blog.html">
				<div class="form-group" bis_skin_checked="1">
					<input type="search" name="s" value="" placeholder="Search Here">
					<button type="submit"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
		<!-- End Header Search -->

		<!-- Scroll To Top -->
		<div class="back-to-top scroll-to-target show-back-to-top" data-target="html" bis_skin_checked="1">TOP</div>

		<div class="custom_ds_saas-modal-overlay">
        <div class="custom_ds_saas-modal-container">
            <div class="custom_ds_saas-modal-header">
                <h2 class="custom_ds_saas-modal-title">Outlet</h2> 
                <button class="custom_ds_saas-close-btn">
                    <svg class="custom_ds_saas-close-icon" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
            <div class="custom_ds_saas-modal-content">
                <p class="custom_ds_saas-modal-text">Please select your company outlet from the dropdown below:</p>
                
                <select class="custom_ds_saas-outlet-select" style="width: 100%">
		    <option value="">Select Outlet</option>
				<?php if (!empty($all_outlets)): ?>
					<?php foreach ($all_outlets as $outlet): ?>
						<option value="<?= $outlet->id ?>||<?= $outlet->company_id ?>">
						  <?= $outlet->business_name ?> - <?= $outlet->outlet_name ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
                </select>

                <p class="custom_ds_saas-modal-text">The selected outlet will be used for all online operations.</p>
            </div>
            <div class="custom_ds_saas-modal-footer">
                <button class="custom_ds_saas-modal-action-btn custom_ds_saas-cancel-btn">Cancel</button>
                <button class="custom_ds_saas-modal-action-btn custom_ds_saas-confirm-btn">Go Online</button>
            </div>
        </div>
    </div>
 
    <script>
        $(document).ready(function() {
			toastr.options = {
	positionClass:'toast-bottom-right'
	};
            // Initialize Select2
            $('.custom_ds_saas-outlet-select').select2({
                placeholder: "Select Outlet",
                allowClear: true
            });

            // Open modal
            $('.setOnlineOrder').on('click', function(e) {
			e.preventDefault();
                $('.custom_ds_saas-modal-overlay').addClass('active');
                $('body').css('overflow', 'hidden');
            });

		 

            // Close modal
            function closeCustomModal() {
                $('.custom_ds_saas-modal-overlay').removeClass('active');
                $('body').css('overflow', 'auto');
            }

            $('.custom_ds_saas-close-btn, .custom_ds_saas-cancel-btn').on('click', closeCustomModal);

            // Close when clicking outside modal
            $('.custom_ds_saas-modal-overlay').on('click', function(e) {
                if ($(e.target).hasClass('custom_ds_saas-modal-overlay')) {
                    closeCustomModal();
                }
            });

            // Close with Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('.custom_ds_saas-modal-overlay').hasClass('active')) {
                    closeCustomModal();
                }
            });

            // Save selection
            $('.custom_ds_saas-confirm-btn').on('click', function(e) { 
                const selectedOutlet = $('.custom_ds_saas-outlet-select').val();
                if (selectedOutlet) {
                    const outlet_company_id = $('.custom_ds_saas-outlet-select option:selected').val(); 

			  $.ajax({
					url: "<?php echo base_url()?>Authentication/setOutletForOnline",
					method: "POST",
					async: false,
					data: {
						outlet_company_id: outlet_company_id, 
					},
					datatype: "json",
					success: function (data) {
						location.reload();
					},
				});
                } else {
			toastr['warning']("Please select an outlet first", ''); 
                }
            });
        });
    </script>
		 
		<script type="text/javascript">
			const lazyloadRunObserver = () => {
				const lazyloadBackgrounds = document.querySelectorAll(`.e-con.e-parent:not(.e-lazyloaded)`);
				const lazyloadBackgroundObserver = new IntersectionObserver((entries) => {
					entries.forEach((entry) => {
						if (entry.isIntersecting) {
							let lazyloadBackground = entry.target;
							if (lazyloadBackground) {
								lazyloadBackground.classList.add('e-lazyloaded');
							}
							lazyloadBackgroundObserver.unobserve(entry.target);
						}
					});
				}, { rootMargin: '200px 0px 200px 0px' });
				lazyloadBackgrounds.forEach((lazyloadBackground) => {
					lazyloadBackgroundObserver.observe(lazyloadBackground);
				});
			};
			const events = [
				'DOMContentLoaded',
				'elementor/lazyload/observe',
			];
			events.forEach((event) => {
				document.addEventListener(event, lazyloadRunObserver);
			});
		</script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/hooks.min.js.download"
			id="wp-hooks-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/i18n.min.js.download"
			id="wp-i18n-js"></script>
		<script type="text/javascript" id="wp-i18n-js-after">
			/* <![CDATA[ */
			wp.i18n.setLocaleData({ 'text direction\u0004ltr': ['ltr'] });
			/* ]]> */
		</script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/index.js.download" id="swv-js"></script>
		<script type="text/javascript" id="contact-form-7-js-before">
		 
		</script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/index(1).js.download"
			id="contact-form-7-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/popper.min.js.download"
			id="popper-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/bootstrap.min.js.download"
			id="bootstrap-js"></script>
		<script type="text/javascript"
			src="<?php echo base_url()?>assets/landing/saas_new/jquery.mCustomScrollbar.concat.min.js.download"
			id="jquery-mcustomscrollbar-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/jquery.fancybox.js.download"
			id="jquery-fancybox-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/appear.js.download" id="appear-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/parallax.min.js.download"
			id="parallax-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/tilt.jquery.min.js.download"
			id="tilt-jquery-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/jquery.paroller.min.js.download"
			id="jquery-paroller-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/owl.js.download" id="owl-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/wow.js.download" id="wow-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/jquery.countdown.js.download"
			id="jquery-countdown-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/mixitup.js.download"
			id="mixitup-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/nav-tool.js.download"
			id="nav-tool-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/jquery-ui.js.download"
			id="jquery-ui-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/script.js.download"
			id="moko-main-script-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/webpack.runtime.min.js.download"
			id="elementor-webpack-runtime-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/frontend-modules.min.js.download"
			id="elementor-frontend-modules-js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/core.min.js.download"
			id="jquery-ui-core-js"></script>
		<script type="text/javascript" id="elementor-frontend-js-before">
			/* <![CDATA[ */
			var elementorFrontendConfig = { "environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false }, "i18n": { "shareOnFacebook": "Share on Facebook", "shareOnTwitter": "Share on Twitter", "pinIt": "Pin it", "download": "Download", "downloadImage": "Download image", "fullscreen": "Fullscreen", "zoom": "Zoom", "share": "Share", "playVideo": "Play Video", "previous": "Previous", "next": "Next", "close": "Close", "a11yCarouselPrevSlideMessage": "Previous slide", "a11yCarouselNextSlideMessage": "Next slide", "a11yCarouselFirstSlideMessage": "This is the first slide", "a11yCarouselLastSlideMessage": "This is the last slide", "a11yCarouselPaginationBulletMessage": "Go to slide" }, "is_rtl": false, "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600 }, "responsive": { "breakpoints": { "mobile": { "label": "Mobile Portrait", "value": 767, "default_value": 767, "direction": "max", "is_enabled": true }, "mobile_extra": { "label": "Mobile Landscape", "value": 880, "default_value": 880, "direction": "max", "is_enabled": false }, "tablet": { "label": "Tablet Portrait", "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true }, "tablet_extra": { "label": "Tablet Landscape", "value": 1200, "default_value": 1200, "direction": "max", "is_enabled": false }, "laptop": { "label": "Laptop", "value": 1366, "default_value": 1366, "direction": "max", "is_enabled": false }, "widescreen": { "label": "Widescreen", "value": 2400, "default_value": 2400, "direction": "min", "is_enabled": false } }, "hasCustomBreakpoints": false }, "version": "3.26.0", "is_static": false, "experimentalFeatures": { "additional_custom_breakpoints": true, "e_swiper_latest": true, "e_nested_atomic_repeaters": true, "e_onboarding": true, "e_css_smooth_scroll": true, "home_screen": true, "landing-pages": true, "nested-elements": true, "editor_v2": true, "e_element_cache": true, "link-in-bio": true, "floating-buttons": true }, "urls": { "assets": "https:\/\/doorsoft.co\/cont_mas_zak_naz\/plugins\/elementor\/assets\/", "ajaxurl": "https:\/\/doorsoft.co\/wp-admin\/admin-ajax.php", "uploadUrl": "https:\/\/doorsoft.co\/cont_mas_zak_naz\/uploads" }, "nonces": { "floatingButtonsClickTracking": "3edbe23e61" }, "swiperClass": "swiper", "settings": { "page": [], "editorPreferences": [] }, "kit": { "active_breakpoints": ["viewport_mobile", "viewport_tablet"], "global_image_lightbox": "yes", "lightbox_enable_counter": "yes", "lightbox_enable_fullscreen": "yes", "lightbox_enable_zoom": "yes", "lightbox_enable_share": "yes", "lightbox_title_src": "title", "lightbox_description_src": "description" }, "post": { "id": 3409, "title": "BD%20Restora%20-%20Door%20Soft", "excerpt": "", "featuredImage": false } };
			/* ]]> */
		</script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/landing/saas_new/frontend.min.js.download"
			id="elementor-frontend-js"></script>


			<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	</div><span id="elementor-device-mode" class="elementor-screen-only"></span>
	<script src="<?php echo base_url()?>assets/landing/saas_new/dialog.min.js.download"></script>
	<script src="<?php echo base_url()?>assets/landing/saas_new/share-link.min.js.download"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>assets/landing/saas_new/lightbox.min.css">
	<script src="<?php echo base_url()?>assets/landing/saas_new/swiper.min.js.download"></script><svg style="display: none;"
		class="e-font-icon-svg-symbols"></svg>

	
<script src="<?php echo base_url(); ?>frequent_changing/js/contact_us.js"></script>
<script src="<?php echo base_url()?>frequent_changing/slick-slider/slick-slider.min.js"></script>
<script>
	$('.banner_slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			dots: true,
			autoplay: true, // Enable autoplay
			autoplaySpeed: 3000, // Set autoplay speed in milliseconds (3 seconds)
			prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
			nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
			responsive: [{
				breakpoint: 1300,
				settings: {
					arrows: false
				}
			}]
			});

	$('.client_review').slick({
        dots: true,
        arrows: true,
        infinite: true,
	  autoplay: true, // Enable autoplay
        prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1366,
                settings: {
                    arrows: true,
                }
            },{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    arrows: true,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    arrows: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: true,
                }
            }
        ]
    });
</script>
</body> 

</html>