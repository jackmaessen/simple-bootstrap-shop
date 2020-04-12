<?php
// check login
session_start();
if(!isset($_SESSION['shop_login'])){
	header("Location: /login.php");
	exit();
}
?>
<div class="modal" id="<?php echo $file_id.'-edit'; ?>">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-header">
			<h3 class="modal-title">Edit: <i><?php echo $title; ?></i></h3>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		
		</div>
		<div class="modal-body">

			<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" role="form">	
				<input type="hidden" name="edit_file" value="edit" />
				
				<input type="hidden" name="file_id" value="<?php echo $file_id; ?>" />				
																																							
				<!-- category -->
				<div class="form-group">
				    <label>Category:</label>
				    <select class="selectbox form-control" name="set_category">
					    <option value="<?php echo $category; ?>" selected><?php echo $category; ?></option> <!-- set current category as default -->
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
				<!-- title -->
				<div class="form-group">
				    <label>Title:</label>
				    <input class="form-control" type="text" name="title" value="<?php echo $title; ?>" />
				</div>
				<!-- description -->
				<div class="form-group">
				    <label>Description:</label>
				    <textarea class="tinymce form-control" name="description" wrap="hard"><?php echo $description; ?></textarea>
				</div>
				<!-- price -->
				<div class="form-group">
				    <label>Price:</label>
				    <input class="form-control" type="text" name="price" value="<?php echo $price; ?>" />
				</div>
				<!-- reset votes -->
				<div class="form-check">
				    <label class="form-check-label">
					    <input type="checkbox" class="form-check-input" value="reset_votes" name="reset_votes">Reset Votes
				    </label>
				</div>
				<!-- reset ip's -->
				<div class="form-check">
				    <label class="form-check-label">
					    <input type="checkbox" class="form-check-input" value="reset_ip" name="reset_ip">Reset IP's for votes
				    </label>
				</div>
				<!-- main image -->
				<div class="form-group">
				    <label class="text-success">Current main image:</label>
				    <img src="<?php echo $main_image; ?>" width="100" />
				</div>
				<!-- replace main image -->
				<div class="form-group">
				    <label class="text-warning">Replace main image (single):</label>
				    <input type="hidden" name="current_main_image" value="<?php echo $main_image; ?>" /> <!-- current main image -->
					<input class="form-control-file-border" type="file" name="new_main_image" />
				</div>
				<!-- other images -->
				<div class="form-group">
				    <label class="text-success">Current other images:</label>
				    <?php foreach($image_array as $image) { ?>
					<img src="<?php echo $image; ?>" width="100" />
					<?php } ?>
				</div>
				<!-- replace other images -->
				<div class="form-group">
				    <label class="text-warning">Replace other images (multiple):</label>
				    <?php foreach($image_array as $image) { ?>
					<input type="hidden" name="current_image[]" value="<?php echo $image; ?>" /> <!-- current other images -->
					<?php } ?>
					<input class="form-control-file-border" type="file" name="new_image[]" multiple />
				</div>
								
				<br />
				
				<button class="btn btn-primary btn-block" type="submit" name="submit">Update</button>	
										
			</form>
					
		</div>
		<div class="modal-footer"></div>
	</div>

  </div>
</div>

