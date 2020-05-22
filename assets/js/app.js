import '../scss/app.scss';

require('bootstrap');

$(document).ready(function () {
    var $answersHolder = $('#question_answers');

    $("#add-answer").click(function () {
        addAnswer($answersHolder);
    });
});

function addAnswer($collectionHolder, $newAnswer) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    console.log(prototype);

    // get the new index
    var index = $collectionHolder.find('div.card').length;

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
     newForm = newForm.replace(/__name__label__/g, 'Answer');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    $collectionHolder.append(newForm);
}