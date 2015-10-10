<?PHP
/*
    Registration/Login script from HTML Form Guide
    V1.0

    This program is free software published under the
    terms of the GNU Lesser General Public License.
    http://www.gnu.org/copyleft/lesser.html
    

This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

For updates, please visit:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html

*/
require_once ("class.phpmailer.php");
require_once ("formvalidator.php");

class FGMembersite {
	var $admin_email;
	var $from_address;
	
	var $username;
	var $pwd;
	var $database;
	var $tablename;
	var $connection;
	var $rand_key;
	
	var $error_message;
	
	var $commonUtil;
	
	//-----Initialization -------
	function FGMembersite($commonUtil) {
		$this->sitename = 'YourWebsiteName.com';
		$this->rand_key = '0iQx5oBk66oVZep';
		$this->commonUtil = $commonUtil;
	}
	
	function InitDB($host, $uname, $pwd, $database, $tablename) {
		
		$this->db_host = $host;
		$this->username = $uname;
		$this->pwd = $pwd;
		$this->database = $database;
		$this->tablename = $tablename;
	}
	function SetAdminEmail($email) {
		$this->admin_email = $email;
	}
	
	function SetWebsiteName($sitename) {
		$this->sitename = $sitename;
	}
	
	function SetRandomKey($key) {
		$this->rand_key = $key;
	}
	
	//-------Main Operations ----------------------
	function RegisterUser() {
		if (! isset ( $_POST ['submitted'] )) {
			return false;
		}
		
		$formvars = array ();
		
		if (! $this->ValidateRegistrationSubmission ()) {
			return false;
		}
		
		$this->CollectRegistrationSubmission ( $formvars );
		
		if (! $this->SaveToDatabase ( $formvars )) {
			return false;
		}
		
		if (! $this->SendUserConfirmationEmail ( $formvars )) {
			return false;
		}
		
		$this->SendAdminIntimationEmail ( $formvars );
		
		return true;
	}
	
	function ConfirmUser() {
		if (empty ( $_GET ['code'] ) || strlen ( $_GET ['code'] ) <= 10) {
			$this->HandleError ( "Please provide the confirm code" );
			return false;
		}
		$user_rec = array ();
		if (! $this->UpdateDBRecForConfirmation ( $user_rec )) {
			return false;
		}
		
		$this->SendUserWelcomeEmail ( $user_rec );
		
		$this->SendAdminIntimationOnRegComplete ( $user_rec );
		
		return true;
	}
	
	function Login() {
		if (empty ( $_POST ['username'] )) {
			$this->HandleError ( "UserName is empty!" );
			return false;
		}
		
		if (empty ( $_POST ['password'] )) {
			$this->HandleError ( "Password is empty!" );
			return false;
		}
		
		$username = trim ( $_POST ['username'] );
		$password = trim ( $_POST ['password'] );
		
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		if (! $this->CheckLoginInDB ( $username, $password )) {
			return false;
		}
		
		$_SESSION [$this->GetLoginSessionVar ()] = $username;
		
		return true;
	}
	
	function CheckLogin() {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		
		$sessionvar = $this->GetLoginSessionVar ();
		
		if (empty ( $_SESSION [$sessionvar] )) {
			return false;
		}
		return true;
	}
	
	function UserFullName() {
		return isset ( $_SESSION ['name_of_user'] ) ? $_SESSION ['name_of_user'] : '';
	}
	
	function UserEmail() {
		return isset ( $_SESSION ['email_of_user'] ) ? $_SESSION ['email_of_user'] : '';
	}
	
	function LogOut() {
		session_start ();
		
		$sessionvar = $this->GetLoginSessionVar ();
		
		$_SESSION [$sessionvar] = NULL;
		
		unset ( $_SESSION [$sessionvar] );
	}
	
	function EmailResetPasswordLink() {
		if (empty ( $_POST ['email'] )) {
			$this->HandleError ( "Email is empty!" );
			return false;
		}
		$user_rec = array ();
		if (false === $this->GetUserFromEmail ( $_POST ['email'], $user_rec )) {
			return false;
		}
		if (false === $this->SendResetPasswordLink ( $user_rec )) {
			return false;
		}
		return true;
	}
	
