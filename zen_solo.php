<?php

//Zen Solo by David Gregg
//October 2011 and April 2012

//New features required:
//Show total users
//Filters to select Categories - dynamic dropdown preferred so need array(s)
//http://www.coremediadesign.co.uk/learn_web_design/free_web_design_tutorials/tutorial/array_drop_down_menu_php.html
//Lower frame will need to be converted to PHP and load same SQL. Transfers category as an ID to Zen.

//BUT how do I tell if a user is in a category??
//only display them retrospectively at end of sequence, if a course in Category
//display user and just the category course(s)

//use a $line variable and a flag $display

//Automatic range incrementation

//Loading Moodle Libraries
require_once("../config.php");
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/tag/lib.php');
require_once($CFG->dirroot.'/lib/dmllib.php');

require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/grade/lib.php');
require_once($CFG->dirroot.'/grade/querylib.php');

require_once($CFG->dirroot.'/mod/certificate/lib.php');

//Javascript table sort and UTF-8 character script
print '<script language="javascript" src="sorttable.js"></script> <meta http-equiv="content-type" content="text-html; charset=utf-8">';

//Load categories dynamically
$sql = "SELECT d.id, d.name 
		FROM {$CFG->prefix}course_categories d";

$categories = get_records_sql($sql);

if($categories){
$numberofcategories = count($categories);
	}
	else {echo("No categories found!".$CR);}



//URL course parameter
$userid     = optional_param('userid', 0, PARAM_INT);
$userfirst     = optional_param('firstname', "", PARAM_ALPHA);
$userlast     = optional_param('lastname', "", PARAM_ALPHA);
//$user2 = $user1;

//use a $line variable and a flag $display
$line = "";
$display = 0;


//Declare line ending variables
$CR = "<br /><br />";
$LF = "<br />";

//Declare blank entry variable
$be = '<td>-</td>';

echo '<strong>Zen (Single user version)</strong>'.$LF;

if ($userid !== 0){
	echo 'User ID: <strong>'.$user1.'</strong>'.$LF;
}

if (($userlast !== "") and ($userfirst !== "")){
	echo 'Username: <strong>'.$userfirst.' '.$userlast.'</strong>'.$LF;
}	

else if ($userlast !== ""){
	echo 'User Lastname: <strong>'.$userlast.'</strong>'.$LF;
}

echo 'Searching :<strong> '.$numberofcategories.'</strong> categories'.$CR;

//set up table of users, courses and certificates

echo('<table class="sortable" border="1" cellpadding="5" cellspacing="0">');
echo('<tr>');
echo('<th align="left">User ID</th>');
echo('<th align="left">First name</th>');
echo('<th align="left">Last name</th>');
echo('<th align="left">Email</th>');
echo('<th align="left">Country</th>');
echo('<th align="left">Course1</th>');
echo('<th align="left">C1</th>');
echo('<th align="left">Course2</th>');
echo('<th align="left">C2</th>');
echo('<th align="left">Course3</th>');
echo('<th align="left">C3</th>');
echo('<th align="left">Course4</th>');
echo('<th align="left">C4</th>');
echo('<th align="left">Course5</th>');
echo('<th align="left">C5</th>');
echo('<th align="left">Course6</th>');
echo('<th align="left">C6</th>');
echo('<th align="left">Course7</th>');
echo('<th align="left">C7</th>');
echo('<th align="left">Course8</th>');
echo('<th align="left">C8</th>');
echo('<th align="left">Course9</th>');
echo('<th align="left">C9</th>');
echo('<th align="left">Course10</th>');
echo('<th align="left">C10</th>');



//process user range for correct optional parameter

if ($userid !== 0){
//	echo $user1.$LF;
	echo'<tr>';
	//Get a user in range
	$sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.country
	       	FROM {$CFG->prefix}user u		
	        WHERE u.id = $userid";
        }

if (($userlast !== "") and ($userfirst !== "")){
//	$userlast = trim($userlast);
//	echo $userlast.' being processed...'.$LF;
	echo'<tr>';
	//Get a user in range
	$sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.country
	       	FROM {$CFG->prefix}user u		
	        WHERE u.lastname like '$userlast' and u.firstname like '$userfirst'";
}

else if ($userfirst !== ""){
//	$userlast = trim($userlast);
//	echo $userlast.' being processed...'.$LF;
	echo'<tr>';
	//Get a user in range
	$sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.country
	       	FROM {$CFG->prefix}user u		
	        WHERE u.firstname like '$userfirst'";
}

else if ($userlast !== ""){
//	$userlast = trim($userlast);
//	echo $userlast.' being processed...'.$LF;
	echo'<tr>';
	//Get a user in range
	$sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.country
	       	FROM {$CFG->prefix}user u		
	        WHERE u.lastname like '$userlast'";
}

