<?php
// EDIT SETTINGS 

/*set your login username and pasword for admin.php*/
$admin_name = 'admin'; // admin username
$admin_passw = 'password1'; // admin password

$date_format = date('d M Y H:i'); // set date format; see: https://www.php.net/manual/en/datetime.formats.date.php
$entriesperpage = 6; // entries (articles) per page to show; 
$pagination_range = 2; // pagination_range of num links to show
$all_categories = array( // edit and add name of the categories to your own needs 
	'Friends',
	'Family',
	'Collegas',
	'Club',
	'Other1',
	'Other2',
	'undefined'
);
$valuta = '&euro;'; // set your own valuta
$allowed_ext = array('jpg','jpeg','png','gif'); // allowed extensions for image upload
$max_uploadsize = 2000000; // 2 Mb; max file-size for image upload
$max_chars = 1200; // max characters user can type for posting a review
$number_of_slides = 5; // number of images in the main slider on home/all categories

// filter search first letter Title's
$all_titles = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
?>