	function ResetPassword() {
		if (empty ( $_GET ['email'] )) {
			$this->HandleError ( "Email is empty!" );
			return false;
		}
		if (empty ( $_GET ['code'] )) {
			$this->HandleError ( "reset code is empty!" );
			return false;
		}
		$email = trim ( $_GET ['email'] );
		$code = trim ( $_GET ['code'] );
		
		if ($this->GetResetPasswordCode ( $email ) != $code) {
			$this->HandleError ( "Bad reset code!" );
			return false;
		}
		
		$user_rec = array ();
		if (! $this->GetUserFromEmail ( $email, $user_rec )) {
			return false;
		}
		
		$new_password = $this->ResetUserPasswordInDB ( $user_rec );
		if (false === $new_password || empty ( $new_password )) {
			$this->HandleError ( "Error updating new password" );
			return false;
		}
		
		if (false == $this->SendNewPassword ( $user_rec, $new_password )) {
			$this->HandleError ( "Error sending new password" );
			return false;
		}
		return true;
	}
	
	function ChangePassword() {
		if (! $this->CheckLogin ()) {
			$this->HandleError ( "Not logged in!" );
			return false;
		}
		
		if (empty ( $_POST ['oldpwd'] )) {
			$this->HandleError ( "Old password is empty!" );
			return false;
		}
		if (empty ( $_POST ['newpwd'] )) {
			$this->HandleError ( "New password is empty!" );
			return false;
		}
		
		$user_rec = array ();
		if (! $this->GetUserFromEmail ( $this->UserEmail (), $user_rec )) {
			return false;
		}
		
		$pwd = trim ( $_POST ['oldpwd'] );
		
		if ($user_rec ['password'] != md5 ( $pwd )) {
			$this->HandleError ( "The old password does not match!" );
			return false;
		}
		$newpwd = trim ( $_POST ['newpwd'] );
		
		if (! $this->ChangePasswordInDB ( $user_rec, $newpwd )) {
			return false;
		}
		return true;
	}
	
	//-------Public Helper functions -------------
	function GetSelfScript() {
		return htmlentities ( $_SERVER ['PHP_SELF'] );
	}
	
	function SafeDisplay($value_name) {
		if (empty ( $_POST [$value_name] )) {
			return '';
		}
		return htmlentities ( $_POST [$value_name] );
	}
	
	function RedirectToURL($url) {
		header ( "Location: $url" );
		exit ();
	}
	
	function GetSpamTrapInputName() {
		return 'sp' . md5 ( 'KHGdnbvsgst' . $this->rand_key );
	}
	
	function GetErrorMessage() {
		if (empty ( $this->error_message )) {
			return '';
		}
		$errormsg = nl2br ( htmlentities ( $this->error_message ) );
		return $errormsg;
	}
	//-------Private Helper functions-----------
	

	function HandleError($err) {
		$this->error_message .= $err . "\r\n";
	}
	
	function HandleDBError($err) {
		$this->HandleError ( $err . "\r\n mysqlerror:" . mysql_error () );
	}
	
	function GetFromAddress() {
		if (! empty ( $this->from_address )) {
			return $this->from_address;
		}
		
		$host = $_SERVER ['SERVER_NAME'];
		
		$from = "nobody@$host";
		return $from;
	}
	
	function GetLoginSessionVar() {
		$retvar = md5 ( $this->rand_key );
		$retvar = 'usr_' . substr ( $retvar, 0, 10 );
		return $retvar;
	}
	
	function CheckLoginInDB($username, $password) {
		if (! $this->DBLogin ()) {
			$this->HandleError ( "Database login failed!" );
			return false;
		}
		$username = $this->SanitizeForSQL ( $username );
		$pwdmd5 = md5 ( $password );
		$qry = "Select name, email, id from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y'";
		
		$result = mysql_query ( $qry, $this->connection );
		
		if (! $result || mysql_num_rows ( $result ) <= 0) {
			$this->HandleError ( "Error logging in. The username or password does not match" );
			return false;
		}
		
		$row = mysql_fetch_assoc ( $result );
		
		$_SESSION ['name_of_user'] = $row ['name'];
		$_SESSION ['email_of_user'] = $row ['email'];
		$_SESSION ['session_user_id'] = $row ['id'];
		
		return true;
	}
	
