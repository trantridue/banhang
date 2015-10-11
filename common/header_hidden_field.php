<?php
if ($_SESSION [session_all_field] == null || $_SESSION ['session_all_field'] == '') {
	$commonUtil->initSessionParam ();
}
echo $commonUtil->initHiddenField ();

?>