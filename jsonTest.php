<?php 

# filename : jsonTest.php
# author   : george corser
# course   : cis355 (winter2016)
# overview : print fomatted output from a JSON object
# input    : api.svsu.edu/courses (a JSON API)
# output   : lists of courses

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	if($_GET['prefix'] != "" 
		|| $_GET['courseNumber'] != "" 
		|| $_GET['instructor'] != "" 
		) {
		echo "<h1>Schedule for Course</h1>";
		printCourse($_GET['prefix'], $_GET['courseNumber'], $_GET['instructor']);
	}
	else {
	
		printForm();
		
		echo "<h1>CIS/CS Courses at SVSU</h1>";

		echo "<h2>Spring</h2>";
		printSemester("16/SP");

		echo "<h2>Summer</h2>";
		printSemester("16/SU");

		echo "<h2>Fall</h2>";
		printSemester("16/FA");

		echo "<h2>Winter</h2>";
		printSemester("17/WI");
	
	}
	
}

#-----------------------------------------------------------------------------
function printForm(){
	
	echo "<form action='jsonTest.php'>";
	echo "Course Prefix (Department)<br/>";
	echo "<input type='text' name='prefix'><br/>";
	echo "Course Number<br/>";
	echo "<input type='text' name='courseNumber'><br/>";
	echo "Instructor<br/>";
	echo "<input type='text' name='instructor'><br/>";
	echo "<input type='submit' value='Submit'>";
	echo "</form>";

}

#-----------------------------------------------------------------------------
function printCourse($prefix, $courseNumber, $instructor){
	
	echo "<script>";
	echo "function goback(){";
	echo "window.location='http://csis.svsu.edu/~gpcorser/cis355/jsonTest.php'";
	echo "}";
	echo "</script>";
	
	$term = "16/SP";
	$string ="https://api.svsu.edu/courses?prefix=$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
	printListing($string);
	$term = "16/SU";
	$string ="https://api.svsu.edu/courses?prefix=$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
	printListing($string);
	$term = "16/FA";
	$string ="https://api.svsu.edu/courses?prefix=$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
	printListing($string);
	$term = "17/WI";
	$string ="https://api.svsu.edu/courses?prefix=$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
	printListing($string);
	
	echo "<br />";
	echo "<button onclick='goback()'>Back</button>";
	echo "<br />";
	echo "Note: Your browser's Back button is faster.";
	
}
	
#-----------------------------------------------------------------------------
function printSemester($term){
	
	$string ="https://api.svsu.edu/courses?prefix=CIS&term=$term";
	printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=CS&term=$term";
	printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=103&term=$term";
	printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=120A&term=$term";
	printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=120B&term=$term";
	printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=140&term=$term";
	printListing($string);
	// $string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=161&term=$term";
	// printListing($string);
	// $string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=223&term=$term";
	// printListing($string);
	$string ="https://api.svsu.edu/courses?prefix=MATH&courseNumber=300&term=$term";
	printListing($string);
	
}

#-----------------------------------------------------------------------------
function printListing($apiCall) {

	$json = file_get_contents($apiCall);
	$obj = $obj1 = json_decode($json);

	if (!($obj->courses == null)) {
		
		echo "<table border='3' width='100%'>";
		
		foreach ( $obj->courses as $course ) {
			
			if($course->meetingTimes[0]->instructor == "gpcorser")
				$printline = "<tr bgcolor='yellow'>";
			else
				$printline = "<tr>";
			$printline .= "<td width='5%'>"  . $course->prefix . "</td>";
			$printline .= "<td width='5%'>"  . $course->courseNumber . "</td>";
			$printline .= "<td width='5%'>"  . $course->term . "</td>";
			$printline .= "<td width='45%'>" . $course->title . "<br/>Prereqs: " . $course->prerequisites . "</td>";
			$printline .= "<td width='5%'>"  . $course->seatsAvailable . "</td>";
			$printline .= "<td width='5%'>"  . $course->meetingTimes[0]->days . "</td>";
			$printline .= "<td width='10%'>" . $course->meetingTimes[0]->startTime . "</td>";
			$printline .= "<td width='5%'>"  . $course->meetingTimes[0]->building . "</td>";
			$printline .= "<td width='5%'>"  . $course->meetingTimes[0]->room . "</td>";
			$printline .= "<td width='10%'>" . $course->meetingTimes[0]->instructor . "</td>";
			echo $printline;
			$printline = "</tr>";
			
		} // end foreach
		
		echo "</table>";
		echo "<br/>";
		
	} // end if (!($obj->courses == null))
		
} 

?>
