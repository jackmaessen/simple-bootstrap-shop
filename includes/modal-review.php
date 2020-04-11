
<div class="modal" id="<?php echo $file_id.'-review'; ?>">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	
		<div class="modal-header">
			<h3 class="modal-title">Write a review for: <i><?php echo $title; ?></i></h3>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		
		</div>
		<div class="modal-body">

			<form id="review" action="" method="POST" role="form">	
						<!-- FILE_ID -->
						<input type="hidden" class="file_id" value="<?php echo $file_id; ?>" />
						<!-- NAME 	-->
						<div class="control-group form-group">
							<div class="controls">
								<input class="form-control name" name="name" type="text" placeholder="NAME">
							</div>
						</div>						
						<!-- MESSAGE	-->
						<div class="control-group form-group">	
							<div class="controls">															
								<textarea class="tinymce form-control custom-control message" onkeyup="countChar(this)" name="message" placeholder="MESSAGE (max characters: <?php echo $max_chars; ?>)"></textarea>
								
							</div>
						</div>
						<!-- CAPTCHA 	-->
						<div class="control-group form-group">
							<div class="controls captcha_image">
							  <img src="includes/captcha.php?rand=<?php echo rand(); ?>" id='captcha_image'>
							  <a href='javascript: refreshCaptcha();'>Refresh captcha</a>
							</div>
						</div>
						<div class="control-group form-group">
							<div class="controls">
							  <input class="form-control captcha" id="cf_captcha_input" type="text" name="captcha" placeholder="Enter captcha"  required>
							</div>
						</div>
					
						<button type="submit" id="cf-submit" name="submit_message" class="btn btn-primary">SUBMIT</button>							
					</form>	
					
		</div>
		<div class="modal-footer"></div>
	</div>

  </div>
</div>

