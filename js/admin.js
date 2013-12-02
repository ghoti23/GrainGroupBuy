$(document).ready(function() {

    var resultsContainer = $('#groupbuy-all'),
        bodyTemplate = _.template($('#body-tmpl').html()),
        userContainer  = $('#approve-all'),
        approveTemplate = _.template($('#approve-tmpl').html()),
        approveForm = $('#approveMember');

    loadApproveList();
    $.ajax({
        type: 'GET',
        url: "api/groupbuy/all.php",
        success:function(resp) {
            resultsContainer.html(bodyTemplate({data : resp || {}}));
        }

    });

    function loadApproveList() {
        $.ajax({
            type: 'GET',
            url: "api/users/approve.php",
            success:function(resp) {
                userContainer.html(approveTemplate({data : resp || {}}));
            }

        });
    }

    userContainer.delegate("a.update", "click", function() {
        updateOrder.call(this);
    });

    var updateOrder = function () {
        var data = approveForm.serializeObject();
        $.ajax({
            data : data,
            cache : false,
            type : 'POST',
            success : function(resp) {
                if (resp != null && (resp.errors || resp.message)) {
                    errorHandler.call();
                } else {
                    loadApproveList();
                }
            },
            url : "api/users/approveMember.php"
        });
        return false;
    };


});