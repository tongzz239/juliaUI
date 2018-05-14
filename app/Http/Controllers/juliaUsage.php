<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class juliaUsage extends Controller
{	
	public function juliaUsage(Request $request){
		//Login 
		/*
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "9090",
			CURLOPT_URL => "http://localhost:9090/api/v1/user/login",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\"email\": \"bernjakov@gmail.com\", \"password\": \"qwerty\"}",
			CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$api_token = json_decode($response)->api_token;
		}
		*/


		//checksuites

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_PORT => "9090",
		CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checksuites",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS => "{\"name\": \"test\",\"resource_providers\": [{\"name\": \"git\",\"configuration\": {\"repository\": \"".$request->link."\",\"filter\":\"".$request->regularExpression."\"}}],\"plagiarism_services\": [{\"name\": \"moss\"}]}",
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: application/json",
		"x-julia-token: 0657e0d0afd4b5fa4298d0ca3165650ab7aabf5711d62ac3d458bb6478b18971456592252e06c7ba7d0380bf8dde8666536f4472f3cb7416ee6d26595f0f1c95"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$id = json_decode($response)->id;
		}



		//Start

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_PORT => "9090",
		CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checksuites/".$id."/run",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"X-Julia-Token: 0657e0d0afd4b5fa4298d0ca3165650ab7aabf5711d62ac3d458bb6478b18971456592252e06c7ba7d0380bf8dde8666536f4472f3cb7416ee6d26595f0f1c95"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$id = json_decode($response)->id;
	        if (session_status() == PHP_SESSION_NONE) {
	            session_start();
	        }
	        $tokenCache = new \App\TokenStore\TokenCache;
	        $graph = new Graph();
	        $graph->setAccessToken($tokenCache->getAccessToken());
	        $user = $graph->createRequest('GET', '/me')
				->setReturnType(Model\User::class)
				->execute();
			$user_id = DB::table('users')
				->select('id')
				->where('email', $user->getUserPrincipalName())
				->get();
			DB::table('checks')->insert(
				['julias_check_id' => $id, 'user_id' => $user_id[0]->id]
			);
		}


		//Return similarities

		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_PORT => "9090",
		CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checks/".$id."/similarities",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"X-Julia-Token: 0657e0d0afd4b5fa4298d0ca3165650ab7aabf5711d62ac3d458bb6478b18971456592252e06c7ba7d0380bf8dde8666536f4472f3cb7416ee6d26595f0f1c95"
		),
		));

		$r = FALSE;
		while($r != TRUE) {
			$response = curl_exec($curl);
			$err = curl_error($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			}else{
				if ($response == "[]") {
					sleep(1);
				}else{
					$r = TRUE;
					return $response;
					$a = json_decode($response);

					//echo $a[0]->first_resource[0]->uri;
					//echo $a[0]->second_resource[0]->uri;
					//echo $a[0]->first_resource->uri;
					//echo $a[0]->second_resource->uri;
					foreach($a as $value) {
					    //echo "<a target='_blank' href='".$value->components[0]->extra->moss_link."'>".$value->first_resource->uri." AND ".$value->second_resource->uri."</a><br>" ;
					}

					//print_r($a[0]->components[0]->extra->moss_link);
				}
			}
		}
    }
    
}
