//Example of this in action: http://jsfiddle.net/sxGtM/3/

(function ($) {
	$.fn.serializeObject = function () {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function () {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [ o[this.name] ];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};

	// Copied the jQuery implementation to allow serializing object array attributes to look like:
	// behaviors[0].behaviorId=2 vs. behaviors[0][behaviorId]=2
	// Read the jQuery documentation for detailed info.
	$.extend({
		springParam: function (a, options) {
			var s = [],
				add = function (key, value) {
					// If value is a function, invoke it and return its value
					value = jQuery.isFunction(value) ? value() : value;
					s[ s.length ] = encodeURIComponent(key) + "=" + encodeURIComponent(value);
				};

			for (var prefix in a) {
				buildParams(prefix, a[ prefix ], add, options);
			}

			return s.join("&").replace(r20, "+");
		}
	});

	// Copied the jQuery implementation to allow serializing object array attributes to look like:
	// behaviors[0].behaviorId=2 vs. behaviors[0][behaviorId]=2
	// Read the jQuery documentation for detailed info.
	$.extend({
		springData: function (a, options) {
			var map = {},
				add = function (key, value) {
					// If value is a function, invoke it and return its value
					value = jQuery.isFunction(value) ? value() : value;
					map[ key ] = value;
				};

			for (var prefix in a) {
				buildParams(prefix, a[ prefix ], add, options);
			}

			return map;
		}
	});

	var r20 = /%20/g,
		rbracket = /\[\]$/;

	function buildParams(prefix, obj, add, options) {
		var default_settings = {
			alwaysIndex: false
		};
		var settings = $.extend({}.default_settings, options);

		if (jQuery.isArray(obj) && obj.length) {
			jQuery.each(obj, function (i, v) {
				if (rbracket.test(prefix)) {
					add(prefix, v);

				} else {
					buildParams(prefix + "[" + ( typeof v === "object" || jQuery.isArray(v) || settings.alwaysIndex ? i : "" ) + "]", v, add);
				}
			});
		} else if (obj != null && typeof obj === "object") {
			if (jQuery.isArray(obj) || jQuery.isEmptyObject(obj)) {
				add(prefix, "");

				// Here's the only change from the original jQuery implementation.  Removed wrapping [] and changed to '.'
			} else {
				for (var name in obj) {
					buildParams(prefix + "." + name, obj[ name ], add);
				}
			}
		} else {
			add(prefix, obj);
		}
	}
})(jQuery);