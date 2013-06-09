var u = '';
chrome.tabs.query({'active': true, 'windowId': chrome.windows.WINDOW_ID_CURRENT},
	function(tabs){
       	u = tabs[0].url;
	}
);
$(document).ready(function(){
	$('.share-this-boat').live('click',function(a){
		a.preventDefault();
		var o = {tags:$('input.tags').val(),url:u};
		$.ajax({
	        url: 'http://gitship.local/boat',
	        type: 'POST',
	        dataType: 'json',
	        data: o,
	        success: function(msg) {
	        	$('.inputs').hide();
	        	$('.success-text').html('Your boat has been docked! Thank you!').show();
	        },
	        error: function(){
	        	alert('An error occured while saving the boat.');
	        }
	    });
	});
});