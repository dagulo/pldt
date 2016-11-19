<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> PLDT Support </title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo Url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <?php echo \Helpers\Layout::instance()->renderPageStyles() ?>

    <!-- Custom Fonts -->
    <link href="<?php echo Url('vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .content{
            position: absolute;
            top:50px;

        }
    </style>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Url('/') ?>">Cerveo CRM</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">My Ticket</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Support Types <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Knowledge Base</a></li>
                        <li><a href="#">Chat</a></li>
                        <li> <a href="#">My Ticket</a> </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Community Forum and Discussions</a></li>
                        <li><a href="">Call Us</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="">My Account</a></li>
                <li class="active"><a href="">Login</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="content" style="width:100%;">
    <?php echo $content ?>
</div>
<!-- Footer -->

<!-- jQuery -->
<script src="<?php echo Url('vendor/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo Url('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<!-- Application Javascript -->
<?php echo \Helpers\Layout::instance()->renderPageScripts() ?>

</body>

</html>
