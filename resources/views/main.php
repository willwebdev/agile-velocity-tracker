<!doctype html>
<html class="no-js" lang="">
    <head>
        <?php
        if (env("APP_ENV") == "production") {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-2405870-14"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-2405870-14');
        </script>
        <?php
        }
        ?>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="manifest" href="site.webmanifest">
        <!--<link rel="apple-touch-icon" href="icon.png">-->

        <!--<link rel="stylesheet" href="css/normalize.css">-->
        <link rel="stylesheet" href="/css/main.css">

        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="14a3e674-dc7b-49bd-88c2-f763bc7e18e4" type="text/javascript" async></script>
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div id="header">
            <a href="/">
                <img src="/images/clock.png" alt="icon" />
                <h1><?php echo $header; ?></h1>
            </a>
        </div>

        <!--<div id="top-nav">
            <div class="column-wrapper">
                <div class="column-content">
                    <a href="/">Home</a>
                    <?php
                    foreach ($menu as $item => $url) {
                        echo "<a href=\"{$url}\">{$item}</a>\n";
                    }
                    ?>
                </div>
            </div>
        </div>//-->

        <div class="column-wrapper">
            <div class="column-content">
                <?php echo $content; ?>
            </div>
        </div>

        <div id="footer">
            <span>&copy; copyright <?php echo date("Y"); ?> all rights reserved.</span>
            <a href="/legal">Terms &amp; privacy policy</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.4.0"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <script src="/js/main.js"></script>
    </body>
</html>