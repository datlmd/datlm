<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>
        <?php
            if (!empty($is_blog)) :
                echo $CI->fuel->blog->page_title($page_title, ' : ', 'right');
            else:
                echo fuel_var('page_title', '');
            endif;
        ?>
    </title>
    <meta name="keywords" content="<?php echo fuel_var('meta_keywords')?>">
    <meta name="description" content="<?php echo fuel_var('meta_description')?>">
    <?php
        echo css('').css($css);

        if (!empty($is_blog)):
            echo $CI->fuel->blog->header();
        endif;
    ?>
    <?=jquery()?>
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="<?=site_url('assets/theme/news/css/bootstrap.min.css')?>"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="<?=site_url('assets/theme/news/css/font-awesome.min.css')?>">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="<?=site_url('assets/theme/news/css/style.css')?>"/>

    <link type="text/css" rel="stylesheet" href="<?=site_url('assets/theme/news/css/news.css')?>"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- Header -->
<header id="header">
    <!-- Nav -->
    <div id="nav">
        <!-- Main Nav -->
        <div id="nav-fixed">
            <div class="container">
                <!-- logo -->
                <div class="nav-logo">
                    <a href="index.html" class="logo"><img src="<?=site_url('assets/theme/news/img/logo.png')?>" alt=""></a>
                </div>
                <!-- /logo -->
                <?php
                $this->load->model('fuel_categories_model');
                    $categories = $this->fuel_categories_model->find_all(array('published' => 'yes', 'context' => 'top_menu'));
                ?>
                <!-- nav -->
                <ul class="nav-menu nav navbar-nav">
                    <?php foreach($categories as $widget) : ?>
                        <li class="cat-1"><a href="category.html"><?=$widget->name?></a></li>
                    <?php endforeach; ?>
<!--                    <li><a href="category.html">News</a></li>-->
<!--                    <li><a href="category.html">Popular</a></li>-->
<!--                    <li class="cat-1"><a href="category.html">Web Design</a></li>-->
<!--                    <li class="cat-2"><a href="category.html">JavaScript</a></li>-->
<!--                    <li class="cat-3"><a href="category.html">Css</a></li>-->
<!--                    <li class="cat-4"><a href="category.html">Jquery</a></li>-->
                </ul>
                <!-- /nav -->

                <!-- search & aside toggle -->
                <div class="nav-btns">
                    <button class="aside-btn"><i class="fa fa-bars"></i></button>
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                    <div class="search-form">
                        <input class="search-input" type="text" name="search" placeholder="Enter Your Search ...">
                        <button class="search-close"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /search & aside toggle -->
            </div>
        </div>
        <!-- /Main Nav -->
        <h1><?php echo fuel_var('heading')?></h1>
        <!-- Aside Nav -->
        <?php $this->load->view('_blocks/magazine/menu')?>
        <!-- Aside Nav -->
    </div>
    <!-- /Nav -->
</header>
<!-- /Header -->