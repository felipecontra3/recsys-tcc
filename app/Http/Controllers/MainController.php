<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Facebook\GraphNodes\GraphEdge;
use Illuminate\Http\Request;
use \App\Avaliacao;

use App\Http\Requests;

class MainController extends Controller
{

    private $aRet = [];

    public function testeSpark(){
        $output = shell_exec('/dados/app/spark-1.6.2-bin-hadoop2.6/bin/spark-submit ~/Documentos/TCC/Experimento/ml_module/train_classifier_new.py');
        print $output;
    }

    public function treinarModelos(){
        $output = shell_exec('/dados/app/spark-1.6.2-bin-hadoop2.6/bin/spark-submit ~/Documentos/TCC/Experimento/ml_module/train_classifier_new.py');
        print $output;
    }

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

    public function logoffTwitter(Request $request){
        $request->session()->forget('twitter_username');
        return back();
    }

    public function obterDadosSociais(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, Request $request){

        $facebookToken = $request->session()->get('fb_token');
        $twitterUsername = $request->session()->get('twitter_username');

        $userData = [];
        $facebookData = $this->getFeedFacebook($fb, $facebookToken);
        $twitterData = $this->getFeedTwitter($twitterUsername);

        $userData['name'] = $facebookData['facebook_name'];
        $userData['gender'] = $facebookData['gender'];
        $userData['email'] = $facebookData['facebook_email'];
        $userData['facebook']['posts'] = $facebookData['posts'];
        $userData['facebook']['likes'] = $facebookData['likes'];
        $userData['twitter'] = $twitterData;

        \App\User::unguard();
        $user = \App\User::create($userData);
        \App\User::reguard();

        $this->obterRecomendacoes($user->_id);
        $userRec = \App\User::find($user->_id);
        
        return $userRec;

    }

    public function salvarNotaUsuario(Request $request){

        $iduser = $request->input('iduser');
        $idprod = $request->input('idprod');
        $nota = $request->input('nota');

        $user = \App\User::find($iduser);

        $avaliacao['idprod'] =  $idprod;
        $avaliacao['nota'] =  $nota;

        if(isset($user->avaliacoes)){
            $avaliacao_final = $user->avaliacoes;
        } else {
            $avaliacao_final = array();
        }

        $existe = false;
        foreach($avaliacao_final as $key=>$value){
            if( strcmp($value['idprod'], $idprod) == 0){
                $existe = true;
                $avaliacao_final[$key] = $avaliacao;
            }
        }
        if(!$existe){
            $avaliacao_final[] = $avaliacao;
        }

        $user->avaliacoes = $avaliacao_final;
        $user->save();

        return $user->id;

    }


    private function getFeedFacebook(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, $token) {

        if(empty($token)) {
            return null;
        }

        $fb->setDefaultAccessToken($token);

        $group = $fb->get("/me?fields=id,name,email,gender")->getGraphGroup();

        $initialDate = (new Carbon())->subMonths(3)->format('Y-m-d');
        $graphEdgePosts = $fb->get("/me/posts?since=$initialDate")->getGraphEdge();
        $graphEdgeLikes = $fb->get("/me/likes")->getGraphEdge();

        return array(
                    'facebook_id' => $group->getField('id'),
                    'facebook_name' => $group->getField('name'),
                    'gender' => $group->getField('gender'),
                    'facebook_email' => $group->getField('email'),
                    'posts' => $this->getFeed($fb, $graphEdgePosts, 0),
                    'likes' =>  $this->getFeed($fb, $graphEdgeLikes, 0));

    }


    private function getFeed(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb, GraphEdge $graphEdge, $i)
    {
        foreach ($graphEdge as $status) {
            try {
                $dados = $status->asArray();
                $dados['id_post'] = $i;
                array_push($this->aRet, $dados);
                $i++;
            } catch(\Exception $e){}

        }


        $next = $fb->next($graphEdge);

        if(null == $next) {
            return $this->aRet;
        }

        return $this->getFeed($fb, $next, $i);


    }

    private function getFeedTwitter($username) {
        if(empty($username)) {
            return null;
        }
        return json_decode(\Twitter::getUserTimeline(['screen_name' => $username,  'count' => 100, 'trim_user' => 1,'exclude_replies'=> 1, 'include_rts'=>0, 'format' => 'json']), true);

    }

    private function obterRecomendacoes($iduser){
        $output = shell_exec("/dados/app/spark-1.6.2-bin-hadoop2.6/bin/spark-submit ~/Documentos/TCC/Experimento/ml_module/make_prediction.py $iduser");
        print $output;
    }



}
