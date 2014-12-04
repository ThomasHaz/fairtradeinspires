
<?php
$valid = 0;
// Init cURL
$request = curl_init();

if(!strpos($_SESSION['tx'],$_GET['tx'])){
	$_SESSION['tx'] = $_GET['tx'];
}
if(!strpos($_SESSION['tx'],'alse123'))
{
	$_SESSION['tx'] = $_GET['tx'];
}

// Set request options
curl_setopt_array($request, array
(
  CURLOPT_URL => 'https://www.paypal.com/cgi-bin/webscr',
  CURLOPT_POST => TRUE,
  CURLOPT_POSTFIELDS => http_build_query(array
    (
      'cmd' => '_notify-synch',
      'tx' => $_SESSION['tx'],
      'at' => '7qHGituVQ3if22Ucvugv7dwPk9pXT_dWAnzT_YyrgnIL1RXnt_mOCYCbLe4'
    )),
  CURLOPT_RETURNTRANSFER => TRUE,
  CURLOPT_HEADER => FALSE,
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_CAINFO => 'cacert.pem',
));

// Execute request and get response and status code
$response = curl_exec($request);
$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);

// Close connection
curl_close($request);



if($status == 200 AND strpos($response, 'SUCCESS') === 0)
{
    // Further processing
	// Remove SUCCESS part (7 characters long)
$response = substr($response, 7);

// URL decode
$response = urldecode($response);

// Turn into associative array
preg_match_all('/^([^=\s]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
$response = array_combine($m[1], $m[2]);

// Fix character encoding if different from UTF-8 (in my case)
if(isset($response['charset']) AND strtoupper($response['charset']) !== 'UTF-8')
{
  foreach($response as $key => &$value)
  {
    $value = mb_convert_encoding($value, 'UTF-8', $response['charset']);
  }
  $response['charset_original'] = $response['charset'];
  $response['charset'] = 'UTF-8';
}

// Sort on keys for readability (handy when debugging)
ksort($response);
$valid = 1;
/*foreach($response as $k => $v){
	echo $k . ' - ' . $v . '<br />';
	
}
*/
}
else
{
    // Log the error, ignore it, whatever
	//echo 'Error';
}

?>