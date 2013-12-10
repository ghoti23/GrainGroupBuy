+function (context) {
	"use strict";

	var p_int = function (num) {
		var n = parseInt(num, 10);

		return isNaN(n) ? 0 : n;
	};

	var current_order = $('#current-order');
	var product_modal = $('#product-modal');

	var title_field = product_modal.find('.title'),
		desc_field = product_modal.find('.desc'),
		id_field = product_modal.find('input[name="id"]');

	$('body').delegate(".add", "click", function (ev) {
		var btn = $(ev.currentTarget),
			title = btn.data('title'),
			desc = btn.data('desc'),
			id = btn.data('id');

		title_field.html(title);
		desc_field.html(desc);
		id_field.val(id);
		product_modal.modal('show')

		return false;
	});

	$('#product-modal').delegate("form", "submit", function (ev) {
		var form = $(ev.currentTarget);

		var data = form.serializeObject();
		$.ajax({
			data: data,
			type: 'POST',
			success: function (resp) {
				current_order.html(resp);
				product_modal.modal('hide')
			},
			url: "/new/add-item.php"
		});

		return false;
	});

}(window);