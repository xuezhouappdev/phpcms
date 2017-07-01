 <?php require_once("../includes/db_connection.php"); ?>
 <?php require_once("../includes/functions.php"); ?>
 <?php require_once("../includes/layouts/header.php"); ?>

<?php
if (isset($_GET["subject"])) {
   $selected_subject_id = $_GET["subject"];
   $selected_page_id = null;
} else if (isset($_GET["page"])) {
   $selected_subject_id = null;
   $selected_page_id = $_GET["page"];
} else {
   $selected_subject_id = null;
   $selected_page_id = null;
}
?>


<div id="main">
  <div id="navigation">
		<?php 

		echo navigation($selected_subject_id, $selected_page_id);

		?>
  </div>
  <div id="page">
    <h2>Manage Content</h2> 
    <?php if($selected_subject_id) { 
    		echo $selected_subject_id; }
    	  elseif($selected_page_id) {
    	  	echo $selected_page_id;
    	  }
    	  else {
    	  	echo "Please select a subjet or a page"; 
    	  }

   


     ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