	function UpdateDBRecForConfirmation(&$user_rec) {
		if (! $this->DBLogin ()) {
			$this->HandleError ( "Database login failed!" );
			return false;
		}
		$confirmcode = $this->SanitizeForSQL ( $_GET ['code'] );
		
		$result = mysql_query ( "Select name, email from $this->tablename where confirmcode='$confirmcode'", $this->connection );
		if (! $result || mysql_num_rows ( $result ) <= 0) {
			$this->HandleError ( "Wrong confirm code." );
			return false;
		}
		$row = mysql_fetch_assoc ( $result );
		$user_rec ['name'] = $row ['name'];
		$user_rec ['email'] = $row ['email'];
		
		$qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
		
		if (! mysql_query ( $qry, $this->connection )) {
			$this->HandleDBError ( "Error inserting data to the table\nquery:$qry" );
			return false;
		}
		return true;
	}
	
	function ResetUserPasswordInDB($user_rec) {
		$new_password = substr ( md5 ( uniqid () ), 0, 10 );
		
		if (false == $this->ChangePasswordInDB ( $user_rec, $new_password )) {
			return false;
		}
		return $new_password;
	}
	
	function ChangePasswordInDB($user_rec, $newpwd) {
		$newpwd = $this->SanitizeForSQL ( $newpwd );
		
		$qry = "Update $this->tablename Set password='" . md5 ( $newpwd ) . "' Where  id=" . $user_rec ['id'] . "";
		
		if (! mysql_query ( $qry, $this->connection )) {
			$this->HandleDBError ( "Error updating the password \nquery:$qry" );
			return false;
		}
		return true;
	}
	
	function GetUserFromEmail($email, &$user_rec) {
		if (! $this->DBLogin ()) {
			$this->HandleError ( "Database login failed!" );
			return false;
		}
		$email = $this->SanitizeForSQL ( $email );
		
		$result = mysql_query ( "Select * from $this->tablename where email='$email'", $this->connection );
		
		if (! $result || mysql_num_rows ( $result ) <= 0) {
			$this->HandleError ( "There is no user with email: $email" );
			return false;
		}
		$user_rec = mysql_fetch_assoc ( $result );
		
		return true;
	}
	
	function SendUserWelcomeEmail(&$user_rec) {
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $user_rec ['email'], $user_rec ['name'] );
		
		$mailer->Subject = "Welcome to " . $this->sitename;
		
		$mailer->From = $this->GetFromAddress ();
		
		$mailer->Body = "Hello " . $user_rec ['name'] . "\r\n\r\n" . "Welcome! Your registration  with " . $this->sitename . " is completed.\r\n" . "\r\n" . "Regards,\r\n" . "Webmaster\r\n" . $this->sitename;
		
