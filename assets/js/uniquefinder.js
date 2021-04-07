/**
 * Author: SNiPI
 * E-Mail: snipi@snipi.sk
 * Last Edited: 6 April 2021
 */

jQuery(document).ready(function() {
    /**Add editor button to the preview screen**/
    $('div.control-toolbar .btn-group:eq(0)').after('<button class="btn btn-success" data-toggle="modal" data-size="giant" href="#onUniqueSearch"><i class="icon-search"></i></button>')


});

/*Show editing modal forms*/
function getForm($form) {
    if($form == 'resize') {
        $('#resizeForm').modal('show');
    }
    if($form == 'rotate') {
        $('#rotateForm').modal('show');
    }     
    if($form == 'flip') {
        $('#flipForm').modal('show');
    }    
    if($form == 'crop') {
        $('#cropForm').modal('show');
    }    
    if($form == 'grayscale') {
        $('#grayscaleForm').modal('show');
    }    
    if($form == 'watermark') {
        $('#watermarkForm').modal('show');
    }    
}   

/*Check for transparent animated GIFs*/
function validateChecked() {
    let isAnimated = $('#animated').is(':checked');
    let isTransparent = $('#transparent').is(':checked');
    if((isAnimated === true)&&(isTransparent === true)) {
        alert('Transparent animated GIFs are not supported at this time.');
        $('#animated').prop( "checked", false );
        $('#transparent').prop( "checked", false );
    }
}

function searchComplete() {
    
}