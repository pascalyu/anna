/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
//import 'bootstrap/js/src/collapse.js';
import '@fortawesome/fontawesome-free';
import '@fortawesome/fontawesome-free/css/fontawesome.css';

import '@fortawesome/fontawesome-free/js/all.js';
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
$(document).ready(function () {
    var $wrapper = $('.js-genus-scientist-wrapper');
    $wrapper.on('click', '.js-genus-scientist-add', function (e) {
        e.preventDefault();
    });
});


var addTagButton = $('<button type="button" class="btn btn-secondary add_tag_link"><span class="fa fa-plus-circle"></span> Ajouter une image</button>');
var newLinkLi = $('<div></div>').append(addTagButton);

$(document).ready(function () {
    // Get the ul that holds the collection of tags
    var collectionHolder = $('div.pictures');

    // add the "add a tag" anchor and li to the tags ul
    collectionHolder.append(newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find('input').length);

    addTagButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addPictureForm(collectionHolder, newLinkLi);
    });


    function addPictureForm(collectionHolder, newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = collectionHolder.data('prototype');

        // get the new index
        var index = collectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var newFormLi = $('<div></div>').append(newForm);
        newLinkLi.before(newFormLi);
    }
});