		if (! $mailer->Send ()) {
			$this->HandleError ( "Failed sending user welcome email." );
			return false;
		}
		return true;
	}
	
	function SendAdminIntimationOnRegComplete(&$user_rec) {
		if (empty ( $this->admin_email )) {
			return false;
		}
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $this->admin_email );
		
		$mailer->Subject = "Registration Completed: " . $user_rec ['name'];
		
		$mailer->From = $this->GetFromAddress ();
		
		$mailer->Body = "A new user registered at " . $this->sitename . "\r\n" . "Name: " . $user_rec ['name'] . "\r\n" . "Email address: " . $user_rec ['email'] . "\r\n";
		
		if (! $mailer->Send ()) {
			return false;
		}
		return true;
	}
	
	function GetResetPasswordCode($email) {
		return substr ( md5 ( $email . $this->sitename . $this->rand_key ), 0, 10 );
	}
	
	function SendResetPasswordLink($user_rec) {
		$email = $user_rec ['email'];
		
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $email, $user_rec ['name'] );
		
		$mailer->Subject = "Your reset password request at " . $this->sitename;
		
		$mailer->From = $this->GetFromAddress ();
		
		$link = $this->GetAbsoluteURLFolder () . '/resetpwd.php?email=' . urlencode ( $email ) . '&code=' . urlencode ( $this->GetResetPasswordCode ( $email ) );
		
		$mailer->Body = "Hello " . $user_rec ['name'] . "\r\n\r\n" . "There was a request to reset your password at " . $this->sitename . "\r\n" . "Please click the link below to complete the request: \r\n" . $link . "\r\n" . "Regards,\r\n" . "Webmaster\r\n" . $this->sitename;
		
		if (! $mailer->Send ()) {
			return false;
		}
		return true;
	}
	
	function SendNewPassword($user_rec, $new_password) {
		$email = $user_rec ['email'];
		
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $email, $user_rec ['name'] );
		
		$mailer->Subject = "Your new password for " . $this->sitename;
		
		$mailer->From = $this->GetFromAddress ();
		
		$mailer->Body = "Hello " . $user_rec ['name'] . "\r\n\r\n" . "Your password is reset successfully. " . "Here is your updated login:\r\n" . "username:" . $user_rec ['username'] . "\r\n" . "password:$new_password\r\n" . "\r\n" . "Login here: " . $this->GetAbsoluteURLFolder () . "/index.php\r\n" . "\r\n" . "Regards,\r\n" . "Webmaster\r\n" . $this->sitename;
		
		if (! $mailer->Send ()) {
			return false;
		}
		return true;
	}
	
	function ValidateRegistrationSubmission() {
		//This is a hidden input field. Humans won't fill this field.
		if (! empty ( $_POST [$this->GetSpamTrapInputName ()] )) {
			//The proper error is not given intentionally
			$this->HandleError ( "Automated submission prevention: case 2 failed" );
			return false;
		}
		
		$validator = new FormValidator ( );
		$validator->addValidation ( "name", "req", "Please fill in Name" );
		$validator->addValidation ( "email", "email", "The input for Email should be a valid email value" );
		$validator->addValidation ( "email", "req", "Please fill in Email" );
		$validator->addValidation ( "username", "req", "Please fill in UserName" );
		$validator->addValidation ( "password", "req", "Please fill in Password" );
		
		if (! $validator->ValidateForm ()) {
			$error = '';
			$error_hash = $validator->GetErrors ();
			foreach ( $error_hash as $inpname => $inp_err ) {
				$error .= $inpname . ':' . $inp_err . "\n";
			}
			$this->HandleError ( $error );
			return false;
		}
		return true;
	}
	
	function CollectRegistrationSubmission(&$formvars) {
		$formvars ['name'] = $this->Sanitize ( $_POST ['name'] );
		$formvars ['email'] = $this->Sanitize ( $_POST ['email'] );
		$formvars ['username'] = $this->Sanitize ( $_POST ['username'] );
		$formvars ['password'] = $this->Sanitize ( $_POST ['password'] );
	}
	
	function SendUserConfirmationEmail(&$formvars) {
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $formvars ['email'], $formvars ['name'] );
		
		$mailer->Subject = "Your registration with " . $this->sitename;
		
		$mailer->From = $this->GetFromAddress ();
		
		$confirmcode = $formvars ['confirmcode'];
		
		$confirm_url = $this->GetAbsoluteURLFolder () . '/confirmreg.php?code=' . $confirmcode;
		
		$mailer->Body = "Hello " . $formvars ['name'] . "\r\n\r\n" . "Thanks for your registration with " . $this->sitename . "\r\n" . "Please click the link below to confirm your registration.\r\n" . "$confirm_url\r\n" . "\r\n" . "Regards,\r\n" . "Webmaster\r\n" . $this->sitename;
		
		if (! $mailer->Send ()) {
			$this->HandleError ( "Failed sending registration confirmation email." );
			return false;
		}
		return true;
	}
	function GetAbsoluteURLFolder() {
		$scriptFolder = (isset ( $_SERVER ['HTTPS'] ) && ($_SERVER ['HTTPS'] == 'on')) ? 'https://' : 'http://';
		$scriptFolder .= $_SERVER ['HTTP_HOST'] . dirname ( $_SERVER ['REQUEST_URI'] );
		return $scriptFolder;
	}
	
	function SendAdminIntimationEmail(&$formvars) {
		if (empty ( $this->admin_email )) {
			return false;
		}
		$mailer = new PHPMailer ( );
		
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress ( $this->admin_email );
		
		$mailer->Subject = "New registration: " . $formvars ['name'];
		
		$mailer->From = $this->GetFromAddress ();
		
		$mailer->Body = "A new user registered at " . $this->sitename . "\r\n" . "Name: " . $formvars ['name'] . "\r\n" . "Email address: " . $formvars ['email'] . "\r\n" . "UserName: " . $formvars ['username'];
		
		if (! $mailer->Send ()) {
			return false;
		}
		return true;
	}
	
	function SaveToDatabase(&$formvars) {
		if (! $this->DBLogin ()) {
			$this->HandleError ( "Database login failed!" );
			return false;
		}
		if (! $this->Ensuretable ()) {
			return false;
		}
		if (! $this->IsFieldUnique ( $formvars, 'email' )) {
			$this->HandleError ( "This email is already registered" );
			return false;
		}
		
		if (! $this->IsFieldUnique ( $formvars, 'username' )) {
			$this->HandleError ( "This UserName is already used. Please try another username" );
			return false;
		}
		if (! $this->InsertIntoDB ( $formvars )) {
			$this->HandleError ( "Inserting to Database failed!" );
			return false;
		}
		return true;
	}
	
	function IsFieldUnique($formvars, $fieldname) {
		$field_val = $this->SanitizeForSQL ( $formvars [$fieldname] );
		$qry = "select username from $this->tablename where $fieldname='" . $field_val . "'";
		$result = mysql_query ( $qry, $this->connection );
		if ($result && mysql_num_rows ( $result ) > 0) {
			return false;
		}
		return true;
	}
	
	function DBLogin() {
		
		$this->connection = mysql_connect ( $this->db_host, $this->username, $this->pwd );
		
		if (! $this->connection) {
			$this->HandleDBError ( "Database Login failed! Please make sure that the DB login credentials provided are correct" );
			return false;
		}
		if (! mysql_select_db ( $this->database, $this->connection )) {
			$this->HandleDBError ( 'Failed to select database: ' . $this->database . ' Please make sure that the database name provided is correct' );
			return false;
		}
		if (! mysql_query ( "SET NAMES 'UTF8'", $this->connection )) {
			$this->HandleDBError ( 'Error setting utf8 encoding' );
			return false;
		}
		return true;
	}
	
	function Ensuretable() {
		$result = mysql_query ( "SHOW COLUMNS FROM $this->tablename" );
		if (! $result || mysql_num_rows ( $result ) <= 0) {
			return $this->CreateTable ();
		}
		return true;
	}
	
	function CreateTable() {
		$qry = "Create Table $this->tablename (" . "id INT NOT NULL AUTO_INCREMENT ," . "name VARCHAR( 128 ) NOT NULL ," . "email VARCHAR( 64 ) NOT NULL ," . "phone_number VARCHAR( 16 ) NOT NULL ," . "username VARCHAR( 16 ) NOT NULL ," . "password VARCHAR( 32 ) NOT NULL ," . "confirmcode VARCHAR(32) ," . "PRIMARY KEY ( id )" . ")";
		
		if (! mysql_query ( $qry, $this->connection )) {
			$this->HandleDBError ( "Error creating the table \nquery was\n $qry" );
			return false;
		}
		return true;
	}
	
	function InsertIntoDB(&$formvars) {
		
		$confirmcode = $this->MakeConfirmationMd5 ( $formvars ['email'] );
		
		$formvars ['confirmcode'] = $confirmcode;
		
		$insert_query = 'insert into ' . $this->tablename . '(
                name,
                email,
                username,
                password,
                confirmcode
                )
                values
                (
                "' . $this->SanitizeForSQL ( $formvars ['name'] ) . '",
                "' . $this->SanitizeForSQL ( $formvars ['email'] ) . '",
                "' . $this->SanitizeForSQL ( $formvars ['username'] ) . '",
                "' . md5 ( $formvars ['password'] ) . '",
                "' . $confirmcode . '"
                )';
		if (! mysql_query ( $insert_query, $this->connection )) {
			$this->HandleDBError ( "Error inserting data to the table\nquery:$insert_query" );
			return false;
		}
		return true;
	}
	function MakeConfirmationMd5($email) {
		$randno1 = rand ();
		$randno2 = rand ();
		return md5 ( $email . $this->rand_key . $randno1 . '' . $randno2 );
	}
	function SanitizeForSQL($str) {
		if (function_exists ( "mysql_real_escape_string" )) {
			$ret_str = mysql_real_escape_string ( $str );
		} else {
			$ret_str = addslashes ( $str );
		}
		return $ret_str;
	}
	
	/*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
	function Sanitize($str, $remove_nl = true) {
		$str = $this->StripSlashes ( $str );
		
		if ($remove_nl) {
			$injections = array ('/(\n+)/i', '/(\r+)/i', '/(\t+)/i', '/(%0A+)/i', '/(%0D+)/i', '/(%08+)/i', '/(%09+)/i' );
			$str = preg_replace ( $injections, '', $str );
		}
		
		return $str;
	}
	function StripSlashes($str) {
		if (get_magic_quotes_gpc ()) {
			$str = stripslashes ( $str );
		}
		return $str;
	}
	
	///START OUR DEV HERE:
	function isMobile() {
		$useragent = $_SERVER ['HTTP_USER_AGENT'];
		if (preg_match ( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match ( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr ( $useragent, 0, 4 ) )) {
			return true;
		} else {
			return false;
		}
	}
}
?>