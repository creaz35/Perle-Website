<?= $this->Html->docType('html5') ?>
<html lang="en">
    <head>

        <?= $this->Html->charset() ?>
        <?= $this->Html->meta(
            'viewport',
            'width=device-width, initial-scale=1.0, maximum-scale=1.0'
        ) ?>

        <title>Perle | Vos eclats de rire</title>
        <meta name="author" content="Perle">
        <meta name="description" content="Une perle c'est comme une photo, mais ou la photo immortalise le moment, la perle immortalise l'éclat de rire.">
        <meta property="og:description" content="Une perle c'est comme une photo, mais ou la photo immortalise le moment, la perle immortalise l'éclat de rire.">
        <meta property="og:title" content="Perle | Vos eclats de rire">
        <meta name="twitter:description" content="Une perle c'est comme une photo, mais ou la photo immortalise le moment, la perle immortalise l'éclat de rire.">
        <meta name="twitter:title" content="Perle | Vos eclats de rire">

        <!-- Styles -->
        <?= $this->Html->css([
            'front-end/bootstrap.min.css',
            'front-end/font-awesome.min.css',
            'front-end/main.css',
            'front-end/animate.css',
            'front-end/responsive.css'
        ]) ?>

        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"> 

        <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->       
        <link rel="shortcut icon" href="favicon.ico">

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-86210056-1', 'auto');
          ga('send', 'pageview');

        </script>

    </head>
    <body>

        <?= $this->element('header') ?>

        <?= $this->fetch('content') ?>

        <?= $this->element('footer') ?>

        <?= $this->Html->script([
            'front-end/jquery.js',
            'front-end/bootstrap.min.js',
            'front-end/smoothscroll',
            'front-end/jquery.parallax.js',
            'front-end/coundown-timer.js',
            'front-end/jquery.scrollTo.js',
            'front-end/jquery.nav.js',
            'front-end/main.js'
        ]); ?>

        <!-- Vue JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>

        <?= $this->fetch('scriptBottom') ?>

        <!-- Facebook -->
        <div id="fb-root"></div>

    </body>
</html>