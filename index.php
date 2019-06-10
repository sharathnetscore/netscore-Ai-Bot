<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST')
{
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;

$account    = "TSTDRV1380373";
$email      = "sarath@netscoretech.com";
$pass       = "NetSuite@123";
$role_id    = "3"; // 3 is the standard role for administrator
$content_type = "text/plain";
$host = "https://rest.netsuite.com/app/site/hosting/restlet.nl?script=1729&deploy=1";
// Create Header using NetSuite credentials above  
$headerString = "Authorization: NLAuth nlauth_account=". $account . ", " .

                        "nlauth_email=" . $email . ", " .

                        "nlauth_signature=" . $pass . ", " .

                        "nlauth_role=" . $role_id . "\r\n".

                  "Host: rest.netsuite.com \r\n" .

                  "Content-Type:" . $content_type;  
$arrOptions = array(
        'http'=>array(
        'header'=> $headerString,
        'method'=>"GET",
        'timeout'=>300
        ));
$context = stream_context_create($arrOptions);
$soInternalID = 133215;
//urlencode ($text)
echo "Test NetSuite";
echo $text;

$responseNS = file_get_contents($host . "&text=".urlencode ($text), false, $context);
if (!$responseNS)
{
    echo "Error: Invalid Response."; 
} else 
{
	$speech=$responseNS;
	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
}
else
{
	echo "Not Allowed";
}
?>
