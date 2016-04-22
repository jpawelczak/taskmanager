$(document).ready(function() {

    showComments();

});

function showComments(){
    var taskDetails = $('section.taskdetails');
    var ddElement = taskDetails.find('dd');
    ddElement.hide();

    taskDetails.find('dt').on('click', function(){
        $(this).next().toggle();
    });
}
