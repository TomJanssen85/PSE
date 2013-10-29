$(document).ready(function(){
	prepareLayout();
});
$(window).resize(function(){
	setDemensions();
});

function prepareLayout(){
	setDemensions();
}
function setDemensions(){
	$('div.center-div').css({
		position:'absolute',
		left: ($(window).width() - $('div.center-div').outerWidth())/2,
		top: ($(window).height() - $('div.center-div').outerHeight())/2
	});
}