<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laravel-admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <!-- Bootstrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="/fonts/fonts.css?family=Open+Sans:400,300,700,800,400italic">
    <!-- Stroke 7 font by Pixeden (http://www.pixeden.com/icon-fonts/stroke-7-icon-font-set)-->
    <link rel="stylesheet" href="css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="css/helper.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.green.css" id="theme-stylesheet">
    <!-- owl carousel-->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <!-- plugins-->
    <link rel="stylesheet" href="css/simpletextrotator.css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body data-spy="scroll" data-target="#navigation" data-offset="120">
<div id="all">
    <!-- navbar-->
    <header class="header">
        <div role="navigation" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="#all" class="navbar-brand scroll-to">
                        <img src="img/logo004.png" height="65px" alt="logo" class="hidden-xs hidden-sm">
                        <img src="img/logo004.png" height="45px" alt="logo" class="visible-xs visible-sm">
                        <span class="sr-only">Go to homepage</span>
                    </a>
                    <div class="navbar-buttons">
                        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Menu<i class="pe-7s-menu"></i></button>
                    </div>
                </div>

                <div id="navigation" class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#features" class="scroll-to">Features</a></li>
                        <li><a href="#extensions" class="scroll-to">Extensions</a></li>
                        <li><a href="http://discuss.laravel-admin.org">Discuss</a></li>
                        <li><a href="/docs">Documentation</a></li>
                        <li><a href="/demo">Demo</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- *** SIGNUP MODAL END ***-->
    <section id="intro" class="text-intro no-padding-bottom" style="padding-top: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Build a full-featured administrative interface in ten minutes</h2>
                    <h3 class="weight-300"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <iframe src="https://ghbtns.com/github-btn.html?user=z-song&repo=laravel-admin&type=star&count=true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
                        <iframe src="https://ghbtns.com/github-btn.html?user=z-song&repo=laravel-admin&type=fork&count=true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
                    </div>
                    <form class="form-inline margin-top sign-up-form">
                        <input class="form-control" value="composer require encore/laravel-admin">
                        <a href="/docs" class="btn btn-primary" style="text-decoration: none;">Start</a>
                    </form>
                </div>
                <div class="col-md-12 col-lg-8 col-lg-offset-2">
                    <p class="margin-bottom--zero"><img alt="" src="img/dashboard.png" class="img-responsive"></p>
                </div>
            </div>
        </div>
    </section>

    <section class="section background-gray-lightest">
        <div class="container">
            <div class="row text-center-mobile">
                <div class="col-md-6">
                    <p><img alt="" src="img/features2.png" class="img-responsive"></p>
                </div>
                <div class="col-md-6">
                    <div class="icon brand-terciary"><i class="pe-7s-rocket"></i></div>
                    <p>Built-in and routing bound permissions system. </p>
                    <p>Support for flexible page layout. </p>
                    <p>Does not limit the development of developers. </p>
                    <p>Supports feature-rich extension tools. </p>
                    <p>Can import any three-party front-end libraries and frameworks.</p>
                </div>
            </div>
        </div>
    </section>

    <!--   *** FEATURES ***-->
    <section id="features" class="section">
        <div class="container">
            <div class="row text-center-mobile">
                <div class="col-md-6">
                    <div class="icon"><i class="pe-7s-graph3"></i></div>
                    <h2>Quickly build data tables</h2>
                    <p>Quickly build data tables based on the model to flexibly control the display of rows and columns.</p>
                    <p>Support multiple types of custom data queries, and column data sorting.</p>
                    <p>Support for custom extension tools, custom data line operations.</p>
                    <p>Built-in data export excel function, support for custom export.</p>
                    <p>Support for custom data display views.</p>
                    <p>Support one to one, one to many, many to many model relationship.</p>
                </div>
                <div class="col-md-6">
                    <p><img alt="" src="img/table.png" class="img-responsive"></p>
                </div>
            </div>
        </div>
    </section>
    <section class="section background-gray-lightest">
        <div class="container">
            <div class="row text-center-mobile">
                <div class="col-md-6">
                    <p><img alt="" src="img/form.png" class="img-responsive"></p>
                </div>
                <div class="col-md-6">
                    <div class="icon brand-terciary"><i class="pe-7s-note2"></i></div>
                    <h2>Quickly build data form</h2>
                    <p>40+ form components. </p>
                    <p>Integrate laravel data validation rules. </p>
                    <p>Support for expansion of form components. </p>
                    <p>Form binding model, internal implementation of data creation and updating. </p>
                    <p>Support one-to-one, one-to-many model relationship. </p>
                </div>
            </div>
        </div>
    </section>
    <!--   *** INTEGRATIONS ***-->
    <section id="extensions" class="section-gray" style="padding-top: 0;">
        <div class="container clearfix">
            <div class="row services">
                <div class="col-md-12">
                    <h4 class="services-heading">Extensions</h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-config"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/config">Config</a></h4>
                                <p>Store the configuration information in the database, making it easy to modify the laravel configuration at any time.</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-alarm"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/scheduling">Scheduling</a></h4>
                                <p>Provides a more friendly management page for laravel's scheduled tasks, making it easy to view the details of scheduled tasks.</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-diskette"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/media-manager">Media manager</a></h4>
                                <p>To achieve the local file to view, upload, delete, download, create folder, move files and other conventional operations. </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-monitor"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/log-viewer">Log viewer</a></h4>
                                <p>So you do not have to log on to the server, more convenient to view laravel log, support real-time view log.</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-edit"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/api-tester">Api tester</a></h4>
                                <p>Debug your laravel api like a `postman`.</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="box box-services">
                                <div class="icon"><i class="pe-7s-copy-file"></i></div>
                                <h4 class="heading"><a href="https://github.com/laravel-admin-extensions/backup">Backup</a></h4>
                                <p><a href="https://github.com/spatie/laravel-backup">laravel-backup </a> web interface, easy to view the backup situation, and the implementation of the backup.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="footer__copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy;2017 laravel-admin.org</p>
                    </div>
                    <div class="col-md-6">
                        <p class="credit pull-right">Code by <a href="https://bootstrapious.com/landing-pages" class="external">Bootstrapious</a></p>
                        <!-- Not removing these links is part of the license conditions of the template. Thanks for understanding :) If you want to use the template without the attribution links, you can do so after supporting further themes development at https://bootstrapious.com/donate  -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- Javascript files-->
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"> </script>
<script src="js/jquery.cookie.js"> </script>
<script src="js/ekko-lightbox.js"></script>
<script src="js/jquery.simple-text-rotator.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/front.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-52301626-3', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>