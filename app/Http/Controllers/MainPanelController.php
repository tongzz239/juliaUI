<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class MainPanelController extends Controller
{	
    public function dashboard(){
		return view('dashboard', ['sidebarActive' => 1], ['headerActive' => 1]);
    }

    public function myChecks(){
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
        $checks = DB::table('checks')
            ->select('id', 'julias_check_id')
            ->where('user_id', $user_id[0]->id)
            ->get();
        foreach ($checks  as $check) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "9090",
                CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checks/".$check->julias_check_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "x-julia-token: 0657e0d0afd4b5fa4298d0ca3165650ab7aabf5711d62ac3d458bb6478b18971456592252e06c7ba7d0380bf8dde8666536f4472f3cb7416ee6d26595f0f1c95"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response);
                $arr[$check->julias_check_id]["id"]=$check->id;
                $arr[$check->julias_check_id]["repository"]=$response->resource_providers[0]->configuration->repository;
                $arr[$check->julias_check_id]["filter"]=$response->resource_providers[0]->configuration->filter;
                $arr[$check->julias_check_id]["created_at"]=$response->created_at;
                $arr[$check->julias_check_id]["state_id"]=$response->state->id;
                $arr[$check->julias_check_id]["julias_check_id"]=$check->julias_check_id;
            }

        }
        return view('myChecks', compact('arr'), ['sidebarActive' => 2, 'headerActive' => 1]);
    }

    public function similarities($julias_check_id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_PORT => "9090",
        CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checks/".$julias_check_id."/similarities",
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
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }else{
            $response = json_decode($response);
            foreach ($response  as $similarity) {
                //print_r($row);
                $similarities[$similarity->components[0]->id]["similarity"]=$similarity->similarity;
                $similarities[$similarity->components[0]->id]["first_resource_uri"]=$similarity->first_resource->uri;
                $similarities[$similarity->components[0]->id]["second_resource_uri"]=$similarity->second_resource->uri;
                $similarities[$similarity->components[0]->id]["julias_check_id"]=$julias_check_id;
                $similarities[$similarity->components[0]->id]["julia_similarity_id"]=$similarity->components[0]->id;
            }

            return view('similarities', compact('similarities'), ['sidebarActive' => 2, 'headerActive' => 1]);
        }
    }
    public function similarity($julias_check_id, $julia_similarity_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "9090",
        CURLOPT_URL => "http://localhost:9090/api/v1/plagiarism/checks/".$julias_check_id."/similarities/".$julia_similarity_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: c05780ed-37d4-5c4e-919e-db74d0a37d9b",
        "x-julia-token: 0657e0d0afd4b5fa4298d0ca3165650ab7aabf5711d62ac3d458bb6478b18971456592252e06c7ba7d0380bf8dde8666536f4472f3cb7416ee6d26595f0f1c95"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
            //print_r($response[0]->first_resource->content);



            $c = curl_init('http://markup.su/api/highlighter');
            curl_setopt_array($c, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'language=Java&theme=Active4D&source=' . urlencode($response[0]->first_resource->content)
            ));
            $highlighted1[0] = curl_exec($c);
            $info = curl_getinfo($c);
            curl_close($c);

            if ($info['http_code'] == 200 && $info['content_type'] == 'text/html') {
            //echo $response;
            } else {
            echo 'Error';
            }
            $c = curl_init('http://markup.su/api/highlighter');
            curl_setopt_array($c, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'language=Java&theme=Active4D&source=' . urlencode($response[0]->second_resource->content)
            ));
            $highlighted2[0] = curl_exec($c);
            $info = curl_getinfo($c);
            curl_close($c);

            if ($info['http_code'] == 200 && $info['content_type'] == 'text/html') {
            //echo $response;

            } else {
            echo 'Error';
            }
            $highlighted1[1] = $response[0]->first_resource->uri;
            $highlighted2[1] = $response[0]->second_resource->uri;

            return view('compare', ['highlighted1' => $highlighted1, 'highlighted2' => $highlighted2]);
        }
    }


    //Admin
    public function allUsers(){
		$users = DB::table('users')->get();
		return view('usersList', compact('users'), ['sidebarActive' => 1, 'headerActive' => 5]);
    }
    public function admins(){
        $users = DB::table('users')
            ->where('admin', TRUE)
            ->get();
        return view('usersList', compact('users'), ['sidebarActive' => 2, 'headerActive' => 5]);
    }
    public function ordinaryUsers(){
        $users = DB::table('users')
            ->where('admin', FALSE)
            ->get();
        return view('usersList', compact('users'), ['sidebarActive' => 3, 'headerActive' => 5]);
    }
    public function addNewUser(){
		return view('addNewUser', ['sidebarActive' => 4, 'headerActive' => 5]);
    }
    public function addNewUser2(Request $request){
		DB::table('users')->insert(
		    ['email' => $request->newUserEmail]
		);
		return view('userAdded', ['sidebarActive' => 4, 'headerActive' => 5]);
    }
}