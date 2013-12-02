+function (context) { "use strict";

	var p_int = function(num) {
		var n = parseInt(num, 10);

		return isNaN(n) ? 0 : n;
	};

	var current_order = $('#current-order');

	$('.list-group').delegate( ".add", "click", function(ev) {
		var btn = $(ev.currentTarget);

		btn.closest('.list-group-item').find('form').removeClass('hidden');
		btn.hide();

		return false;
	});

	$('.list-group').delegate( ".cancel", "click", function(ev) {
		var btn = $(ev.currentTarget);

		var container = btn.closest('.list-group-item');
		container.find('form').addClass('hidden');
		container.find('.add').show();

		return false;
	});

	$('.list-group').delegate( "form", "submit", function(ev) {
		var form = $(ev.currentTarget),
			container = form.closest('.list-group-item');

		var data = form.serializeObject();
		$.ajax({
			data: data,
			type: 'POST',
			success:function(resp) {
				current_order.html(resp);
				form.addClass('hidden');
				container.find('.add').show();
			},
			url: "/new/add-item.php"
		});

		return false;
	});

}(window);