$userlist = get_records_sql($sql);
if($userlist){
	$numberofuserrecords = count($userlist);
	echo '<strong>'.$numberofuserrecords.' located!</strong>'.$CR;
}
//complete record for unused account
else{
//	echo '<td>'.$usr.'</td><td>'.'Account'.'</td><td>'.'Unused'.'</td><td>'.'N/A'.'</td><td>'.'N/A'.'</td>'.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be;
	$line = '<td>'.'??'.'</td><td>'.'Account'.'</td><td>'.'Unused'.'</td><td>'.'N/A'.'</td><td>'.'N/A'.'</td>'.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be;
	}

foreach($userlist as $thisuser){
	if($thisuser->firstname == 'Guest User'){$thisuser->firstname = 'Guest'; $thisuser->lastname ='User';}
	if($thisuser->email == ''){$thisuser->email = 'Not set';}
//	echo '<td>'.$thisuser->id.'</td><td>'.$thisuser->firstname.'</td><td>'.$thisuser->lastname.'</td><td>'.$thisuser->email.'</td><td>'.$thisuser->country.'</td>';
	$line = '<td>'.$thisuser->id.'</td><td>'.$thisuser->firstname.'</td><td>'.$thisuser->lastname.'</td><td>'.$thisuser->email.'</td><td>'.$thisuser->country.'</td>';
	//echo $numberofuserrecords.' users';

	//get a user's courses begin
	$usercoursecount = 0;
    if ($mycourses = get_my_courses($thisuser->id, null, null, false, 21)) {
        foreach ($mycourses as $mycourse){
        	$usercoursecount++; 
			$coursecertificatecount = 0; $cid = 0;
//        	echo '<td>'.format_string($mycourse->shortname).'</td>';
			$line .= '<td>'.format_string($mycourse->shortname).'</td>';
			//count number of certificates on each course
			$certificateids = get_records('certificate', 'course', $mycourse->id);
			if($certificateids){$numberofcertificateids = count($certificateids);}	
			if($numberofcertificateids > 3){$numberofcertificateids = 3;}
			//count number of certificates awarded to this user, per course
			foreach($certificateids as $thiscertificateid){
				if($cid==3){}else{$cid++;}
				//Transfer Certificate ID to a variable
				if($cid == 1){
					$certificate = $thiscertificateid->id;
				}
				if($cid == 2){
					$certificate2 = $thiscertificateid->id;
				}
				if($cid == 3){
					$certificate3 = $thiscertificateid->id;
				}

//SQL Queries to Get Certificate Holders
//This query for Certificate 1 runs if there is at least 1 certificate and keeps existing arrays and variables
if($numberofcertificateids == 1 OR $numberofcertificateids == 2 OR $numberofcertificateids == 3){
$sql = "SELECT c.id, c.certificateid, c.userid
        FROM {$CFG->prefix}certificate_issues as c
		WHERE c.certificateid=$certificate AND c.userid=$thisuser->id ";
$certificatelist = get_records_sql($sql);
if($certificatelist){$coursecertificatecount++;}
}

//This query for Certificate 2 runs if there is at least 2 certificates
if($numberofcertificateids == 2 OR $numberofcertificateids == 3){
$sql = "SELECT c.id, c.certificateid, c.userid
        FROM {$CFG->prefix}certificate_issues as c
		WHERE c.certificateid=$certificate2 AND c.userid=$thisuser->id ";
$certificatelist2 = get_records_sql($sql);
if($certificatelist2){$coursecertificatecount++;}
}

//This query for Certificate 3 only runs if there are 3 certificates
if($numberofcertificateids == 3){
$sql = "SELECT c.id, c.certificateid, c.userid
        FROM {$CFG->prefix}certificate_issues as c
		WHERE c.certificateid=$certificate3 AND c.userid=$thisuser->id ";
$certificatelist3 = get_records_sql($sql);
if($certificatelist3){$coursecertificatecount++;}
}	
			} // end certificate ids for course
//			if($certificateids){echo '<td>'.$coursecertificatecount.':'.$numberofcertificateids.'</td>';} else {echo '<td>'.'0:0'.'</td>';}
if($certificateids){$line .= '<td>'.$numberofcertificateids.'</td>';} else {$line .= '<td>'.'0'.'</td>';}	
        } //end courses per user
   	} //end users in range
   	
	
	//These cases will need to include certificate numbers for each course 
/*	if($usercoursecount == 0) {echo $be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 1) {echo $be.$be.$be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 2) {echo $be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 3) {echo $be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 4) {echo $be.$be.$be.$be;}
	if($usercoursecount == 5) {echo $be.$be;} */  	

	if($usercoursecount == 0) {$line .= $be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 1) {$line .= $be.$be.$be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 2) {$line .= $be.$be.$be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 3) {$line .= $be.$be.$be.$be.$be.$be;}
	if($usercoursecount == 4) {$line .= $be.$be.$be.$be;}
	if($usercoursecount == 5) {$line .= $be.$be;}

	//get a user's courses end

//} //end thisuser
echo $line;
echo'</tr>';		
} //end thisuser
//} //end process user range

echo '</table>'.$LF;
echo '<strong>Zen has processed your request!</strong>'.$CR;
	
?>