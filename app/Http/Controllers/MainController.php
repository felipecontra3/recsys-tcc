<?php

namespace App\Http\Controllers;

use Facebook\GraphNodes\GraphEdge;
use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{

    private $aRet = [];

    public function index(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, Request $request){
        try{
            $token = $request->session()->get('fb_token');
            $fb->setDefaultAccessToken($token);
            $response = $fb->get('/me');
            $name= $response->getGraphUser()->getField('name');

        } catch(\Exception $e){
            $name = null;

        }

        return view('index', compact('name'));
    }
    
    public function saveFacebook(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, Request $request){
        $token = (string) $fb->getJavaScriptHelper()->getAccessToken();

        $fb->setDefaultAccessToken($token);
        $response = $fb->get('/me');
        $name = $response->getGraphUser()->getField('name');

        $request->session()->put('fb_token', $token);
        return response()->json(['token'=>$token, 'name'=>$name]);
    }

    public function logoffFacebook(Request $request){
        $request->session()->forget('fb_token');
        return back();
    }

    public function saveTwitter(Request $request){
        $request->session()->put('twitter_username', $request->get('twitterUser'));
        return response()->json(['username'=>$request->get('twitterUser')]);
    }

    public function obterDadosSociais(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, Request $request){
        $facebookToken = $request->session()->get('fb_token');
        $twitterUsername = $request->session()->get('twitter_username');

        $aRet = [];

        $aRet['facebook'] = $this->getFeedFacebook($fb, $facebookToken);
        $aRet['twitter'] = $this->getFeedTwitter($twitterUsername);


        return $aRet;

    }


    private function getFeedFacebook(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, $token) {
        if(empty($token)) {
            return null;
        }

        $fb->setDefaultAccessToken($token);
        $response = $fb->get('/me?fields=name,email,gender,likes,posts&limit=1000');
        $group = $response->getGraphGroup();
        $user_name = $group->getField('name');
        $user_email = $group->getField('email');
        $user_gender = $group->getField('gender');

        return $this->getFeed($fb, $group->getField('posts'));


    }

    private function getFeed(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, GraphEdge $graphEdge)
    {

        foreach ($graphEdge as $status) {
            try {
                array_push($this->aRet, $status->asArray());
            } catch(\Exception $e){}

        }


        $next = $fb->next($graphEdge);

        if(null == $next) {
            return $this->aRet;
        }

        return $this->getFeed($fb, $next);


    }

    private function getFeedTwitter($username) {
        if(empty($username)) {
            return null;
        }
        return \Twitter::getUserTimeline(['screen_name' => $username,  'count' => 100, 'format' => 'json']);

    }



}
