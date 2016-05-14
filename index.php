<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
</head>
<!--FORMS-->
<body>
<div class="container-fluid">
  <div class="row">
    	<div class="col-sm-4">
		<h1 class="col-sm-4-heading">Crop and Upload your Image!</h1>
		<form id="img-crop-form" action="upload.php" method="post" enctype="multipart/form-data">
			</br>
    			<input id="img-file-input" type="file" class="form-control" name="fileToUpload">
                <br/>
                <input id="company_login" type="text" class="form-control" name="company_login" value="Company Login Name: ">
			</br>
			<div id="img-upload-output"></div>
			</br>
			<div id="progress-div"><div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:0%"></div></div>
			</br>    
			<input id="img-file-crop" value="SELECT IMAGE" type="button" name="fileToUpload" onclick="validateImage()" class="btn btn-default">
			<input id="img-file-upload" value="UPLOAD" type="submit" class="btn btn-default" name="submit">
			</br></br>
		</form>
	</div>
	<div id="img-file-output" class="col-sm-8"></div>
  </div>
</div>
</body>
<!--JAVASCRIPT-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.form.min.js"></script>
<script src="js/jquery.Jcrop.min.js"></script>
<script src="js/imagecropper.js"></script>
</html>
