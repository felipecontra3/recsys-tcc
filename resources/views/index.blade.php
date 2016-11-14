<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TCC - Felipe Contratres</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/stylish-portfolio.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">

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
                                <p id="textface">Clique abaixo para fazer login com seu Facebook</p>
                                <button id="btnface" class="btn btn-light" onclick="myFacebookLogin()">Fazer Login</button>
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
                            <p id="texttwitter">Insira seu usuário do Twitter.</p>
                            <input type='text' name="twitterUser"/>
                            <button id="btntwitter" class="btn btn-light" style="margin-top:3px"  onclick="TwitterLogin()">Verificar</button>
                            @else
                                Você está logado como {{ session('twitter_username') }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <!-- Para ocupar o espaço -->
                    </div>
                </div>
                <button class="btn btn-light" id="btnGerar" onclick="obterDadosSociais()">Gerar recomendações</button>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<aside id="recommendations" class="recommendations">
    <br /><br />
    <h3 style="text-align: center; margin: 50px" class="header-rec">Por favor, dê uma nota de 1 a 5 para as recomendações abaixo. Esta nota deve representar a sua afinadade com o produto e não a sua propensão de compra.</h3>
    <!--<div class="produto">
        <img class="produto-img" src="http://imagens.americanas.com.br/produtos/01/00/item/120723/4/120723449_1GG.jpg">
        <div class="rateYo" id="rateYo"></div>
        <p class="produto-titulo">DVD - Cocoricó: Muito Além da Visão</p>
        <p class="produto-descricao">DVD - Cocoricó: Muito Além da Visão Na escola as crianças estão com medo de Eurico, um aluno pouco mais velho que intimida Gabriel e depois os outros colegas da classe. As crianças tentam resolver o problema sozinhas, mas percebem que precisam da ajuda dos adultos. Esse e mais 4 episódios muito divertidos, que irão entreter a criançada. Imagem Meramente Ilustrativa.
    </div>-->

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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"></script>

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
        $('.header-rec').hide()
        @if(empty(session('twitter_username')) and (empty($name)))
            $('#btnGerar').hide()
        @endif
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
        $("#rateYo").rateYo({
            onSet: function (rating, rateYoInstance){
                //persistir a nota do usuario
            },
            fullStar: true
        });
    });

    function myFacebookLogin() {
        FB.login(function(){
            $.get('/save-facebook', [],  function(data){
                $('#textface').html('<span>Você está logado como '+data.name+'</span>');
                $('#btnface').remove();
                $('#btnGerar').show('slow')
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
            $('#texttwitter').html('<span>Você está logado como '+data.username+'</span>');
            $('#btntwitter').remove();
            $('input[name=twitterUser]').remove();
            $('#btnGerar').show('slow')
        }, 'json')
    }

    function obterDadosSociais(){
        $.blockUI({ message: 'Obrigado por participar. As recomendações estão sendo geradas para que você as avalie. Este processo pode demorar alguns minutos, agradeço muito a sua ajuda!' });
        $.get('/obter-dados-sociais', function(data){
            $('.header-rec').show('fast')
            $.unblockUI()
            $('html,body').animate({
                scrollTop: $("#recommendations").offset().top
            }, 3000);
            if(Object.keys(data.recomendacoes).length > 0){
                recs = [];
                $.each(data.recomendacoes, function(index, post){
                    if(Object.keys(post.products).length> 0){
                        $.each(post.products, function(i, prod){
                            recs.push(prod)
                        })
                    }
                });
                recs.sort(function(a,b){return b.cosineSimilarity-a.cosineSimilarity})
                recs = recs.slice(0,10);
                $.each(recs, function(i, prod){
                    gerarProdutoHtml(prod, data._id, i)
                })
            }
        }, 'json')
    }

    function gerarProdutoHtml(prod, iduser, i){

        div = document.createElement('div');
        img = document.createElement('img');
        p_titulo = document.createElement('p');
        p_desc = document.createElement('p');

        div_rate = document.createElement('div')

        $(div).addClass('produto')

        $(img).addClass('produto-img')
        if(prod.image != null){
            $(img).attr('src', prod.image)
        } else {
            $(img).attr('src', 'http://www.obusca.com.br/imovel/wp-content/themes/shandora/assets/images/sem-imagem.jpg')
        }


        $(p_titulo).addClass('produto-titulo')
        $(p_titulo).html(prod.nome)

        $(p_desc).addClass('produto-descricao')
        $(p_desc).html(prod.descricaoLonga.substring(0, 500))


        $(div_rate).addClass('rateYo')
        $(div_rate).attr('id', 'rate-'+i)

        $(div_rate).rateYo({
            onSet: function (rating, rateYoInstance) {
                $.ajax({
                    url: '/salvar-avaliacao',
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {idprod: prod.idprod, iduser: iduser, nota: rating, similaridade: prod.cosineSimilarity},
                    dataType: 'json',
                    success: function (r) {
                        console.log(r)
                    }
                })
            },

            fullStar: true
        });

        $(div).append(img)
        $(div).append(div_rate)
        $(div).append(p_titulo)
        $(div).append(p_desc)

        $('#recommendations').append(div)
    }

    function dynamicSort(property) {
        return function (obj1,obj2) {
            return obj1[property] > obj2[property] ? 1
                    : obj1[property] < obj2[property] ? -1 : 0;
        }
    }

    function dynamicSortMultiple() {
        /*
         * save the arguments object as it will be overwritten
         * note that arguments object is an array-like object
         * consisting of the names of the properties to sort by
         */
        var props = arguments;
        return function (obj1, obj2) {
            var i = 0, result = 0, numberOfProperties = props.length;
            /* try getting a different result from 0 (equal)
             * as long as we have extra properties to compare
             */
            while(result === 0 && i < numberOfProperties) {
                result = dynamicSort(props[i])(obj1, obj2);
                i++;
            }
            return result;
        }
    }
</script>

</body>

</html>
