		<script src="js/plugins/jquery.min.js"></script>
		<script src="js/plugins/bootstrap.min.js"></script>
		<script src="js/plugins/underscore-min.js"></script>
        <script src="js/plugins/backbone.js"></script>
		<script src="js/plugins/jQuery.serializeObject.js"></script>
        <script src="js/plugins/jquery.validate.js"></script>
		<script type='text/javascript'>
			$(window).load(function() {
				$('#loading').fadeOut();
				$("a").tooltip();
			});
			$(document).ready(function() {

				$("#logo a, #sidebar_menu a:not(.accordion-toggle), a.ajx").click(function() {
					event.preventDefault();
					newLocation = this.href;
					$('body').fadeOut(500, newpage);
				});
				function newpage() {
					window.location = newLocation;
				}

			});
		</script>