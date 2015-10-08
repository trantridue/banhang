<div id="header_information_public">
<?php
include 'header_information_public.php';
?>
</div>
<div id="header_information_private">
<?php
if ($commonUtil->isAdmin ())
	include 'header_information_private.php';
?>
</div>
