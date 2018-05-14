<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class AuthController extends Controller
{
	public function signin() 
	{
	  if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	  }

	  // Initialize the OAuth client
	  $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
	    'clientId'                => env('OAUTH_APP_ID'),
	    'clientSecret'            => env('OAUTH_APP_PASSWORD'),
	    'redirectUri'             => env('OAUTH_REDIRECT_URI'),
	    'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
	    'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
	    'urlResourceOwnerDetails' => '',
	    'scopes'                  => env('OAUTH_SCOPES')
	  ]);

	  // Generate the auth URL
	  $authorizationUrl = $oauthClient->getAuthorizationUrl();

	  // Save client state so we can validate in response
	  $_SESSION['oauth_state'] = $oauthClient->getState();

	  // Redirect to authorization endpoint
	  header('Location: '.$authorizationUrl);
	  exit();
	}
  public function logout()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $tokenCache = new \App\TokenStore\TokenCache;
    $tokenCache->clearTokens();
    return redirect()->route('greeting');
  }

	public function gettoken()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // Authorization code should be in the "code" query param
    if (isset($_GET['code'])) {
      // Check that state matches
      if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth_state'])) {
        exit('State provided in redirect does not match expected value.');
      }

      // Clear saved state
      unset($_SESSION['oauth_state']);

      // Initialize the OAuth client
      $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => env('OAUTH_APP_ID'),
        'clientSecret'            => env('OAUTH_APP_PASSWORD'),
        'redirectUri'             => env('OAUTH_REDIRECT_URI'),
        'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
        'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
        'urlResourceOwnerDetails' => '',
        'scopes'                  => env('OAUTH_SCOPES')
      ]);

      try {
        // Make the token request
        $accessToken = $oauthClient->getAccessToken('authorization_code', [
          'code' => $_GET['code']
        ]);

        // Save the access token and refresh tokens in session
        // This is for demo purposes only. A better method would
        // be to store the refresh token in a secured database

        $tokenCache = new \App\TokenStore\TokenCache;
        $tokenCache->storeTokens($accessToken->getToken(), $accessToken->getRefreshToken(),$accessToken->getExpires());
        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());
        $user = $graph->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();
        //Serch emain in database
        if(\DB::table('users')->where('email', $user->getMail())->exists()){
          // if exist redirect back to main page
          return redirect()->route('dashboard');
        }else{
          //if not found delete session
          $tokenCache->clearTokens();
          echo "No such user in database. <a href='/singin'>Try another user!</a>";
        }












      }
      catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        exit('ERROR getting tokens: '.$e->getMessage());
      }
      exit();
    }
    elseif (isset($_GET['error'])) {
      exit('ERROR: '.$_GET['error'].' - '.$_GET['error_description']);
    }
  }
}