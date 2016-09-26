<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TCC - Felipe Contratres</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Header -->
<header id="top" class="header">
    <div class="text-vertical-center">
        <h1 style='color: #ffffff'>Sistema de Recomendação</h1>
        <h3 style='color: #ffffff;font-weight: bold'>Utilizando Redes Sociais</h3>
        <br>
        <a href="#about" class="btn btn-dark btn-lg">Clique para seguir</a>
    </div>
</header>

<!-- About -->
<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Este Sistema de Recomendação foi construído como parte experimental do Trabalho de Conclusão de Curso de Felipe Contratres.</h2>
                <h2>O objetivo é avaliar técnicas para obter recomendações que utilizam dados obtidos através de duas grandes Redes Sociais da atualidade: <strong>Facebook</strong> e <strong>Twitter</strong>.</h2>
                <br /><br />
                <p class="lead">Para isto precisamos que você faça login com seu Facebook e que nos forneça seu usuário do Twitter. Caso não tenha algum deles, não se preocupe, apenas um já é suficiente.</p>
                <p class='lead'>O procedimento total leva cerca de 5 minutos.</p>
                <p class="lead">Antes de prosseguir, gostaria de agradecer a sua participação, sua ajuda é essencial para o sucesso deste trabalho. <strong>Muito obrigado!</strong></p>
                <a href="#login" class="btn btn-dark btn-lg">Prosseguir</a>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Services -->
<!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
<section id="login" class="services">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-10 col-lg-offset-1">
                <h2>Faça login com suas Redes Sociais</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <!-- Para ocupar o espaço -->
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                            <img src='img/facebook.png' />
                            </span>
                            <h4>
                                <strong>Facebook</strong>
                            </h4>
                            @if(empty($name))
                                <p>Clique abaixo para fazer login com seu Facebook</p>
                                <button href="#" class="btn btn-light" onclick="myFacebookLogin()">Fazer Login</button>
                            @else
                                Você está logado como {{ $name }}
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="service-item">
                            <img src='img/twitter.png' />
                            </span>
                            <h4>
                                <strong>Twitter</strong>
                            </h4>
                            @if(empty(session('twitter_username')))
                            <p>Insira seu usuário do Twitter.</p>
                            <input type='text' name="twitterUser"/>
                            <button href="#" class="btn btn-light" style="margin-top:3px"  onclick="TwitterLogin()">Verificar</button>
                            @else
                                Você está logado como {{ session('twitter_username') }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <!-- Para ocupar o espaço -->
                    </div>
                </div>
                <button class="btn btn-light">Gerar recomendações</button>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Callout -->
<aside class="callout">
    <div class="text-vertical-center">
        <h1>Vertically Centered Text</h1>
    </div>
</aside>


<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>Obrigado por sua participação!</strong></h4>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });

    function myFacebookLogin() {
        FB.login(function(){
            $.get('/save-facebook', [],  function(data){
                $('#btnface').after('<span>Você está logado como '+data.name+'</span>');
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
            $('#btntwitter').after('<span>Você está logado como '+data.username+'</span>');
            $('#btntwitter').remove();
        }, 'json')
    }

    function obterDadosSociais(){

        $.blockUI({ message: 'Obtendo dados sociais' });
        $.get('/obter-dados-sociais', {},  function(data){
            $.unblockUI()
            $('#posts').html(JSON.stringify(data));
        }, 'json')
    }

</script>

</body>

</html>
