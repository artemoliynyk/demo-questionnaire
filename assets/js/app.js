import '../scss/app.scss';

require('bootstrap');

var $addBtn;
$(document).ready(function () {
    var $answersHolder = $('#question_answers');
    $addBtn = $("#add-answer");

    $addBtn.click(function () {
        addAnswer($answersHolder);
    });

    initControls($answersHolder, $('button.answer-remove'));
    checkNewAllowed($answersHolder);
});

function initControls($collectionHolder, $buttons) {
    $buttons.on('click', function () {
        if (confirm('Are you sure want to delete this?')) {
            $(this).parents('div.card:first').remove();
            checkNewAllowed($collectionHolder);
        }
    });
}


function checkNewAllowed($collectionHolder) {
    var answers = $collectionHolder.find('div.card').length;

    $addBtn.prop('disabled', (5 < answers));
}

function addAnswer($collectionHolder, $newAnswer) {
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.find('div.card').length;
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    let $newForm = $(newForm)

    initControls($collectionHolder, $newForm.find('button.answer-remove'));
    $collectionHolder.append($newForm);

    checkNewAllowed($collectionHolder);
}
