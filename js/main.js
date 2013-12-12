+function (context) {
	"use strict";

	var p_int = function (num) {
		var n = parseInt(num, 10);

		return isNaN(n) ? 0 : n;
	};

	var current_order = $('#current-order');
	var product_modal = $('#product-modal');

	var title_field = product_modal.find('.title'),
		img_field = product_modal.find('img'),
		desc_field = product_modal.find('.desc'),
		vendor_field = product_modal.find('.vendor'),
		price_field = product_modal.find('.price'),
		id_field = product_modal.find('input[name="id"]'),
		select_field = product_modal.find('select');

	$('body').delegate(".add", "click", function (ev) {
		var btn = $(ev.currentTarget),
			parent = btn.closest('li'),
			title = parent.find('em').html(),
			img = parent.find('img').attr('src'),
			desc = parent.find('.desc').html(),
			vendor = parent.find( '.vendor').html(),
			price = parent.find('.price').html(),
			id = btn.data('id'),
			type = btn.data('type'),
			pounds = p_int(btn.data('pounds')),
			split = p_int(btn.data('split')),
			options = [],
			i = 0;

		if (type == 'grain') {
			if (split > 0) {
				var count = 1;
				var orderUnit = pounds / split;
				for (i = 0.5; i <= 10; i += 0.5) {
					options.push("<option value='" + i + "'>" + (count++ * orderUnit) + " lbs</option>");
				}
			}
			else {
				for (i = 1; i <= 10; i++) {
					options.push("<option value='" + i + "'>" + (i * pounds) + " lbs</option>");
				}
			}
		}
		else if (type == 'hops') {
			for (i = 1; i <= 11; i++) {
				options.push("<option value='" + (i / 11) + "'>" + i + " lbs</option>");
			}
		}
		else {
			for (i = 1; i <= 10; i++) {
				options.push("<option value='" + i + "'>" + i + "</option>");
			}
		}

		title_field.html(title);
		desc_field.html(desc);
		vendor_field.html(vendor);
		price_field.html(price);
		img_field.attr('src', img);
		id_field.val(id);
		select_field.html(options.join(''));
		product_modal.modal('show');

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