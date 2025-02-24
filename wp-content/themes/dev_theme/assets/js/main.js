(function ($, window) {
	// coding ....
	// longpv
	$(".site_header_action_user").on("click", function () {
		$(".site_header_user").toggle();
		$(".site_header_cart_mini").hide();
	});
	$(".site_header_action_cart").on("click", function () {
		$(".site_header_user").hide();
		$(".site_header_cart_mini").toggle();
	});

	$(document).on("click", function (e) {
		if (!$(e.target).closest(".site_header_user, .site_header_cart_mini, .site_header_action_user, .site_header_action_cart").length) {
			$(".site_header_cart_mini").hide();
			$(".site_header_user").hide();
		}
	});
	//
	//
	//
	// vucoder
	//
	//
	//
	// end ...
})(jQuery, window);
