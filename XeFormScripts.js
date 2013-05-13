/**
 * XiinEngine - XeForm Library JS
 *
 * XiinEngine and its libraries are supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Standalone Libraries
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @version v1.0
 */

var XeForm = {
    validate: {
        names: function(element) {
            var regexp = '^[A-Za-z \'\\-]{1,'+element.getAttribute('maxlength')+'}$',
                names = new RegExp(regexp);
            if (!element.value.match(names)) {
                console.log('There are illegal characters in this field');
            }
        }
    },
    view: {
        hideRules: function() {
            $('.xeform_rules').closest('li').hide();
        },
        hideTooltip: function() {
            $('.xeform_description').closest('li').hide();
        }        
    },
    controller: {
        applyRules: function() {
            $('input, textarea, select .xeform_form_entry').each(function() {
                $(this).bind('keyup',function(){
                    XeForm.validate.names(this);
                });
            });
        },
        bindEvents: function() {
            $('input, textarea, select .xeform_form_entry').focus(function() {
                $(this).parent().siblings('li').has('label.xeform_description').show();
                
            }).blur(function() {
                $(this).parent().siblings('li').has('label.xeform_description').hide();
            });
        }
    },
    init: function() {
        XeForm.view.hideRules();
        XeForm.view.hideTooltip();
        XeForm.controller.bindEvents();
        XeForm.controller.applyRules();
    }
}

$(document).ready(function() {
    XeForm.init();    
});
