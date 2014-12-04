<?php
$page_title = 'fairtradeinspires.com - Sign In';
include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
?>

<?php
$errors = array();
$sub = 0;
include('scripts/register.php');
?>

  <div class="content" style="text-align:center;">

  <h1>Sign in</h1>
  <form id="signin" name="signin" method="post" action="scripts/login.php">
    <table width="570" border="0">
    <?php
	if(isset($_GET['error'])) echo '<tr><td colspan="2" height="30px" valign="top">Invalid email and/or password.</td></tr>';
	?>
      <tr>
        <td width="260" align="right">Email Address:</td>
        <td width="300" align="left"><input type="text" name="txt_email" id="txt_email" /></td>
      </tr>
      <tr>
        <td align="right">Password:</td>
        <td align="left"><input type="password" name="txt_pass" id="txt_pass" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input name="signin" type="hidden" id="signin" value="1" />          <input type="submit" name="submit" id="submit" value="Sign in" /></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
  <h2>Not registered? Sign up now</h2>
  <?php build_form($fn,$ln,$email,$pass,$addr,$city,$county,$postcode,$pass_match,$errors_empty,$errors); ?>
  <p>&nbsp;</p>
  
  <div class="content_bottom">&nbsp;</div>
<!-- end .content --></div>
  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
