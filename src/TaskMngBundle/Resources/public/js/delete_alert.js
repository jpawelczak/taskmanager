$(document).ready(function() {

    deleteButton();

});

function deleteButton(){


    var deleteButton = $('.btn-danger');

    //preventing from sending the form anyway
    deleteButton.on('click', function(e) {
        e.preventDefault();

        //procees to a delete action if confimed "Yes, Delete!"
        var form = $(this).parents('form');
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },

            function (isConfirm) {
                if (isConfirm) form.submit();
            });
    });
}