var getBoat = function(params) {
	$('.container .boat-out textarea').val('');
	$('.container .boat-out-error textarea').val('');
	$('.container .boat-out-error').hide();
	$('.container .boat-out').hide();
	$.ajax({
        url: '/boat',
        type: 'GET',
        dataType: 'json',
        data: params,
        success: function(msg) {
            if (typeof msg.total != "undefined" && !isNaN(msg.total) && msg.total == 1) {
            	var tpl = '![GitShip](%s)';
            	$('.container .boat-out').show();
            	$('.container .boat-out textarea').val(tpl.replace('%s', msg.boat.u));
            } else {
            	$('.container .boat-out-error').show();
            	$('.container .boat-out-error textarea').val("Sorry, the tags entered didn't make a ship come in.");
            }
        },
        error: function(){
        	$('.container .boat-out-error').show();
        	$('.container .boat-out-error textarea').val("An error occured while retrieving your boat.");
        }
    });
};
$(document).ready(function(){
	
	$('body').css({paddingBottom:($('footer').height() + 20)+30+"px"});
	
	$(".tagsinput").tagsInput();
	
	$('.get-boat').on('click',function(a){
		a.preventDefault();
		getBoat({tags:$('#tagsinput').val()});
	});
});