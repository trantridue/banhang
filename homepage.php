<?PHP
ob_start();
//session_start ();
require_once ("./include/membersite_config.php");
if (! $fgmembersite->CheckLogin ()) {
	$fgmembersite->RedirectToURL ( "index.php" );
	exit ();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>BANHANG_ZABUZA</title>
<link rel="STYLESHEET" type="text/css" href="style/stylesheet.css">
<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">


<link href="style/jquery.dataTables.css" rel="stylesheet">

<script src="scripts/jquery-1.11.1.min.js"></script>
<script src="scripts/jquery.dataTables.min.js"></script>
<script src="scripts/datatables.js"></script>
<script src="scripts/ui.js"></script>
<script src="scripts/jquery.datetimepicker.js"></script>

<script src="scripts/validator.js"></script>
<script src="scripts/input-validator.js"></script>
<link rel="stylesheet" href="style/jquery.datetimepicker.css">
<link rel="stylesheet" href="style/jquery-ui.css">
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/script.js"></script>
<script src="scripts/calculator.js"></script>
<script src="scripts/jquery.confirm.js"></script>
<link rel="stylesheet" type="text/css" href="style/jquery.confirm.css" />

</head>
<body>
<div id="bodywrapper">
<div id="header">
<?php
include 'common/header.php';
?> 
</div>
<hr>


<div id="body">BODY</div>
<hr>


<div id="footer">FOOTER</div>
</div>
</body>
</html>
