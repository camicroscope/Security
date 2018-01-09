<?php
require_once('trusted_app_client.php');
require_once('google-api-php-client/src/Google/autoload.php');
//require_once('../config/security_config.php');
$config = require '../config.php';
session_start();
if (isset($_REQUEST['logIn'])) {
    $_SESSION['request_type'] = 'logIn';
} else if (isset($_REQUEST['logOut'])) {
    $_SESSION['request_type'] = 'logOut';
} else if (isset($_REQUEST['renew'])) {
    $_SESSION['request_type'] = 'renew';
} else {
    header('Location:../index.php');
    die();
}
error_log("request type: ".$_SESSION['request_type']);

function handleError($message, $die) {
    header("Location:../error.php?error=" . urlencode($error));
    error_log($error);
    if (isset($die) && $die) {
        die();
    }
}

function create_new_session($email, $name) {
    global $config
    $client = new TrustedApplicationClient();
    $client->initialize($config['bindaas_trusted_id'], $config['bindaas_trusted_secret'], $config['bindaas_trusted_url']);
    $_SESSION["email"] = $email;
    $_SESSION["username"] = $email;
    $_SESSION["name"] = $name;
    $_SESSION["last_seen"] = time();
    // grab API-Key from Bindaas
    try {
        $api_key = get_api_key($email, $client);
        if (isset($api_key)) {
            $_SESSION["api_key"] = $api_key;
        }
    } catch(ErrorException $exception) {
        handleError($exception -> getMessage(), FALSE);
        // TO DO: sign up situation; direct to sign up
    }
    if (!isset($_SESSION["api_key"])) {
        error_log("signing up new user...");
        error_log($_SESSION["email"]);
        error_log($_SESSION["name"]);
        echo 'signUp';
    } else {
        error_log("new session established ...");
        error_log($_SESSION["last_seen"]);
        error_log($_SESSION["email"]);
        error_log($_SESSION["name"]);
        echo "logIn";
    }
    die();
}


function get_api_key($email, $client) {
    try{
        $serverResponse = $client -> requestShortLivedKey($email);
        $serverResponse = json_decode($serverResponse , true);
        $apiKey = $serverResponse["api_key"];
        return $apiKey;
    }catch(Exception $e) {
        error_log("Unable to retrieve api_key for $email : " .$e->getMessage());
        return NULL;
    }
}

if ('logOut' === $_SESSION['request_type']) {
    error_log("logging out...");
    error_log($_SESSION["email"]);
    error_log($_SESSION["name"]);
    session_unset();
    error_log("log out completed");
    echo 'logged out';
    die();
}

$google_client = new Google_Client();
$google_client->setClientId($config['client_id']);
$google_client->setClientSecret($config['client_secret']);
$google_client->setRedirectUri($config['redirect_uri']);
$google_client->addScope('email');

/************************************************
 If asked to store the token, get a token and
 saveit to the session.
************************************************/
if ('logIn' === $_SESSION['request_type']) {
    /************************************************
     If we have a code back from the OAuth 2.0 flow,
    we need to exchange that with the authenticate()
    function. We store the resultant access token
    bundle in the session.
    ************************************************/
    if (isset($_POST['code'])) {
        $google_client->authenticate($_POST['code']);
        $_SESSION['access_token'] = $google_client->getAccessToken();
        error_log("token: ".$_SESSION['access_token']);
    }
}
if ('renew' === $_SESSION['request_type']) {
    /************************************************
     If we need to renew, try to keep the session alive.
     Requires that there's already an alive session less than an hour hld.
    ************************************************/
    if ($_SESSION["last_seen"] - time() < (60*60)) {
        // TODO is this necessary for bindaas, or does session_start(); cover all
        create_new_session($_SESSION["email"], $_SESSION["name"]);
        error_log("token: ".$_SESSION['access_token']);
    }
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an error
 ************************************************/
if (isset($_SESSION['access_token'])) {
    $google_client->setAccessToken($_SESSION['access_token']);
    $PlusService = new Google_Service_Plus($google_client);
    $me = new Google_Service_Plus_Person();
    $me = $PlusService->people->get('me');
    $PlusPersonEMails = new Google_Service_Plus_PersonEmails();
    $PlusPersonEMails = $me->getEmails();
    foreach($PlusPersonEMails as $em) {
        if($em->type === "account") {
            $user_email = $em->value;
            $user_email = strtolower($user_email);
        }
    }
    $user_id = $me->id;
    $user_name = filter_var($me->displayName, FILTER_SANITIZE_SPECIAL_CHARS);
    $_SESSION['token'] = $google_client->getAccessToken();
    $_SESSION['name'] = $user_name;
    $_SESSION['email'] = $user_email;
    create_new_session($user_email, $user_name);
    exit;
} else {
    header("HTTP/1.1 401 Bad token");
}
