<?PHP
require_once ("constant.php");

require_once ("fg_membersite.php");
require_once ("CommonUtil.php");
require_once ("UserService.php");
require_once ("ConfigService.php");
// Init connection
$connection = mysql_connect ( hostname, username, password );
// Select database 
mysql_select_db (database, $connection );
// Set encode
mysql_query ( "SET NAMES 'UTF8'", $connection );

$commonUtil = new CommonUtil ($connection);

$userService = new UserService ($commonUtil);
$configService = new ConfigService ($commonUtil);
$fgmembersite = new FGMembersite ($commonUtil);

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