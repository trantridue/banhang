<?PHP
require_once ("constant.php");

require_once ("fg_membersite.php");
// MODEL
require_once ("model/field.php");
require_once ("model/subModule.php");
require_once ("model/module.php");
require_once ("model/moduleSubModule.php");
require_once ("model/userModule.php");
require_once ("model/user.php");
require_once ("model/table.php");
require_once ("model/column.php");
// UTIL
require_once ("Util.php");
// SERVICE
require_once ("CommonService.php");
require_once ("UserService.php");
require_once ("ConfigService.php");

// Init connection
$connection = mysql_connect ( hostname, username, password );
// Select database 
mysql_select_db ( database, $connection );
// Set encode
mysql_query ( "SET NAMES 'UTF8'", $connection );

$util = new Util ( );
$commonService = new CommonService ( $connection, $util );

$userService = new UserService ( $commonService, $util );
$configService = new ConfigService ( $commonService, $util );
$fgmembersite = new FGMembersite ( $commonService, $util );

//Provide your site name here
$fgmembersite->SetWebsiteName ( 'trantridue.com' );

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail ( 'trantridue@gmail.com' );

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB ( hostname, username, password, database, tablename );

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey ( 'qSRcVS6DrTzrPvr' );

?>