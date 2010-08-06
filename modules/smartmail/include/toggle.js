var AdHandler = Class.create();
AdHandler.prototype = {
    id: '',

    initialize: function() {

    },

    toggle: function(id) {
        this.id = id;
        var myAjax = new Ajax.Request('ad.php',
                            		{
                            			method: 'post',
                            			postBody: 'op=toggleactive&id=' + id + ' &ajax=1',
                            			onSuccess: this.handleResponse.bind(this)
                            		});
    },

    handleResponse: function(response) {
        el_id = 'ad_' + this.id;
        el = $(el_id);
        el.innerHTML = response.responseText;
    }
}

var handler = new AdHandler();

function toggleActive(id) {
    handler.toggle(id)
}