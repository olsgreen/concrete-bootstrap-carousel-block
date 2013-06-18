/**
 *
 * Wrapper for the editors JS tools
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 */

var BootstrapCarouselEditor = {};

(function () {
    
    "use strict";
    
    BootstrapCarouselEditor = {
        
        options: { blockURL: '' },
        
        init: function (options) {
            
            $.extend(BootstrapCarouselEditor.options, options);
            
            $('#slides ol li').each(function () {
                BootstrapCarouselEditor.wireSlideButtons($(this));
            });
            
        },
        
        // Delete Slide
        deleteSlide: function (ele) {
          
            ele.fadeOut(function () {
                $(this).remove();
            
                if ($('#slides ol li').length === 1) {
                    $('#slides .no-results').removeClass('hide');
                }
            });
            
        },
        
        // Show edit screen
        showEditScreen: function (data) {
            
            $('#sliderEdit, .ui-dialog-buttonpane').slideUp(function () {
                
                $('#slideEditLoading').fadeIn(function () {
                    
                    BootstrapCarouselEditor.getForm(data);
                    
                });
                
            });
            
        },
        
        // Hide edit screen
        hideEditScreen: function () {
            
            $('#slideEdit').slideUp(function () {
                $('#sliderEdit, .ui-dialog-buttonpane').slideDown();
            });
            
        },
        
        // Get the form
        getForm: function (input) {
            
            var postData = $.extend({}, input);
            delete (postData.ele);
            
            $.ajax({
                type: "POST",
                data: postData,
                url: BootstrapCarouselEditor.options.blockURL,
                dataType: "text",
                success: function (data) {
                    $('#slideEdit').css('display', 'block');
                    $('#slideEdit').html(data);
                    $('#slideEditLoading').fadeOut();
                    init_carousel_mce_editor();
                    BootstrapCarouselEditor.wireSlideEditButtons(input);
                },
                error: function () { alert('An error occured while loading the slide editor.'); $('#slideEditLoading').fadeOut(function () {$('#sliderEdit, .ui-dialog-buttonpane').slideDown(); }); }
            });
            
        },
        
        // Wire item buttons
        wireSlideButtons: function (ele) {
            
            $(ele).find('.slideEditButton').click(function () {
                
                BootstrapCarouselEditor.showEditScreen({ task: 'Edit',
                                                         imageID: $(ele).find('input[name="imageID[]"]').val(),
                                                         content: $(ele).find('input[name="content[]"]').val(),
                                                         link: $(ele).find('input[name="link[]"]').val(),
                                                         ele: $(ele) });
                
            });
            
            $(ele).find('.slideDeleteButton').click(function () {
                
                BootstrapCarouselEditor.deleteSlide(ele);
                
            });
            
        },
        
        // Wire the Slide Editor
        wireSlideEditButtons: function (data) {
            
            // Cancel Slide Edit
            $('.cancelEdit').click(function () {
                BootstrapCarouselEditor.hideEditScreen();
            });
            
            // Save Slide Edit
            $('.saveEdit').click(function () {
                
                var imageID = $('input[name=eimageID]').val(),
                    link = $('input[name=elink]').val(),
                    content = tinyMCE.activeEditor.getContent();
                
                if (!parseInt(imageID, 10)) {
                    alert('Please select an image.');
                    return;
                }
                    
                var img_ele = $('<span></span>').addClass('img').css('background-image', 'url(' + $('#eimageID-fm-selected img').attr('src') + ')'),
                    span_ele = $('<span></span>').addClass('title').html($('#eimageID-fm-selected .ccm-file-selected-data div').filter(':first').html()),
                    content_ele = $('<input>').attr('name', 'content[]').attr('type', 'hidden').val(content),
                    link_ele = $('<input>').attr('name', 'link[]').attr('type', 'hidden').val(link),
                    image_ele = $('<input>').attr('name', 'imageID[]').attr('type', 'hidden').val(imageID),
                    edit_ele = $('<a></a>').attr('href', 'javascript:void(0)').addClass('btn').addClass('btn-mini').addClass('slideEditButton').html('Edit'),
                    delete_ele = $('<a></a>').attr('href', 'javascript:void(0)').addClass('btn').addClass('btn-mini').addClass('btn-danger').addClass('slideDeleteButton').html('Delete'),
                    li = $('<li></li>').append(img_ele).append(span_ele).append(content_ele).append(link_ele).append(image_ele).append(edit_ele).append(delete_ele);
                    
                BootstrapCarouselEditor.wireSlideButtons(li);
                    
                if (data.task === 'Add') {
                    $('#slides ol').append(li);
                    $('#slides .no-results').addClass('hide');
                } else {
                    data.ele.replaceWith(li);
                }
                
                BootstrapCarouselEditor.hideEditScreen();
                
            });
            
        }
        
    };
    
}());