$(document).ready(function() {

    var searchForm = $('#searchForm'),
        resultsContainer = $('#results-section'),
        bodyTemplate = _.template($('#body-tmpl').html()),
        viewModal = $('#viewModal'),
        editTemplate = _.template($('#edit-tmpl').html()),
        editForm = $('#editForm');

    searchForm.submit(function() {
        var data = searchForm.serializeObject();
        $.ajax({
            data: data,
            type: 'POST',
            success:function(resp) {
                users = resp;
                if (resp != null && (resp.errors)) {
                    for (var prop in resp.errors) {
                        error.html(resp.errors[prop]);
                        error.show();
                        break;
                    }
                }
                else {
                    resultsContainer.html(bodyTemplate({data : resp || {}}));
                }
            },
            url: "api/product/search.php"
        });
        return false;
    });

    resultsContainer.delegate("a.edit", "click", function() {
        addProduct.call(this, editTemplate);
    });


    var addProduct = function (template) {
        var id = $(this).data('id');
        $.ajax({
            data: {"id" : id},
            cache: false,
            type: 'POST',
            success: function(resp) {
                viewModal.html(template({data : resp || {}}));
                viewModal.modal('show');
            },
            url: "api/product/get.php"
        });
    };


});