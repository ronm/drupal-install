(function ($, Drupal, window, document, undefined) {
$(function() {
	var $adminMenu = $("#admin-menu");

	$(window).keypress(function(e) {
		if ($adminMenu.length === 0) $adminMenu = $("#admin-menu");
		if (e.which === 126 && event.shiftKey) {
			$adminMenu.toggleClass("active");
		}
	});
	
	/*$(window).delegate("a.shortcut-toggle", "click", function() {
		e.preventDefault();
		console.log("l");
		$adminMenu.removeClass("active");
	});*/
})
})(jQuery, Drupal, this, this.document);
