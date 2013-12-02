$(document).ready(function() {

    var searchForm = $('#searchForm'),
        addForm = $('#addForm'),
        resultsContainer = $('#results-section'),
        bodyTemplate = _.template($('#body-tmpl').html());

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

    resultsContainer.delegate("a.add", "click", function() {
        addProduct.call(this);
    });

    var addProduct = function (template) {
        var id = $(this).data('addproduct');
        var data = addForm.serializeObject();
        if (typeof data[id] === "undefined") {
            data[id] = 1;
        }
        $.ajax({
            data: {"id":id,"value":data[id],"groupBuyId":data.groupBuyId},
            cache: false,
            type: 'POST',
            success: function(resp) {
                addForm.find('input:text').val('');
                $("#confirmation").addClass("show");
                if (resp.success) {
                    $("#confirmation").addClass("alert-success");
                    $("#confirmation").html("You have successfully added your product");
                } else {
                    $("#confirmation").addClass("alert-error");
                    $("#confirmation").html("There has been an error trying to add your product");
                }

            },
            url: "api/product/add_groupbuy.php"
        });
    };
});