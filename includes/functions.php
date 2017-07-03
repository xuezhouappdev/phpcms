<?php
function redirect_to ($new_location) {
header("Location: " . $new_location);
exit;
}


function mysql_prep($string) {
	global $connection;
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}


//confirm query;
function confirm_query($result_set) {
   	 if(!$result_set) {
   	 	die("Database query failed.");
   	 }
}


function form_errors($errors = array()) {
	$output = "";
	if(!empty ($errors)) {
		$output .= "</br><div class=\" error \" >";
		$output .= "Please fix the following errors: ";
		$output .= "<ul>";
		foreach ($errors as $key => $error) {
			$output .= "<li>";
			$output .= htmlentities($error);
			$output .= "</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}

	return $output;
}

//find all subjects.
function find_all_subjects() {
	global $connection;

	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible = 1 ";
	$query .= "ORDER BY position ASC";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	return $subject_set;
}


//find pages for all subjects.
function find_pages_for_subject($subject_id) {
	global $connection;

	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE visible = 1 ";
	$query .= "AND subject_id = {$safe_subject_id} ";
	$query .= "ORDER BY position ASC";
	$page_set = mysqli_query($connection, $query);
	confirm_query($page_set);

	return $page_set;
} // find_pages_for_subject($subject_id)  ends


//find subject by ID. 
function find_subject_by_id($subject_id) {
	global $connection;

	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id = {$safe_subject_id} ";
	$query .= "LIMIT 1";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);

	if ($subject_set) {
		$subject = mysqli_fetch_assoc($subject_set);
		return $subject;
    } 
    else {
    	return null;
    }

	
}  //find_subject_by_id() ends;


//find page by ID. 
function find_page_by_id($page_id) {
	global $connection;

	$safe_page_id = mysqli_real_escape_string($connection, $page_id);

	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE id = {$safe_page_id} ";
	$query .= "LIMIT 1";
	$page_set = mysqli_query($connection, $query);
	confirm_query($page_set);

	if ($page = mysqli_fetch_assoc($page_set)) {
		return $page;
    } 
    else {
    	return null;
    }

	
}  //find_page_by_id() ends;



 function find_selected_page() {

 	global $current_subject;
 	global $current_page;

		  if (isset($_GET["subject"])) {
		   //$selected_subject_id = $_GET["subject"];
		   $current_subject = find_subject_by_id($_GET["subject"]);
		   //$selected_page_id = null;
		   $current_page = null;
		} 
		  else if (isset($_GET["page"])) {
		   //$selected_subject_id = null;
		   $current_subject = null;
		   //$selected_page_id = $_GET["page"];
		   $current_page = find_page_by_id($_GET["page"]);
		} 
		   else {
		   //$selected_subject_id = null;
		   $current_subject = null;
		   //$selected_page_id = null;
		   $current_page = null;
		}

}



//populate navigation with subject array , or page arrary (if any)
function navigation($subject_array, $page_array) {

	$output = " <ul class=\"subjects\"> "; 
			
			$subject_set = find_all_subjects(); 
			while($subject = mysqli_fetch_assoc($subject_set)) {  //associate arrays 
	
		
		  $output .= "<li";
		  if ($subject_array && $subject["id"] == $subject_array["id"]) {
             $output .= " class= \"selected\" >";
		  } else {
		  	 $output .= ">";
		  }
		
		
				
		$output .= "<a href=\"manage_content.php?subject=";
        $output .= urldecode($subject["id"]);
        $output .= "\">";
		$output .= htmlentities($subject["menu_name"]); 
		$output .= "</a>";
	
		$page_set = find_pages_for_subject($subject["id"]);
		$output .= "<ul class=\"pages\">";

			
		while($page = mysqli_fetch_assoc($page_set)) {
			
		  $output .= "<li";
		  if ($page_array && $page["id"] == $page_array["id"]) {
             $output .= " class= \"selected\"> ";
		  } else {
		  	 $output .= ">";
		  }
		
		  $output .="<a href=\"manage_content.php?page=";
		  $output .= urldecode($page["id"]);
		  $output .="\">";
		  $output .= htmlentities($page["menu_name"]);
          $output .= "</a></li>";
		
		}
						
		 mysqli_free_result($page_set); 
		  $output .= "</ul></li>";
	
	}
	
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
}

?>