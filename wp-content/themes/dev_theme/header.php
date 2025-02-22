<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dev_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<header class="site_header">
		<div class="container">
			<div class="site_header_inner">
				<div class="row align-items-center">
					<div class="col-lg-2">
						<a href="<?php echo home_url(); ?>" class="site_header_logo">
							<?php
							if (has_custom_logo()) {
								$custom_logo_id = get_theme_mod('custom_logo');
								$logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
								echo '<img class="site_header_logo_img" src="' . esc_url($logo_url) . '" alt="Site Logo">';
							} else {
								echo '<div class="site_header_logo_text">' . get_bloginfo('name') . '</div>';
							}
							?>
						</a>
					</div>
					<div class="col-lg-8">
						<?php
						if (has_nav_menu('menu-1')) {
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'container' => 'nav',
									'container_class' => 'site_header_menu',
									'depth' => 1,
								)
							);
						}
						?>
					</div>
					<div class="col-lg-2">
						<div class="site_header_action">
							<div class="site_header_action_search" data-bs-toggle="modal" data-bs-target="#site_header_action_search">
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M19.5 29C24.7467 29 29 24.7467 29 19.5C29 14.2533 24.7467 10 19.5 10C14.2533 10 10 14.2533 10 19.5C10 24.7467 14.2533 29 19.5 29Z" stroke="#0C0C0C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M30 30L28 28" stroke="#0C0C0C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
							<div class="site_header_action_cart">
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M13.1909 14.3799C13.0009 14.3799 12.8009 14.2999 12.6609 14.1599C12.3709 13.8699 12.3709 13.3899 12.6609 13.0999L16.2909 9.46994C16.5809 9.17994 17.0609 9.17994 17.3509 9.46994C17.6409 9.75994 17.6409 10.2399 17.3509 10.5299L13.7209 14.1599C13.5709 14.2999 13.3809 14.3799 13.1909 14.3799Z" fill="#0C0C0C" />
									<path d="M26.8091 14.3799C26.6191 14.3799 26.4291 14.3099 26.2791 14.1599L22.6491 10.5299C22.3591 10.2399 22.3591 9.75994 22.6491 9.46994C22.9391 9.17994 23.4191 9.17994 23.7091 9.46994L27.3391 13.0999C27.6291 13.3899 27.6291 13.8699 27.3391 14.1599C27.1991 14.2999 26.9991 14.3799 26.8091 14.3799Z" fill="#0C0C0C" />
									<path d="M28.21 18.6001C28.14 18.6001 28.07 18.6001 28 18.6001H27.77H12C11.3 18.6101 10.5 18.6101 9.92 18.0301C9.46 17.5801 9.25 16.8801 9.25 15.8501C9.25 13.1001 11.26 13.1001 12.22 13.1001H27.78C28.74 13.1001 30.75 13.1001 30.75 15.8501C30.75 16.8901 30.54 17.5801 30.08 18.0301C29.56 18.5501 28.86 18.6001 28.21 18.6001ZM12.22 17.1001H28.01C28.46 17.1101 28.88 17.1101 29.02 16.9701C29.09 16.9001 29.24 16.6601 29.24 15.8501C29.24 14.7201 28.96 14.6001 27.77 14.6001H12.22C11.03 14.6001 10.75 14.7201 10.75 15.8501C10.75 16.6601 10.91 16.9001 10.97 16.9701C11.11 17.1001 11.54 17.1001 11.98 17.1001H12.22Z" fill="#0C0C0C" />
									<path d="M17.7598 26.3C17.3498 26.3 17.0098 25.96 17.0098 25.55V22C17.0098 21.59 17.3498 21.25 17.7598 21.25C18.1698 21.25 18.5098 21.59 18.5098 22V25.55C18.5098 25.97 18.1698 26.3 17.7598 26.3Z" fill="#0C0C0C" />
									<path d="M22.3594 26.3C21.9494 26.3 21.6094 25.96 21.6094 25.55V22C21.6094 21.59 21.9494 21.25 22.3594 21.25C22.7694 21.25 23.1094 21.59 23.1094 22V25.55C23.1094 25.97 22.7694 26.3 22.3594 26.3Z" fill="#0C0C0C" />
									<path d="M22.8907 30.75H16.8607C13.2807 30.75 12.4807 28.62 12.1707 26.77L10.7607 18.12C10.6907 17.71 10.9707 17.33 11.3807 17.26C11.7907 17.19 12.1707 17.47 12.2407 17.88L13.6507 26.52C13.9407 28.29 14.5407 29.25 16.8607 29.25H22.8907C25.4607 29.25 25.7507 28.35 26.0807 26.61L27.7607 17.86C27.8407 17.45 28.2307 17.18 28.6407 17.27C29.0507 17.35 29.3107 17.74 29.2307 18.15L27.5507 26.9C27.1607 28.93 26.5107 30.75 22.8907 30.75Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_action_user">
								<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M20 20.75C16.83 20.75 14.25 18.17 14.25 15C14.25 11.83 16.83 9.25 20 9.25C23.17 9.25 25.75 11.83 25.75 15C25.75 18.17 23.17 20.75 20 20.75ZM20 10.75C17.66 10.75 15.75 12.66 15.75 15C15.75 17.34 17.66 19.25 20 19.25C22.34 19.25 24.25 17.34 24.25 15C24.25 12.66 22.34 10.75 20 10.75Z" fill="#0C0C0C" />
									<path d="M28.5901 30.75C28.1801 30.75 27.8401 30.41 27.8401 30C27.8401 26.55 24.3202 23.75 20.0002 23.75C15.6802 23.75 12.1602 26.55 12.1602 30C12.1602 30.41 11.8202 30.75 11.4102 30.75C11.0002 30.75 10.6602 30.41 10.6602 30C10.6602 25.73 14.8502 22.25 20.0002 22.25C25.1502 22.25 29.3401 25.73 29.3401 30C29.3401 30.41 29.0001 30.75 28.5901 30.75Z" fill="#0C0C0C" />
								</svg>
							</div>
						</div>
					</div>
				</div>

				<div class="site_header_user">
					<div class="site_header_user_inner">
						<a href="#" class="site_header_user_item">
							<div class="site_header_user_item_icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.1205 13.53C12.1005 13.53 12.0705 13.53 12.0505 13.53C12.0205 13.53 11.9805 13.53 11.9505 13.53C9.68047 13.46 7.98047 11.69 7.98047 9.50998C7.98047 7.28998 9.79047 5.47998 12.0105 5.47998C14.2305 5.47998 16.0405 7.28998 16.0405 9.50998C16.0305 11.7 14.3205 13.46 12.1505 13.53C12.1305 13.53 12.1305 13.53 12.1205 13.53ZM12.0005 6.96998C10.6005 6.96998 9.47047 8.10998 9.47047 9.49998C9.47047 10.87 10.5405 11.98 11.9005 12.03C11.9305 12.02 12.0305 12.02 12.1305 12.03C13.4705 11.96 14.5205 10.86 14.5305 9.49998C14.5305 8.10998 13.4005 6.96998 12.0005 6.96998Z" fill="#0C0C0C" />
									<path d="M11.9998 22.7501C9.30984 22.7501 6.73984 21.7501 4.74984 19.9301C4.56984 19.7701 4.48984 19.5301 4.50984 19.3001C4.63984 18.1101 5.37984 17.0001 6.60984 16.1801C9.58984 14.2001 14.4198 14.2001 17.3898 16.1801C18.6198 17.0101 19.3598 18.1101 19.4898 19.3001C19.5198 19.5401 19.4298 19.7701 19.2498 19.9301C17.2598 21.7501 14.6898 22.7501 11.9998 22.7501ZM6.07984 19.1001C7.73984 20.4901 9.82984 21.2501 11.9998 21.2501C14.1698 21.2501 16.2598 20.4901 17.9198 19.1001C17.7398 18.4901 17.2598 17.9001 16.5498 17.4201C14.0898 15.7801 9.91984 15.7801 7.43984 17.4201C6.72984 17.9001 6.25984 18.4901 6.07984 19.1001Z" fill="#0C0C0C" />
									<path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_user_item_text">
								Jimmy Smith
							</div>
						</a>

						<a href="#" class="site_header_user_item">
							<div class="site_header_user_item_icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M16.5 8.63005C16.09 8.63005 15.75 8.29005 15.75 7.88005V6.50005C15.75 5.45006 15.3 4.43005 14.52 3.72005C13.73 3.00005 12.71 2.67005 11.63 2.77005C9.83 2.94005 8.25 4.78005 8.25 6.70005V7.67005C8.25 8.08005 7.91 8.42005 7.5 8.42005C7.09 8.42005 6.75 8.08005 6.75 7.67005V6.69005C6.75 4.00005 8.92 1.52005 11.49 1.27005C12.99 1.13005 14.43 1.60005 15.53 2.61005C16.62 3.60005 17.25 5.02005 17.25 6.50005V7.88005C17.25 8.29005 16.91 8.63005 16.5 8.63005Z" fill="#0C0C0C" />
									<path d="M14.9998 22.75H8.99982C4.37982 22.75 3.51982 20.6 3.29982 18.51L2.54982 12.52C2.43982 11.44 2.39982 9.89 3.44982 8.73C4.34982 7.73 5.83982 7.25 7.99982 7.25H15.9998C18.1698 7.25 19.6598 7.74 20.5498 8.73C21.5898 9.89 21.5598 11.44 21.4498 12.5L20.6998 18.51C20.4798 20.6 19.6198 22.75 14.9998 22.75ZM7.99982 8.75C6.30982 8.75 5.14982 9.08 4.55982 9.74C4.06982 10.28 3.90982 11.11 4.03982 12.35L4.78982 18.34C4.95982 19.94 5.39982 21.26 8.99982 21.26H14.9998C18.5998 21.26 19.0398 19.95 19.2098 18.36L19.9598 12.35C20.0898 11.13 19.9298 10.3 19.4398 9.75C18.8498 9.08 17.6898 8.75 15.9998 8.75H7.99982Z" fill="#0C0C0C" />
									<path d="M15.4202 13.1499C14.8602 13.1499 14.4102 12.6999 14.4102 12.1499C14.4102 11.5999 14.8602 11.1499 15.4102 11.1499C15.9602 11.1499 16.4102 11.5999 16.4102 12.1499C16.4102 12.6999 15.9702 13.1499 15.4202 13.1499Z" fill="#0C0C0C" />
									<path d="M8.42016 13.1499C7.86016 13.1499 7.41016 12.6999 7.41016 12.1499C7.41016 11.5999 7.86016 11.1499 8.41016 11.1499C8.96016 11.1499 9.41016 11.5999 9.41016 12.1499C9.41016 12.6999 8.97016 13.1499 8.42016 13.1499Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_user_item_text">
								Orders
							</div>
						</a>

						<a href="#" class="site_header_user_item">
							<div class="site_header_user_item_icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 21.6501C11.69 21.6501 11.39 21.6101 11.14 21.5201C7.32 20.2101 1.25 15.5601 1.25 8.6901C1.25 5.1901 4.08 2.3501 7.56 2.3501C9.25 2.3501 10.83 3.0101 12 4.1901C13.17 3.0101 14.75 2.3501 16.44 2.3501C19.92 2.3501 22.75 5.2001 22.75 8.6901C22.75 15.5701 16.68 20.2101 12.86 21.5201C12.61 21.6101 12.31 21.6501 12 21.6501ZM7.56 3.8501C4.91 3.8501 2.75 6.0201 2.75 8.6901C2.75 15.5201 9.32 19.3201 11.63 20.1101C11.81 20.1701 12.2 20.1701 12.38 20.1101C14.68 19.3201 21.26 15.5301 21.26 8.6901C21.26 6.0201 19.1 3.8501 16.45 3.8501C14.93 3.8501 13.52 4.5601 12.61 5.7901C12.33 6.1701 11.69 6.1701 11.41 5.7901C10.48 4.5501 9.08 3.8501 7.56 3.8501Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_user_item_text">
								Wish List
							</div>
						</a>

						<a href="#" class="site_header_user_item">
							<div class="site_header_user_item_icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M13.4002 17.4201H10.8902C9.25016 17.4201 7.92016 16.0401 7.92016 14.3401C7.92016 13.9301 8.26016 13.5901 8.67016 13.5901C9.08016 13.5901 9.42016 13.9301 9.42016 14.3401C9.42016 15.2101 10.0802 15.9201 10.8902 15.9201H13.4002C14.0502 15.9201 14.5902 15.3401 14.5902 14.6401C14.5902 13.7701 14.2802 13.6001 13.7702 13.4201L9.74016 12.0001C8.96016 11.7301 7.91016 11.1501 7.91016 9.36008C7.91016 7.82008 9.12016 6.58008 10.6002 6.58008H13.1102C14.7502 6.58008 16.0802 7.96008 16.0802 9.66008C16.0802 10.0701 15.7402 10.4101 15.3302 10.4101C14.9202 10.4101 14.5802 10.0701 14.5802 9.66008C14.5802 8.79008 13.9202 8.08008 13.1102 8.08008H10.6002C9.95016 8.08008 9.41016 8.66008 9.41016 9.36008C9.41016 10.2301 9.72016 10.4001 10.2302 10.5801L14.2602 12.0001C15.0402 12.2701 16.0902 12.8501 16.0902 14.6401C16.0802 16.1701 14.8802 17.4201 13.4002 17.4201Z" fill="#0C0C0C" />
									<path d="M12 18.75C11.59 18.75 11.25 18.41 11.25 18V6C11.25 5.59 11.59 5.25 12 5.25C12.41 5.25 12.75 5.59 12.75 6V18C12.75 18.41 12.41 18.75 12 18.75Z" fill="#0C0C0C" />
									<path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_user_item_text">
								Payments
							</div>
						</a>

						<a href="#" class="site_header_user_item">
							<div class="site_header_user_item_icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M15.2395 22.27H15.1095C10.6695 22.27 8.52953 20.52 8.15953 16.6C8.11953 16.19 8.41953 15.82 8.83953 15.78C9.23953 15.74 9.61953 16.05 9.65953 16.46C9.94953 19.6 11.4295 20.77 15.1195 20.77H15.2495C19.3195 20.77 20.7595 19.33 20.7595 15.26V8.73998C20.7595 4.66998 19.3195 3.22998 15.2495 3.22998H15.1195C11.4095 3.22998 9.92953 4.41998 9.65953 7.61998C9.60953 8.02998 9.25953 8.33998 8.83953 8.29998C8.41953 8.26998 8.11953 7.89998 8.14953 7.48998C8.48953 3.50998 10.6395 1.72998 15.1095 1.72998H15.2395C20.1495 1.72998 22.2495 3.82998 22.2495 8.73998V15.26C22.2495 20.17 20.1495 22.27 15.2395 22.27Z" fill="#0C0C0C" />
									<path d="M15.0001 12.75H3.62012C3.21012 12.75 2.87012 12.41 2.87012 12C2.87012 11.59 3.21012 11.25 3.62012 11.25H15.0001C15.4101 11.25 15.7501 11.59 15.7501 12C15.7501 12.41 15.4101 12.75 15.0001 12.75Z" fill="#0C0C0C" />
									<path d="M5.85043 16.1001C5.66043 16.1001 5.47043 16.0301 5.32043 15.8801L1.97043 12.5301C1.68043 12.2401 1.68043 11.7601 1.97043 11.4701L5.32043 8.12009C5.61043 7.83009 6.09043 7.83009 6.38043 8.12009C6.67043 8.41009 6.67043 8.89009 6.38043 9.18009L3.56043 12.0001L6.38043 14.8201C6.67043 15.1101 6.67043 15.5901 6.38043 15.8801C6.24043 16.0301 6.04043 16.1001 5.85043 16.1001Z" fill="#0C0C0C" />
								</svg>
							</div>
							<div class="site_header_user_item_text">
								Log out
							</div>
						</a>
					</div>
				</div>

				<div class="site_header_cart_mini">
					<div class="site_header_cart_mini_inner">
						<div class="site_header_cart_mini_title">
							3 items
						</div>
						<div class="site_header_cart_mini_list">
							<?php
							for ($i = 1; $i < 5; $i++):
							?>
								<div class="site_header_cart_mini_item">
									<div class="row">
										<div class="col-5">
											<img class="site_header_cart_mini_item_img" src="<?php echo get_template_directory_uri() . '/assets/images/cart_mini_img.png'; ?>" alt="">
										</div>
										<div class="col-7">
											<div class="site_header_cart_mini_item_content">
												<a href="#" class="site_header_cart_mini_item_title">
													Inateck 12.3-13 Inch MacBook Case Sleeve
												</a>
												<div class="site_header_cart_mini_item_type">
													Black
												</div>
												<div class="site_header_cart_mini_item_quantity">
													x1
												</div>
												<div class="row">
													<div class="col-4">
														<div class="site_header_cart_mini_item_price">
															$63.26
														</div>
													</div>
													<div class="col-8">
														<div class="site_header_cart_mini_item_action">
															<div class="site_header_cart_mini_item_action_delete">
																<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M14.0004 4.48657C13.9871 4.48657 13.9671 4.48657 13.9471 4.48657C10.4204 4.13324 6.90043 3.9999 3.41377 4.35324L2.05377 4.48657C1.77377 4.51324 1.5271 4.31324 1.50043 4.03324C1.47377 3.75324 1.67377 3.51324 1.9471 3.48657L3.3071 3.35324C6.85377 2.99324 10.4471 3.13324 14.0471 3.48657C14.3204 3.51324 14.5204 3.7599 14.4938 4.03324C14.4738 4.29324 14.2538 4.48657 14.0004 4.48657Z" fill="#C91433" />
																	<path d="M5.66651 3.81325C5.63984 3.81325 5.61318 3.81325 5.57984 3.80659C5.31318 3.75992 5.12651 3.49992 5.17318 3.23325L5.31984 2.35992C5.42651 1.71992 5.57318 0.833252 7.12651 0.833252H8.87318C10.4332 0.833252 10.5798 1.75325 10.6798 2.36659L10.8265 3.23325C10.8732 3.50659 10.6865 3.76659 10.4198 3.80659C10.1465 3.85325 9.88651 3.66659 9.84651 3.39992L9.69984 2.53325C9.60651 1.95325 9.58651 1.83992 8.87984 1.83992H7.13318C6.42651 1.83992 6.41318 1.93325 6.31318 2.52659L6.15984 3.39325C6.11984 3.63992 5.90651 3.81325 5.66651 3.81325Z" fill="#C91433" />
																	<path d="M10.1396 15.1667H5.85961C3.53294 15.1667 3.43961 13.8801 3.36627 12.8401L2.93294 6.12672C2.91294 5.85338 3.12627 5.61338 3.39961 5.59338C3.67961 5.58005 3.91294 5.78672 3.93294 6.06005L4.36627 12.7734C4.43961 13.7867 4.46627 14.1667 5.85961 14.1667H10.1396C11.5396 14.1667 11.5663 13.7867 11.6329 12.7734L12.0663 6.06005C12.0863 5.78672 12.3263 5.58005 12.5996 5.59338C12.8729 5.61338 13.0863 5.84672 13.0663 6.12672L12.6329 12.8401C12.5596 13.8801 12.4663 15.1667 10.1396 15.1667Z" fill="#C91433" />
																	<path d="M9.10672 11.5H6.88672C6.61339 11.5 6.38672 11.2733 6.38672 11C6.38672 10.7267 6.61339 10.5 6.88672 10.5H9.10672C9.38005 10.5 9.60672 10.7267 9.60672 11C9.60672 11.2733 9.38005 11.5 9.10672 11.5Z" fill="#C91433" />
																	<path d="M9.66634 8.83325H6.33301C6.05967 8.83325 5.83301 8.60658 5.83301 8.33325C5.83301 8.05992 6.05967 7.83325 6.33301 7.83325H9.66634C9.93967 7.83325 10.1663 8.05992 10.1663 8.33325C10.1663 8.60658 9.93967 8.83325 9.66634 8.83325Z" fill="#C91433" />
																</svg>
															</div>

															<div class="site_header_cart_mini_item_action_amount">
																<div class="site_header_cart_mini_item_action_sub">
																	<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M12 8.5H4C3.72667 8.5 3.5 8.27333 3.5 8C3.5 7.72667 3.72667 7.5 4 7.5H12C12.2733 7.5 12.5 7.72667 12.5 8C12.5 8.27333 12.2733 8.5 12 8.5Z" fill="#717171" />
																	</svg>
																</div>
																<div class="site_header_cart_mini_item_amount">
																	1
																</div>
																<div class="site_header_cart_mini_item_action_add">
																	<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M12 8.5H4C3.72667 8.5 3.5 8.27333 3.5 8C3.5 7.72667 3.72667 7.5 4 7.5H12C12.2733 7.5 12.5 7.72667 12.5 8C12.5 8.27333 12.2733 8.5 12 8.5Z" fill="#717171" />
																		<path d="M8 12.5C7.72667 12.5 7.5 12.2733 7.5 12V4C7.5 3.72667 7.72667 3.5 8 3.5C8.27333 3.5 8.5 3.72667 8.5 4V12C8.5 12.2733 8.27333 12.5 8 12.5Z" fill="#717171" />
																	</svg>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
							endfor;
							?>
						</div>
						<div class="site_header_cart_mini_footer">
							<div class="row">
								<div class="col-3">
									<div class="site_header_cart_mini_total">
										<div class="site_header_cart_mini_total_label">
											Grand total
										</div>
										<div class="site_header_cart_mini_total_price">
											$543.02
										</div>
									</div>
								</div>
								<div class="col-9">
									<a href="#" class="site_header_cart_mini_checkout">
										<span class="site_header_cart_mini_checkout_text">
											Proceed to Cart
										</span>
										<span class="site_header_cart_mini_checkout_icon">
											<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M18.69 17.75H8.03999C7.04999 17.75 6.09999 17.33 5.42999 16.6C4.75999 15.87 4.42 14.89 4.5 13.9L5.33 3.94C5.36 3.63 5.24999 3.33001 5.03999 3.10001C4.82999 2.87001 4.54 2.75 4.23 2.75H2.5C2.09 2.75 1.75 2.41 1.75 2C1.75 1.59 2.09 1.25 2.5 1.25H4.24001C4.97001 1.25 5.65999 1.56 6.14999 2.09C6.41999 2.39 6.62 2.74 6.73 3.13H19.22C20.23 3.13 21.16 3.53 21.84 4.25C22.51 4.98 22.85 5.93 22.77 6.94L22.23 14.44C22.12 16.27 20.52 17.75 18.69 17.75ZM6.78 4.62L6 14.02C5.95 14.6 6.14 15.15 6.53 15.58C6.92 16.01 7.45999 16.24 8.03999 16.24H18.69C19.73 16.24 20.67 15.36 20.75 14.32L21.29 6.82001C21.33 6.23001 21.14 5.67001 20.75 5.26001C20.36 4.84001 19.82 4.60999 19.23 4.60999H6.78V4.62Z" fill="white" />
												<path d="M16.75 22.75C15.65 22.75 14.75 21.85 14.75 20.75C14.75 19.65 15.65 18.75 16.75 18.75C17.85 18.75 18.75 19.65 18.75 20.75C18.75 21.85 17.85 22.75 16.75 22.75ZM16.75 20.25C16.47 20.25 16.25 20.47 16.25 20.75C16.25 21.03 16.47 21.25 16.75 21.25C17.03 21.25 17.25 21.03 17.25 20.75C17.25 20.47 17.03 20.25 16.75 20.25Z" fill="white" />
												<path d="M8.75 22.75C7.65 22.75 6.75 21.85 6.75 20.75C6.75 19.65 7.65 18.75 8.75 18.75C9.85 18.75 10.75 19.65 10.75 20.75C10.75 21.85 9.85 22.75 8.75 22.75ZM8.75 20.25C8.47 20.25 8.25 20.47 8.25 20.75C8.25 21.03 8.47 21.25 8.75 21.25C9.03 21.25 9.25 21.03 9.25 20.75C9.25 20.47 9.03 20.25 8.75 20.25Z" fill="white" />
												<path d="M21.5 8.75H9.5C9.09 8.75 8.75 8.41 8.75 8C8.75 7.59 9.09 7.25 9.5 7.25H21.5C21.91 7.25 22.25 7.59 22.25 8C22.25 8.41 21.91 8.75 21.5 8.75Z" fill="white" />
											</svg>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Modal Tìm kiếm sản phẩm -->
	<div class="modal fade" id="site_header_action_search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
		</div>
	</div>