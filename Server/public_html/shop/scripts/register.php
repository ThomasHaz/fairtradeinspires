<?php
$errors = array();
$fn = '*';
$ln = '*';
$email = '*';
$pass = '*';
$addr = '*';
$city = '*';
$county = '*';
$postcode = '*';
$pass_match = '*';
$errors_empty = 1;
if(isset($_POST['registered'])){
	//Check form data
	if(empty($_POST['fn'])) {
		$errors[] = 'No first name specified.';
		$fn = '<img src="images/layout/error.jpg" />';
	} else {
		$fn = '*';
	}
	if(empty($_POST['ln'])) {
		$errors[] = 'No last name specified.';
		$ln = '<img src="images/layout/error.jpg" />';
	} else {
		$ln = '*';
	}
	if(empty($_POST['email'])) {
		$errors[] = 'No email address specified.';
		$email = '<img src="images/layout/error.jpg" />';
	} else {
		$email = '*';
	}
	if(empty($_POST['pass1'])) {
		$errors[] = 'No password specified.';
		$pass = '<img src="images/layout/error.jpg" />';
	} else {
		$pass = '*';
	}
	if(empty($_POST['addr1'])) {
		$errors[] = 'No address specified.';
		$addr = '<img src="images/layout/error.jpg" />';
	} else {
		$addr = '*';
	}
	if(empty($_POST['city'])) {
		$errors[] = 'No city specified.';
		$city = '<img src="images/layout/error.jpg" />';
	} else {
		$city = '*';
	}
	if(empty($_POST['county'])) {
		$errors[] = 'No county specified.';
		$county = '<img src="images/layout/error.jpg" />';
	} else {
		$county = '*';
	}
	if(empty($_POST['postcode'])) {
		$errors[] = 'No postcode specified.';
		$postcode = '<img src="images/layout/error.jpg" />';
	} else {
		$postcode = '*';
	}
	if($_POST['pass2'] != $_POST['pass1']) {
		$errors[] = 'Your passwords did not match.';
		$pass_match = '<img src="images/layout/error.jpg" alt="Your passwords did not match." />';
	} else {
		$pass_match = '*';
	}
	
	if(empty($_POST['marketing'])) $marketing = 0;
	else $marketing = 1;
	
	if(empty($errors)){
	//Do database entries
	$query = 'INSERT INTO `users` (`email`,`fname`, `lname`, `pass`, `addr1`, `addr2`, `city`, `county`, `postcode`, `telephone`, `marketing`) VALUES (\'' . $_POST['email'] . '\',\'' . $_POST['fn'] . '\',\'' . $_POST['ln'] . '\',\'' . sha1($_POST['pass1']) . '\',\'' . $_POST['addr1'] . '\',\'' . $_POST['addr2'] . '\',\'' . $_POST['city'] . '\',\'' . $_POST['county'] . '\',\'' . $_POST['postcode'] . '\',\'' . $_POST['telephone'] . '\',\'' . $marketing . '\')';
	@mysqli_query($dbc, $query);
	} else { //errors not empty
		$errors_empty = 0;
	}
}



function build_form($fn,$ln,$email,$pass,$addr,$city,$county,$postcode,$pass_match,$errors_empty,$errors) {
	echo '<form id="register" name="register" method="post" action="signin.php">
    <table width="570" border="0">';
	if($errors_empty == 0) {
		echo '<tr><td colspan="1">&nbsp;</td><td colspan="3" align="left"><ul>';
		foreach($errors as $e) {
			echo '<li>' . $e . '</li>';
		}
		echo '</ul></td></tr>';
	}
    echo '<tr>
        <td colspan="2" align="right">First Name:</td>
        <td colspan="2" align="left"><input type="text" name="fn" id="fn" value="'; 
		if(isset($_POST['fn'])) echo $_POST['fn'];
		echo '" /> ' . $fn . ' 
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Last Name:</td>
        <td colspan="2" align="left"><input type="text" name="ln" id="ln" value="'; 
		if(isset($_POST['ln'])) echo $_POST['ln'];
		echo '" /> ' . $ln . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Email Address:</td>
        <td colspan="2" align="left"><input type="text" name="email" id="email" value="'; 
		if(isset($_POST['email'])) echo $_POST['email'];
		echo '" /> ' . $email . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Password:</td>
        <td colspan="2" align="left"><input type="password" name="pass1" id="pass1" /> ' . $pass . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Confirm Password:</td>
        <td colspan="2" align="left"><input type="password" name="pass2" id="pass2" /> ' . $pass_match . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Address line 1:</td>
        <td colspan="2" align="left"><input type="text" name="addr1" id="addr1" value="'; 
		if(isset($_POST['addr1'])) echo $_POST['addr1'];
		echo '" /> ' . $addr . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Address line 2:</td>
        <td colspan="2" align="left"><input type="text" name="addr2" id="addr2" value="'; 
		if(isset($_POST['addr2'])) echo $_POST['addr2'];
		echo '" /></td>
      </tr>
      <tr>
        <td colspan="2" align="right">City:</td>
        <td colspan="2" align="left"><input type="text" name="city" id="city" value="'; 
		if(isset($_POST['city'])) echo $_POST['city'];
		echo '" /> ' . $city . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">County:</td>
        <td colspan="2" align="left"><input type="text" name="county" id="county" value="'; 
		if(isset($_POST['county'])) echo $_POST['county'];
		echo '" /> ' . $county . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Postcode:</td>
        <td colspan="2" align="left"><input type="text" name="postcode" id="postcode" value="'; 
		if(isset($_POST['postcode'])) echo $_POST['postcode'];
		echo '" /> ' . $postcode . '
          </td>
      </tr>
      <tr>
        <td colspan="2" align="right">Telephone:</td>
        <td colspan="2" align="left"><input type="text" name="telephone" id="telephone" value="'; 
		if(isset($_POST['telephone'])) echo $_POST['telephone'];
		echo '" /></td>
      </tr>
      <tr>
        <td width="107" align="center">&nbsp;</td>
        <td colspan="2" align="center">Your information will not be shared with any 3rd parties however, should you wish to be contacted from time to time with news, offers and marketing information via email, please tick the following box.</td>
        <td width="47" align="left" valign="bottom"><input name="marketing" type="checkbox" id="marketing" value="1" /></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><input name="registered" type="hidden" id="registered" value="1" />          <input type="submit" name="sub_register" id="sub_register" value="Register" /></td>
      </tr>
    </table>
  </form>';
}


?>