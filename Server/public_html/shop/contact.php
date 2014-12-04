<?php
$page_title = 'fairtradeinspires.com - Contact Us';
include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
?>

  <div class="content">
  
              <h1>Contact us</h1>
<div style="margin:0 auto; width: 90%; height:70%; text-align:center;">
          <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.uk/maps/ms?hl=en&amp;ie=UTF8&amp;msa=0&amp;msid=109991970996685137187.0004854cab3dabde0bd50&amp;ll=54.597031,-5.923102&amp;spn=0.004351,0.00912&amp;z=16&amp;output=embed"></iframe>
          </div>

          
          <div style="margin:0 auto; width: 60em; text-align:center;">
          <p><br />
          You can use the form below to contact us or why not pop in and have a chat?<br />
We pride ourselves on being very welcoming and you can find where we are on the map above.<br />
Fridays between 9:30 and 15:00 in St. George's Market, Belfast.
</p>
</div>


<?php

function create_form(){
  if(isset($_SESSION['user']))
  {
	$name = "{$_SESSION['name']}";
	$email = "{$_SESSION['user']}";
  }
echo '
<form action="contact.php" method="post">
<table align="center">
<tr>
<td width="75"></td>
<td width="565"><fieldset>
<legend>Contact us here:</legend>
<table>
<tr>
  <td width="268" align="right">Name: </td><td width="283">';
	  echo '<input name="name" type="text" size="35" maxlength="40"';
  	  if (isset($_POST['name'])) {
		  echo 'value="' . $_POST['name'] . '"'; 
	  } else if (isset($_SESSION['name'])) {
		  echo 'value="' . $_SESSION['name'] . '"'; 
	  }
	  echo ' />';
  echo '
</td></tr>
<tr>
  <td align="right">Email: </td><td>';
	  echo '<input name="email" type="text" size="35" maxlength="60"';
  	  if (isset($_POST['email'])) {
		  echo 'value="' . $_POST['email'] . '"';
	  } else if (isset($_SESSION['user'])) {
		  echo 'value="' . $_SESSION['user'] . '"';
	  }
	  echo ' />';
  echo '
</td></tr>
<tr>
  <td align="right">Telephone: </td><td>';
	  echo '<input name="telephone" type="text" size="35" maxlength="11"';
  	  if (isset($_POST['telephone'])) {
		  echo 'value="' . $_POST['telephone'] . '"';
	  } else if (isset($_SESSION['telephone'])) {
		  echo 'value="' . $_SESSION['telephone'] . '"';
	  }
	  echo ' />';
  
  echo '
</td></tr>
<tr>
  <td height="20" align="right" valign="top">How would you like to be contacted? (if neccessary)</td>
  <td>
    <input name="contact" type="radio" value="email_me" checked="checked" />
    Email<br />
    <input type="radio" name="contact" value="phone_me" />
    Telephone</td>
</tr>
<tr>
  <td height="100" align="right" valign="top">Comments: </td><td>
  <textarea name="comment" cols="30" rows="5">';
  if (isset($_POST['comment'])) echo $_POST['comment'];
  echo '</textarea>
</td></tr>
</table>
</fieldset></td>
<td width="75"></td>
</tr>
<tr>
  <td></td>
  <td align="center">
    <input type="submit" name="submit" value="Submit" />
  </td>
  <td></td>
</tr>
</table>
<input type="hidden" name="submitted" value="1" />
</form>';
}

if (isset($_POST['submitted'])) 
{
	//Form has been submitted
	//Validation of form data
	if ((!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comment']))||(isset($_SESSION['user']))) 
	{
		echo '<div align="center"><p>';
		echo "Thank you for your comments, if required we will contact you ";
		if ($_POST['contact'] == 'email_me')
		{
			echo "at " . $_POST['email'] . ".</p></div>";
		} 
		else 
		{
			echo "on " . $_POST['telephone'] . ".</div>";
		}
		//send email
		$body = "Name: {$_POST['name']} \n\n" .
				"Comments: {$_POST['comment']}\n\n";
		//if(is_numeric($_POST['telephone'])) {
			$body .= "Telephone: {$_POST['telephone']} \n\n {$_POST['contact']}";
		//}
		$body = wordwrap($body, 70);
		mail('contact@fairtradeinspires.co.uk','Contact Form Fairtrade Inspires',$body,"From: {$_POST['email']}");
	} 
	else 
	{
		echo '<div style="color:red" align="center"><p>Please complete the form.</p></div>';
		create_form();
	}
	
}

//<!-- Start Main Content -->
if (!isset($_POST['submitted'])){
	create_form();
}
?>

    
    <div class="content_bottom">&nbsp;</div>
    <!-- end .content --></div>
  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
