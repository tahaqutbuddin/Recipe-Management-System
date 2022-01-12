<?php
require_once '../includes/class.login.php';
require 'Facebook/autoload.php'; 
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$facebook = new FacebookLogin;
$facebook_client = $facebook->getFBClient();
$helper = $facebook_client->getRedirectLoginHelper();
try 
{
    $accessToken = $helper->getAccessToken();
} 
catch(Facebook\Exception\ResponseException $e) 
{
    unset($facebook);
    // echo 'Graph returned an error: ' . $e->getMessage();
    // exit;
    header("Location:../login.php?error=7");
} 
catch(Facebook\Exception\SDKException $e) 
{
    unset($facebook);
    // echo 'Facebook SDK returned an error: ' . $e->getMessage();
    // exit;  
    header("Location:../login.php?error=7");
    
}



if (!isset($accessToken)) 
{
    if ($helper->getError()) 
    {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } 
    else 
    {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    unset($facebook);
    exit;
}else
{
    if(isset($accessToken))
    {
        if(isset($_SESSION['facebook_access_token']))
        {
            $facebook_client->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        else
        {
            $facebook->createLongLiveAccessToken($accessToken);
        }


        // Redirect the user back to the same page if url has "code" parameter in query string
        if(isset($_GET['code'])){
            header('Location: ./');
        }
        
        // Getting user's profile info from Facebook
        try 
        {
            $graphResponse = $facebook_client->get('/me?fields=name,first_name,last_name,email,link,gender,picture');
            $fbUser = $graphResponse->getGraphUser();
        } 
        catch(FacebookResponseException $e) 
        {
            unset($facebook);
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            header("Location: ../login.php");
            exit;
        } 
        catch(FacebookSDKException $e) 
        {
            unset($facebook);
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        if($facebook->validateData($fbUser)==true)
        {
            unset($facebook);
            header("Location: ../dashboard/index.php");
        }
        
        // Get logout url
        $logoutURL = $helper->getLogoutUrl($accessToken, FB_REDIRECT_URL.'logout.php');
    }
}
?>