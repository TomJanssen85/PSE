var imageWidth = 0;
var imageHeight = 0;
var isMovingSampleImage = false;
var mouseX = 0;
var mouseY = 0;

function loadSampleImage(){
	var imageURL = 'get/image.php?id=' + $('#image-id').val();
	imageURL += '&color=' + $('#printcolor').val();
	$('#sample-image-image').attr('src', imageURL);
}
function zoomImage(){
	var zoom = parseInt($('#image-zoom-value').val());
	$('#sample-image-image').width(imageWidth * (zoom / 10));
	$('#sample-image-image').height(imageHeight * (zoom / 10));
}
function prepareSampleImage(){
	$('.photochange').change(function(){
		loadSampleImage();
	});
	//Get width height
	$.getJSON('get/image.php?id=' + $('#image-id').val() + '&type=sizeonly', function(data){
		imageWidth = data.Width;
		imageHeight = data.Height;
		$('#sample-image').width(imageWidth).height(imageHeight);
		$('#sample-image-image').width(imageWidth).height(imageHeight);
	});
    $('#image-zoom').slider({
		min: 10,
		max: 80,
		step: 1,
		slide: function(event, ui) {
			$('#image-zoom-value').val(ui.value);
			zoomImage(ui.value);
		}
	});
	loadSampleImage();
	$('#sample-image').on('dragstart', function(event) {
		event.preventDefault();
	}).mousedown(function(){
		isMovingSampleImage = true;
	});
	$('*').mouseup(function(){
		isMovingSampleImage = false;
	});
	$(document).mousemove(function(event){
		if(isMovingSampleImage){
			var newX = parseInt($('#sample-image-image').css('margin-left')) + event.pageX - mouseX;
			var newY = parseInt($('#sample-image-image').css('margin-top')) + event.pageY - mouseY;
			if(newX > 0) newX = 0;
			else if($('#sample-image-image').width() < $('#sample-image').width() + newX * -1) newX = ($('#sample-image-image').width() - $('#sample-image').width()) * -1;
			if(newY > 0) newY = 0;
			else if($('#sample-image-image').height() < $('#sample-image').height() + newY * -1) newY = ($('#sample-image-image').height() - $('#sample-image').height()) * -1;
			$('#sample-image-image').css('margin-left', newX);
			$('#sample-image-image').css('margin-top', newY);
			$('#image-left-value').val(newX);
			$('#image-top-value').val(newY);
		}
		mouseX = event.pageX;
		mouseY = event.pageY;
	});
}