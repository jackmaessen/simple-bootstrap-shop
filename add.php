<?php 
// check login
session_start();
if(!isset($_SESSION['shop_login'])){
	header("Location: login.php");
	exit();
}

include('settings.php'); 


if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	
	// create dir entries and rating if not exists
	if (!is_dir('./data/entries/')) {
		mkdir('./data/entries/', 0777, true);
	}
	if (!is_dir('./data/rating/')) {
		mkdir('./data/rating/', 0777, true);
	}
	
	
	// set a unique id as name of txt file
	$unique_id = 'id-'.date('YmdHis');

	// category block
	if (isset($_POST['category'])) {		
		$category = $_POST['category'];	
	}

	// title block
	if (isset($_POST['title'])) {	
		if($_POST['title'] == ''){
			$title = '';
		} else {
			$title = htmlentities($_POST['title']);
		}
	}

	// price block
	if (isset($_POST['price'])) {	
		if($_POST['price'] == '') {
			$price = '';
		} else {
			$price = htmlentities($_POST['price']);
		}
	}

	// description block
	if (isset($_POST['description'])) {	
		if($_POST['description'] == '') {
			$description = '';
		} else {
			$description = $_POST['description'];
		}
	}

	
	// main image upload
	if(!empty($_FILES['main_image'])) {
		$filename = $_FILES['main_image']['name'];
		$rename_main_image = end(explode('.', $filename )); // strip name of the image
		$main_image_destination = 'uploads/mainimage_'  .uniqid(). '.' . $rename_main_image; // rename image with unique_id
		move_uploaded_file($_FILES['main_image']['tmp_name'] , $main_image_destination);
		$main_image = $main_image_destination;
	}
	
					
	// put form content in .txt file with linebreaks; unique_id first
	$input_form = $unique_id.PHP_EOL;
	$input_form .= $category.PHP_EOL;
	$input_form .= $title.PHP_EOL;
	$input_form .= $price.PHP_EOL;
	$input_form .= $description.PHP_EOL;
	$input_form .= $main_image.PHP_EOL;	
	
							
	$entryfile = 'data/entries/'.$unique_id.'.txt';
	//write data to file
	file_put_contents($entryfile,$input_form );
	

	// other images	upload; append to existing file
	$countfiles = count($_FILES['image']['name']);
			
	for($i=0; $i<$countfiles; $i++) {
		$filename = $_FILES['image']['name'][$i];
 
		$rename_image = end(explode('.', $filename )); // strip name of the image
 
		$image_destination = 'uploads/image_'  .uniqid(). '.' . $rename_image; // rename image with unique_id
		// Upload image
		move_uploaded_file($_FILES['image']['tmp_name'][$i] , $image_destination);
			
		$input_image = $image_destination.'||'; // seperate each image with ||
							
		// write images to txt file		
		file_put_contents($entryfile, $input_image, FILE_APPEND);
 
	}
		
	
	// create rating file
	$input_rating = 'star-1||0'.PHP_EOL;
	$input_rating .= 'star-2||0'.PHP_EOL;
	$input_rating .= 'star-3||0'.PHP_EOL;
	$input_rating .= 'star-4||0'.PHP_EOL;
	$input_rating .= 'star-5||0'.PHP_EOL;
		
	// Create ratingdata .txt file								
	$ratingfile = 'data/rating/'.$unique_id.'.txt';

	file_put_contents($ratingfile,$input_rating);
					
	$result = '<div class="alert alert-success w-100"><b>&check;</b>&nbsp;<b>'.$title.'</b> has been added!</div>';
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Site Title   -->
<title>Add-article</title>

<!-- Bootstrap css-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!-- jQuery core -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- API key for TinyMCE -->
<script src="https://cdn.tiny.cloud/1/cu9iuv1soi8lkx4dfa0qp167qpr7pw81y9rj9n42dvtj1mch/tinymce/5/tinymce.min.js"></script> 


</head>
<body>


<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-lg-9 my-4">               
				<div class="maincolumn">
				<?php echo $result; ?>
					<h5>Add an Article</h5>
					
					<div class="result"></div> <!-- ajax callback -->

					<a class="float-left" href="admin.php">Back to all articles</a>
					<br /><br />					
					
					<form name ="entry" id="entry" action="add.php" method="POST" role="form" enctype="multipart/form-data">
					
						<div class="control-group form-group">
							<select class="selectbox form-control" name="category">	
							<option value="" selected disabled>Choose category</option> 
							<?php 														
								$arr_length = count($all_categories); // count the number of categories							
								// show all categories														
								for ($x = 0; $x < $arr_length; $x++) {
							?>
							<option value="<?php echo $all_categories[$x]; ?>"><?php echo $all_categories[$x]; ?></option> 
							<?php 
							} 
							?>									 								
							</select>
						</div>
																		
						<div class="control-group form-group">
							<div class="controls">
								<input class="form-control firstname" name="title" type="text" placeholder="Title" required>
							</div>
						</div>
											
						<div class="control-group form-group">
							<div class="controls">
									<textarea class="tinymce form-control custom-control description" name="description" placeholder="Description"></textarea>						
							</div>
						</div>
						<div class="control-group form-group">
							<div class="controls">
								<input class="form-control number" name="price" type="text" placeholder="Price">
							</div>
						</div>
						<div class="control-group form-group">
							<div class="controls">
								Select <b>main image (single)</b> to upload: Max: <b>2 Mb</b> Allowed extensions: <b>jpg jpeg png gif</b>							
								<input type="file" name="main_image" class="image form-control-file border" />
							</div>
						</div>	
						<div class="control-group form-group">
							<div class="controls">
								Select <b>more images (multiple)</b> to upload: Max: <b>2 Mb</b> Allowed extensions: <b>jpg jpeg png gif</b>							
								<input type="file" name="image[]" class="image form-control-file border" multiple />
							</div>
						</div>						
																		
						<button type="submit" id="cf-submit" name="submit" class="btn btn-primary">SUBMIT</button>	
													
					</form>
											
				</div>
				
				
			</div> <!-- end col 9 -->
			<div class="col-md-3 col-lg-3 my-4">
				<div class="sidecolumn">
					<h5>Sidecolumn</h5>
						Place for some stuff here																				
				</div>
				
			</div>
						
		</div> <!-- end row -->
	</div> <!-- end container -->

</section>


<script>
//tiny texteditor
tinyMCE.init({
	selector : ".tinymce",
	plugins: "emoticons link preview wordcount",
	elementpath: false,
	
	menubar: false,
	toolbar: 'undo redo | bold italic underline | fontsizeselect | link | emoticons | preview | wordcount',
	  
	height: 300,
	force_br_newlines : true,
	force_p_newlines : false,
	forced_root_block : '',
	paste_as_text: true,
	
	mobile: {
		theme: 'silver',
		plugins: 'emoticons link preview wordcount',
		toolbar: 'undo redo | bold italic underline | fontsizeselect | link | emoticons | preview | wordcount'
	}	
	
});
      

</script>

</body>
</html>

