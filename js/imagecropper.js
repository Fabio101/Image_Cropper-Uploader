$(document).ready(function(){
	var options = { 
		target:   '#img-upload-output', 
                beforeSubmit: function() {
		    	$('#img-file-upload').hide();
        		$('#img-file-crop').hide();
        		$('#img-file-input').hide();
        		$('#img-file-output').hide();
                $('#company_login').hide();
			    $('#img-upload-output').html("Uploading, please wait...");
                $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){	
                    	$("#progress-bar").width(percentComplete + '%');
                    	$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                },
                error:function (xhr, status, error) {
                    $('#img-upload-output').html("<b style='color:red;'>" + xhr.responseText + "</b></br>You may now close this window.");
                },
                success:function () {
                    	$('#img-upload-output').html("<b style='color:green;'>Image received in good order</b></br>You may now close this window.");
                },
                resetForm: true 
        };

	$('#img-crop-form').submit(function(){
		$(this).ajaxSubmit(options);
        	return false
	});

	$('#close').hide();
	$('#img-file-upload').hide();
    
    $("#company_login").on("click", function() {
        $(this).val("")
    });
});

//FUNCTIONS
function validateImage() {
	 if (window.File && window.FileReader && window.FileList && window.Blob) {
                if( !$('#img-file-input').val()) {
                        $('#img-upload-output').html("<b style='color:red;'>Error: No file selected</b></br>");
			return
                }

                var fileSize = $('#img-file-input')[0].files[0].size;
                var fileType = $('#img-file-input')[0].files[0].type;
                
                if (fileType != 'image/png' && fileType != 'image/jpeg') {
                        $('#img-upload-output').html("Selected File Type: " + fileType +"</br><b style='color:red;'>Error: File must be in .png OR .jpg format</b>");
			return
                }
        
                if (fileSize > 524288) {
                        $('#img-upload-output').html("Selected File Size: " + fileSize / 1000 +"KB</br><b style='color:red;'>Error: File must be less than 512KB in size</b>");
			return
                }

                var image = $('#img-file-input')[0].files[0];
                
                if ($("#company_login").val() === "" || $("#company_login").val() === "Company Login Name: ") {
                    $('#img-upload-output').html("<b style='color:red;'>Error: Enter a valid Company Login Name!</b>");
                    return
                } else {
                    renderImage(image);
                }

		$('#img-file-upload').hide();
        }
        else
        {
                $('#img-upload-output').html("<b>Error: Your current browser lacks HTML file API Support</b>");
		return
        }
}

function renderImage(file) {
	var dimensions = new FileReader;
	dimensions.readAsDataURL(file);

	dimensions.onload = function(event) { //omf
    		var image = new Image;

		image.src = dimensions.result;

    		image.onload = function() {
			if (image.width > 500 || image.height > 500 || image.width < 100 || image.height < 100) {
				$('#img-upload-output').html("Selected Image Width: " + image.width + "px</br>Selected Image Height: " + image.height + "px</br><b style='color:red;'>Error: </br>Max Width: 500px ; Max Height: 500px </br>Min Width: 100px ; Min Height: 100px")
			}
			else
			{
				var url = event.target.result;
				$('#img-upload-output').html("<b style='color:green;'>Click on your image to start cropping!</b>");
                		$('#img-file-output').html("<img id='img-file-cropme' src='" + url + "' />")
                		cropImage();
			}
    		};
	};
}

function showUpload() {
	$('#img-file-upload').show();
}

function hideUpload() {
	$('#img-file-upload').hide();
	$('#img-upload-output').html("<b style='color:green;'>Click on your image to start cropping!</b>");
}

function showCoords(c)
  {
	// Coordinate variables:
	$('#img-upload-output').show();
	$('#img-upload-output').html("<b>Cropping Coordinates :</b></br>X : " + c.x + "</br>Y : " + c.y + "</br>Width : " + c.w + "</br>Height : " + c.h);
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#width').val(c.w);
    $('#height').val(c.h);
  };

function cropImage() {
	//Starting Jcrop with numerous arguments...
	$(function() {
        	$('#img-file-cropme').Jcrop({
					onSelect: showUpload,
					minSize: [100, 100],
					maxSize: [500, 500], 
					onChange: showCoords, 
					onRelease: hideUpload});
	});
}