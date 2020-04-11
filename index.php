<?php include 'settings.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Site Title   -->
<title>Simple Shop</title>

<!-- some basic styling -->
<link href="css/rating.css" rel="stylesheet">
<!-- Bootstrap css-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<!-- jQuery core -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <!-- Bootstrap js; need for modal --> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- API key for TinyMCE -->
<script src="https://cdn.tiny.cloud/1/cu9iuv1soi8lkx4dfa0qp167qpr7pw81y9rj9n42dvtj1mch/tinymce/5/tinymce.min.js"></script>

</head>
<body>
<!-- prevent form resubmission after refresh -->
<script>
if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
}


</script>

<section class="section">
    <div class="container">
        <div class="row">
		            			
			<div class="col-lg-3 my-4">
					

				<div class="list-group my-4">
					<a class="list-group-item" href="index.php">Home / All Categories</a>
				</div>
					
				<h4>Categories</h4>	
			
				<!-- filter form -->							
				<div class="list-group">
				<?php 
					$arr_length = count($all_categories); // count the number of categories
					for ($x = 0; $x < $arr_length; $x++) {
				?>
					<a href="index.php?filter_category=<?php echo $all_categories[$x]; ?>" class="list-group-item"><?php echo $all_categories[$x]; ?></a>
				<?php 
				} 
				?>				
				</div>
				<br />			
				
				<h4>Titles start with</h4>				
				<!-- filter form -->
				<form class="search-form" action="index.php" method="GET" role="form">
					<div class="input-group mb-3">					
						<select class="surname_selectbox form-control" name="filter_title">
							<?php 
								$arr_length = count($all_titles); // count the number of categories
								for ($x = 0; $x < $arr_length; $x++) {
							?>
							<option value="<?php echo $all_titles[$x]; ?>"><?php echo $all_titles[$x]; ?></option>
							<?php 
							} 
							?>									 								
						</select>
						<div class="input-group-append">		
							<button class="btn btn-primary" type="submit">Filter</button>
						</div>	
					</div>							
				</form>
				<br />
				
				<h4>Search Article</h4>				
				<!-- search form -->
				<form class="search-form form-inline" action="index.php" method="GET" role="form">	
					<div class="input-group mb-3">
						<input class="form-control" type="text" name="entry_search" placeholder="Search for..." />
						<div class="input-group-append">				
							<button class="btn btn-primary" type="submit">Search</button>
						</div>
					</div>							
				</form>
				
															
			</div> <!-- end col 3-->
			
			<div class="col-lg-9 my-4"> 
			
				<div class="result my-4"></div>	<!-- ajax callback -->
				
				<?php include "entries.php"; ?>
				<div class="clearfix"></div><br />											
				
				<?php include 'includes/pagination.php'; ?>
								
			</div> <!-- end col 9 -->
			
						
		</div> <!-- end row -->
	</div> <!-- end container -->
	
</section>



<div class="toast" data-autohide="false">
  <div class="toast-header">
    <strong class="mr-auto text-primary">Thanks for voting!</strong>    
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
  </div>
 
</div>

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


function equal_height() {   
	// Equal Card Height, Text Height and Title Height
	$('.equalheight').jQueryEqualHeight('.card .card-body .card-title');
	$('.equalheight').jQueryEqualHeight('.card .card-body .card-text');
	$('.equalheight').jQueryEqualHeight('.card');
}
$(window).on('load', function(event) {
	equal_height();
});

$(window).resize(function(event) {
	equal_height();
});

//Refresh Captcha
function refreshCaptcha(){
    var img = document.images['captcha_image'];
    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}

// ajax rating stars
$('.click-trigger').on('click', function(e) {
	e.preventDefault();
	
	let $star = $(this);
    let $container = $star.closest('.rating-stars');
	$.ajax({
		url: 'counter.php',
		type: 'POST',
		data: {	
				value: $star.data('value'),
				file_id: $container.data('id')		
			},
		success: function(data){
			$container.closest('.card-footer').html(data);			
		}
	});

});

// ajax write review		
$('#review').on('submit', function(e){
	e.preventDefault();
	tinyMCE.triggerSave(); // save TinyMCE instances before sending data
	
	var file_id = $(".file_id").val();
	var name = $(".name").val();
	var message = $(".message").val();
	var captcha_image = $("#captcha_image").val();
	var captcha = $(".captcha").val();
	
	$.ajax({
		url: 'write_review.php',
		type: 'POST',
		data: {
			    file_id:file_id,
				name:name,				
				message:message,
				captcha_image:captcha_image,
				captcha:captcha
				
				},

		success: function(data){
			$('.result').html(data);
			$('.modal').modal('hide'); // close modal
			$(".review-body").load(" .review-body > *"); // reload div review-body from reviews
			$(".captcha_image").load(" .captcha_image"); // reload captcha image
			
		},
		complete:function(){
            $('body, html').animate({scrollTop:$('.result').offset().top}, 'slow');		   
        }
	});

});


</script>

<?php if($_GET['filter_category'] != NULL) { ?>
<script>
// add class "acitve" to list-group for chosen category
$('.list-group-item:contains("<?php echo $_GET['filter_category']; ?>")').addClass('active');
</script>
<?php } ?>


</body>
</html>

