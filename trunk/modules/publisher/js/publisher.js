var $publisher = jQuery.noConflict();

$publisher(document).ready(function() {
    //Functions to execute on page load

        $publisher('a[rel*=item-lightbox]').lightBox({
            overlayBgColor: '#000',
            overlayOpacity: 0.6,
            imageLoading: 'images/lightbox-ico-loading.gif',
            imageBtnClose: 'images/close.gif',
            imageBtnPrev: 'images/prev.gif',
            imageBtnNext: 'images/next.gif',
            containerResizeSpeed: 800,
            fixedNavigation: true,
            txtImage: 'Image',
            txtOf: 'of'
        });
	   
        $publisher("#tabs").tabs();

        var MenuDom = xoopsGetElementById('image_item');
        if (MenuDom != null) {
            for(var i=0; i < MenuDom.options.length; i++) {
                MenuDom.options[i].selected = true;
            }
        }

    
});


function publisher_appendSelectOption(fromMenuId, toMenuId)
{
    var fromMenuDom = xoopsGetElementById(fromMenuId);
    var toMenuDom = xoopsGetElementById(toMenuId);
    var newOption = new Option(fromMenuDom.options[fromMenuDom.selectedIndex].text, fromMenuDom.options[fromMenuDom.selectedIndex].value);
    newOption.selected = true;
    toMenuDom.options[toMenuDom.options.length] = newOption;

    fromMenuDom.remove(fromMenuDom.selectedIndex);

}

function publisher_updateSelectOption(fromMenuId, toMenuId)
{
    var fromMenuDom = xoopsGetElementById(fromMenuId);
    var toMenuDom = xoopsGetElementById(toMenuId);
    for(var i=0; i < toMenuDom.options.length; i++) {
        toMenuDom.remove(toMenuDom.options[i]);
    }
    var index=0;
    for(var i=0; i < fromMenuDom.options.length; i++) {
         if(fromMenuDom.options[i].selected == true){
            var newOption = new Option(fromMenuDom.options[i].text, fromMenuDom.options[i].value);
            toMenuDom.options[index] = newOption;
            index++;
         }
    }
}
