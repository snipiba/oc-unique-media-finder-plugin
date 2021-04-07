/**
 * Author: SNiPI
 * E-Mail: snipi@snipi.sk
 * Last Edited: 6 April 2021
 */

jQuery(document).ready(function() {
    /**Add editor button to the preview screen**/
    $('div.control-toolbar .btn-group:eq(0)').after('<button class="btn btn-success" data-toggle="modal" data-size="giant" href="#onUniqueSearch"><i class="icon-search"></i></button>')
    $('#loader').hide();


});

function pictureDownloaded(data) {
    
    var folder = $(data).data("folder");
    
    $.oc.flashMsg({
        'text' : _lang_pic_downloaded + folder,
        'class' : 'success',
    });
    $('button[data-command="refresh"]').trigger('click');
}

function handlePicError(error) {
    
    $.oc.flashMsg({
        'text' : _lang_pic_error,
        'class' : 'danger',
    });
}

function searchComplete() {
    $('.nav-tabs li:eq(0)').trigger('click');
}