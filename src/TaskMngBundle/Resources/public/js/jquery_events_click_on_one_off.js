$(document).ready(function() {

    showComments();

});

function showComments(){
    var superheroDescription = $('section.superhero-description');
    var ddElement = superheroDescription.find('dd');
    ddElement.hide();

    superheroDescription.find('dt').on('click', function(){
        //funkcja JQ ktora chowa-pokazuje przy klikaniu (toggle)
        //na kolejnym elemencie next(), czyli child DT.
        $(this).next().toggle();
    });
}
