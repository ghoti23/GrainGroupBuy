$(document).ready(function() {

    var resultsContainer = $('#userList-all'),
        bodyTemplate = _.template($('#body-tmpl').html());

    $.ajax({
        type: 'GET',
        url: "api/order/fullOrderByUser.php?id="+groupBuyId,
        success:function(resp) {
            resultsContainer.html(bodyTemplate({data : resp || {}}));
        }

    });

});