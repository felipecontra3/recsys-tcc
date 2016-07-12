<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
@if(empty($name))
<button id="btnface" onclick="myFacebookLogin()">Logar com Facebook</button>
@else
voce esta logado como {{ $name }}
@endif

<br />
<br />
@if(empty(session('twitter_username')))
<div id="btntwitter">
<label>Twitter</label><input type="text" name="twitterUser" />
<button onclick="TwitterLogin()">Pegar Twitter</button>
</div>
@else
    voce esta logado como {{ session('twitter_username') }}
@endif

<button onclick="obterDadosSociais()">Obter dados sociais</button>
<div id="l">

</div>
<div id="posts">

</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>
<script>

    function myFacebookLogin() {
        FB.login(function(){
            $.get('/save-facebook', [],  function(data){
                $('#btnface').after('<span>Voce esta logado como '+data.name+'</span>');
                $('#btnface').remove();
            }, 'json')
        }, {scope: ['user_posts', 'user_likes', 'user_friends']});
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '{{  env('FACEBOOK_APP_ID') }}',
            xfbml      : true,
            cookie     : true,
            version    : 'v2.6'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function TwitterLogin(){
        $.get('/save-twitter', {'twitterUser': $('input[name=twitterUser]').val()},  function(data){
            $('#btntwitter').after('<span>Voce esta logado como '+data.username+'</span>');
            $('#btntwitter').remove();
        }, 'json')
    }

    function obterDadosSociais(){

        $.blockUI({ message: 'Obtendo dados sociais' })


        $.get('/obter-dados-sociais', {},  function(data){
            $.unblockUI()
            $('#posts').html(JSON.stringify(data));
        }, 'json')
    }
</script>

</body>
</html>