
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="manifest" href="site.webmanifest">
        <!--<link rel="apple-touch-icon" href="icon.png">-->

        <!--<link rel="stylesheet" href="css/normalize.css">-->
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div id="header">
            <img src="/images/clock.png" alt="icon" />
            <h1><?php echo $header; ?></h1>
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

                <div id="feedback">
                    <hr />
                    <span>Tell us what you think about this tool. Is it helpful? What features should we add next?</span>
                    <form method="post" action="/submit-feedback">
                        <textarea name="feedback"></textarea><br />
                        <button><img src="/images/feedback.png" alt="icon" /> Send feedback</button>
                    </form>
                </div>
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

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID.
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
        -->
    </body>
</html>
