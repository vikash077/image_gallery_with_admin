<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>
        <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css'); ?>">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

        <style type="text/css">
            body {
                margin: 0;
            }

            /* apply a natural box layout model to all elements, but allowing components to change */

            html {
                box-sizing: border-box;
            }

            *, *:before, *:after {
                box-sizing: inherit;
            }

            .image-grid {
                width: 100%;
                max-width: 1310px;
                margin: 0 auto;
                overflow: hidden;
                padding: 10px 5px 0;
            }

            .image__cell {
                float: left;
            }
            
/*            img.basic__img{
                display: block;
                margin-left: auto;
                margin-right: auto 
            }*/
            
            div.image--basic {
                width: 250px;
                height: 250px;
                text-align: center;
                display: table-cell;
                vertical-align: middle;
                position: relative;
            }
            



            .image__cell.is-collapsed .image--basic {
                cursor: pointer;
            }

            .image__cell.is-expanded .image--expand {
                max-height: 500px;
                margin-bottom: 10px;
            }

            .image--expand {
                position: relative;
                left: -5px;
                padding: 0 5px;
                box-sizing: content-box;
                overflow: hidden;
                background: #222;
                max-height: 0;
                transition: max-height .3s ease-in-out,margin-bottom .1s .2s;
            }

            .image__cell.is-collapsed .arrow--up {
                height: 10px;
                width: 100%;
            }

            .image__cell.is-expanded .arrow--up {
                border-bottom: 8px solid #222;
                border-left: 8px solid transparent;
                border-right: 8px solid transparent;
                height: 0;
                width: 0;
                margin: 2px auto 0;
                position: absolute;
                bottom: 0px;
                left:120px;
            }

            .expand__close {
                position: absolute;
                top: 10px;
                right: 20px;
                color: #454545;
                font-size: 50px;
                line-height: 50px;
                text-decoration: none;
            }

            .expand__close:before {
                content: '×';
            }

            .expand__close:hover {
                color: #fff;
            }

            .image--large {
                max-width: 100%;
                height: auto;
                display: block;
                padding: 40px;
                margin: 0 auto;
                box-sizing: border-box;
                border-right:1px solid;
            }

            @media only screen and (max-width: 530px) {

                .image__cell {
                    width: 50%;
                }

                .image__cell:nth-of-type(2n+2) .image--expand {
                    margin-left: -100%;
                }

                .image__cell:nth-of-type(2n+3) {
                    clear:left;
                }

                .image--expand {
                    width: 200%;
                }

            }

            @media only screen and (min-width: 531px) {
                .image__cell {
                    width: 20%;
                }

                .image__cell:nth-of-type(5n+2) .image--expand {
                    margin-left: -100%;
                }

                .image__cell:nth-of-type(5n+3) .image--expand {
                    margin-left: -200%;
                }

                .image__cell:nth-of-type(5n+4) .image--expand {
                    margin-left: -300%;
                }

                .image__cell:nth-of-type(5n+5) .image--expand {
                    margin-left: -400%;
                }

                .image__cell:nth-of-type(5n+6) {
                    clear: left;
                }

                .image--expand {
                    width: 500%;
                }

            }

            #flipkart-navbar {
                background-color: #000;
                color: #FFFFFF;
                padding-bottom: 10px;
            }

            .row1{
                padding-top: 10px;
            }

            .row2 {
                padding-bottom: 20px;
            }

            .flipkart-navbar-input {
                padding: 11px 16px;
                border-radius: 2px 0 0 2px;
                border: 0 none;
                outline: 0 none;
                font-size: 15px;
                color:#333;
            }

            .flipkart-navbar-button {
                background-color: #ffe11b;
                border: 1px solid #ffe11b;
                border-radius: 0 2px 2px 0;
                color: #565656;
                padding: 10px 0;
                height: 43px;
                cursor: pointer;
            }

            .cart-button {
                background-color: #2469d9;
                box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .23), inset 1px 1px 0 0 hsla(0, 0%, 100%, .2);
                padding: 10px 0;
                text-align: center;
                height: 41px;
                border-radius: 2px;
                font-weight: 500;
                width: 120px;
                display: inline-block;
                color: #FFFFFF;
                text-decoration: none;
                color: inherit;
                border: none;
                outline: none;
            }

            .cart-button:hover{
                text-decoration: none;
                color: #fff;
                cursor: pointer;
            }

            .cart-svg {
                display: inline-block;
                width: 16px;
                height: 16px;
                vertical-align: middle;
                margin-right: 8px;
            }

            .item-number {
                border-radius: 3px;
                background-color: rgba(0, 0, 0, .1);
                height: 20px;
                padding: 3px 6px;
                font-weight: 500;
                display: inline-block;
                color: #fff;
                line-height: 12px;
                margin-left: 10px;
            }

            .upper-links {
                display: inline-block;
                padding: 0 11px;
                line-height: 23px;
                font-family: 'Roboto', sans-serif;
                letter-spacing: 0;
                color: inherit;
                border: none;
                outline: none;
                font-size: 12px;
            }

            .dropdown {
                position: relative;
                display: inline-block;
                margin-bottom: 0px;
            }

            .dropdown:hover {
                background-color: #fff;
            }

            .dropdown:hover .links {
                color: #000;
            }

            .dropdown:hover .dropdown-menu {
                display: block;
            }

            .dropdown .dropdown-menu {
                position: absolute;
                top: 100%;
                display: none;
                background-color: #fff;
                color: #333;
                left: 0px;
                border: 0;
                border-radius: 0;
                box-shadow: 0 4px 8px -3px #555454;
                margin: 0;
                padding: 0px;
            }

            .links {
                color: #fff;
                text-decoration: none;
            }

            .links:hover {
                color: #fff;
                text-decoration: none;
            }

            .profile-links {
                font-size: 12px;
                font-family: 'Roboto', sans-serif;
                border-bottom: 1px solid #e9e9e9;
                box-sizing: border-box;
                display: block;
                padding: 0 11px;
                line-height: 23px;
            }

            .profile-li{
                padding-top: 2px;
            }

            .largenav {
                display: none;
            }

            .smallnav{
                display: block;
            }

            .smallsearch{
                margin-left: 15px;
                margin-top: 15px;
            }

            .menu{
                cursor: pointer;
            }

            @media screen and (min-width: 768px) {
                .largenav {
                    display: block;
                }
                .smallnav{
                    display: none;
                }
                .smallsearch{
                    margin: 0px;
                }
            }

            /*Sidenav*/
            .sidenav {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #fff;
                overflow-x: hidden;
                transition: 0.5s;
                box-shadow: 0 4px 8px -3px #555454;
                padding-top: 0px;
            }

            .sidenav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #818181;
                display: block;
                transition: 0.3s
            }

            .sidenav .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
                color: #fff;        
            }

            @media screen and (max-height: 450px) {
                .sidenav a {font-size: 18px;}
            }

            .sidenav-heading{
                font-size: 36px;
                color: #fff;
            }
            .image--large{
                float: left;
            }
            .image--expand p.lead{
                margin-top: 40px;
                color: #8e8e8e;
            }
            .middle{
    position:fixed;
    top: 50%;
    left: 15%;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
    border: 1px solid #ccc;
    background-color: #f3f3f3;
}
        </style>
    </head>
    <body>
        <section>

            <div id="flipkart-navbar">
                <div class="container">
                    <div class="row row1">
                        <div class="col-sm-2">
                            <h2 style="margin:0px;"><span class="smallnav menu" onclick="openNav()">☰ Somany</span></h2>
                            <span class="largenav"><img width="150px" src="<?php echo base_url('assets/image/logo.png'); ?>"/></span>
                            <h2 style="margin:0px;"></h2>
                        </div>
                        <?php if (!empty($search_txt)) { ?>
                            <div class="flipkart-navbar-search smallsearch col-sm-8 col-xs-11">
                                <div class="row">
                                    <form action="<?php echo base_url('index.php/app/search'); ?>">
                                        <input class="flipkart-navbar-input col-xs-11" value="<?php echo!empty($search_txt) ? $search_txt : ''; ?>" placeholder="Search for Images" name="search" >
                                        <button class="flipkart-navbar-button col-xs-1" id="search_btn" type="submit">
                                            <svg width="15px" height="15px"> 
                                            <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 "></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="cart largenav col-sm-2 pull-right">

                            <ul class="largenav pull-right">
                                <li class="upper-links dropdown"><a class="links" href="#"><?php echo $user_data['name'];?><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li class="profile-li"><a class="profile-links" href="<?php echo base_url('index.php/login/logout');?>">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav">
                <div class="container" style="background-color: #2874f0; padding-top: 10px;">
                    <span class="sidenav-heading">Home</span>
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                </div>
                <a href="http://clashhacks.in/">Link</a>
                <a href="http://clashhacks.in/">Link</a>
                <a href="http://clashhacks.in/">Link</a>
                <a href="http://clashhacks.in/">Link</a>
            </div>
        </section>
        <section class="image-grid">
            <?php
            if (!empty($search)) {
                foreach ($search as $file) {
                    ?>

                    <div class="image__cell is-collapsed">
                        <div class="image--basic">
                            <a href="#expand-jump-1">
                                <img id="expand-jump-1" class="basic__img" src="<?php echo base_url('index.php/app/get_file/?file=' . $file['file'] . '&size=250X250'); ?>" alt="<?php echo base_url($file['file']); ?>" />
                            </a>
                            <div class="arrow--up"></div>
                        </div>
                        <div class="image--expand">
                            <a href="#close-jump-1" class="expand__close"></a>

                            <div class="row margin-bottom">
                                <div class="col-sm-6">
                                    <img class="image--large" src="<?php echo base_url('index.php/app/get_file/?file=' . $file['file'] . '&size=800X450'); ?>" alt="" />
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="lead"><?php echo $file['title']; ?></p>
                                        </div>
                                        <?php $path_info = pathinfo($file['file']);
                                         if(in_array($path_info['extension'],['png','jpeg','jpg'])){ 
                                        ?>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-default btn-sm"><i class="fa fa-download" aria-hidden="true" style="color:#F00000"></i> Small 250 X 250</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-default btn-sm"><i class="fa fa-download" aria-hidden="true" style="color:#F00000"></i> Normal 500 X 500</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-default btn-sm"><i class="fa fa-download" aria-hidden="true" style="color:#F00000"></i> Large (FULL)</button>
                                            </div>
                                         <?php }else{ ?>
                                             <div class="col-sm-3">
                                                 <a class="btn btn-block btn-default btn-sm" href='<?php echo base_url("index.php/app/download?file={$file['file']}");?>'><i class="fa fa-download" aria-hidden="true" style="color:#F00000"></i> Download</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                }
            } else if (empty($search_txt)) {
                ?>
            <div class="container">
                <div style="border: 1px solid #333;margin:0px auto;" class="middle flipkart-navbar-search smallsearch col-sm-8 col-xs-11">
                    <div class="row">
                        <form action="<?php echo base_url('index.php/app/search'); ?>">
                            <input class="flipkart-navbar-input col-xs-11" value="<?php echo!empty($search_txt) ? $search_txt : ''; ?>" placeholder="Search for Images" name="search" >
                            <button class="flipkart-navbar-button col-xs-1" id="search_btn" type="submit">
                                <svg width="15px" height="15px"> 
                                <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 "></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>




        </section>

    </body>
    <script>

        var $cell = $('.image__cell');

        $cell.find('.image--basic').click(function () {
            var $thisCell = $(this).closest('.image__cell');

            if ($thisCell.hasClass('is-collapsed')) {
                $cell.not($thisCell).removeClass('is-expanded').addClass('is-collapsed');
                $thisCell.removeClass('is-collapsed').addClass('is-expanded');
            } else {
                $thisCell.removeClass('is-expanded').addClass('is-collapsed');
            }
        });

        $cell.find('.expand__close').click(function () {

            var $thisCell = $(this).closest('.image__cell');

            $thisCell.removeClass('is-expanded').addClass('is-collapsed');
        });


    </script>
</html>