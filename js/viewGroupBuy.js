$(document).ready(function() {

    var viewModal = $('#viewModal'),
        resultsContainer = $('#results-section'),
        splitTemplate = _.template($('#split-edit-tmpl').html()),
        updateForm = $('#viewGroupBuy'),
        updateStatus = $('#updateStatus');

    var viewDetail = function (template) {
        var id = $(this).data('view-id');
        $('#loading').fadeIn();
        $.ajax({
            cache: false,
            type: 'GET',
            success: function(resp) {
                $('#loading').fadeOut();
                viewModal.html(template({data : resp || {}}));
                viewModal.modal('show');
            },
            url: "api/split/id.php?id=" + id +"&groupBuy=" + groupBuyId
        });
        return false;
    };

    var updateOrder = function (template) {
        var data = updateForm.serializeObject();
        updateStatus.html("");
        updateStatus.removeClass("alert-success");
        $.ajax({
            data: data,
            type: 'POST',
            success: function(resp) {
               location.reload();
            },
            url: "api/order/update.php"
        });
        return false;
    };

    resultsContainer.delegate("a.split", "click", function() {
        viewDetail.call(this, splitTemplate);
    });

    resultsContainer.delegate("a.update", "click", function() {
        updateOrder.call(this);
    });





});