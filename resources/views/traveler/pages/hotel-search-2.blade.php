<!DOCTYPE HTML>
<html>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/hotel-search-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:42:02 GMT -->
<head>
    <title>Traveler - Search for Hotels</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{ url('traveler') }}/css/bootstrap.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/font-awesome.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/icomoon.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/styles.css">
    <link rel="stylesheet" href="{{ url('traveler') }}/css/mystyles.css">
    <script src="{{ url('traveler') }}/js/modernizr.js"></script>

    <link rel="stylesheet" href="{{ url('traveler') }}/css/switcher.css" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/bright-turquoise.css" title="bright-turquoise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/turkish-rose.css" title="turkish-rose" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/salem.css" title="salem" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/hippie-blue.css" title="hippie-blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/mandy.css" title="mandy" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/green-smoke.css" title="green-smoke" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/horizon.css" title="horizon" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/cerise.css" title="cerise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/brick-red.css" title="brick-red" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/de-york.css" title="de-york" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/shamrock.css" title="shamrock" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/studio.css" title="studio" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/leather.css" title="leather" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/denim.css" title="denim" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ url('traveler') }}/css/schemes/scarlet.css" title="scarlet" media="all" />
</head>

<body>

    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">
        <div class="demo_changer" id="demo_changer">
            <div class="demo-icon fa fa-sliders"></div>
            <div class="form_holder">
                <div class="line"></div>
                <p>Color Scheme</p>
                <div class="predefined_styles" id="styleswitch_area">
                    <a class="styleswitch" href="{{ url('traveler') }}/hotel-search-2c392.html?default=true" style="background:#ED8323;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/bright-turquoise" style="background:#0EBCF2;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/turkish-rose" style="background:#B66672;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/salem" style="background:#12A641;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/hippie-blue" style="background:#4F96B6;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/mandy" style="background:#E45E66;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/green-smoke" style="background:#96AA66;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/horizon" style="background:#5B84AA;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/cerise" style="background:#CA2AC6;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/brick-red" style="background:#cf315a;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/de-york" style="background:#74C683;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/shamrock" style="background:#30BBB1;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/studio" style="background:#7646B8;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/leather" style="background:#966650;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/denim" style="background:#1A5AE4;"></a>
                    <a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/scarlet" style="background:#FF1D13;"></a>
                </div>
                <div class="line"></div>
                <p>Layout</p>
                <div class="predefined_styles"><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-wide">Wide</a><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-boxed">Boxed</a>
                </div>
                <div class="line"></div>
                <p>Background Patterns</p>
                <div class="predefined_styles" id="patternswitch_area">
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_light.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_dark.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dark_fish_skin.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dimension.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/escheresque_ste.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/food.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/giftly.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/grey_wash_wall.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/ps_neutral.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_maze_black.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_pattern.png);"></a>
                    <a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/simple_dashed.png);"></a>
                </div>
                <div class="line"></div>
                <p>Background Images</p>
                <div class="predefined_styles" id="bgimageswitch_area">
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bike.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bike.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/flowers.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/flowers.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/wood.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/wood.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/taxi.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/taxi.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/phone.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/phone.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/road.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/road.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/keyboard.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/keyboard.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/beach.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/beach.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/street.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/street.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/nature.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/nature.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bridge.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bridge.jpg"></a>
                    <a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/cameras.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/cameras.jpg"></a>
                </div>
                <div class="line"></div>
            </div>
        </div>
        <header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="logo" href="{{ url('traveler') }}/index-2.html">
                                <img src="{{ url('traveler') }}/img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </div>
                        <div class="col-md-3 col-md-offset-2">
                            <form class="main-header-search">
                                <div class="form-group form-group-icon-left">
                                    <i class="fa fa-search input-icon"></i>
                                    <input type="text" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                    <li class="top-user-area-avatar">
                                        <a href="{{ url('traveler') }}/user-profile.html">
                                            <img class="origin round" src="{{ url('traveler') }}/img/amaze_40x40.jpg" alt="Image Alternative text" title="AMaze" />Hi, John</a>
                                    </li>
                                    <li><a href="{{ url('traveler') }}/#">Sign Out</a>
                                    </li>
                                    <li class="nav-drop"><a href="{{ url('traveler') }}/#">USD $<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a>
                                        <ul class="list nav-drop-menu">
                                            <li><a href="{{ url('traveler') }}/#">EUR<span class="right">€</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">GBP<span class="right">£</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">JPY<span class="right">円</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">CAD<span class="right">$</span></a>
                                            </li>
                                            <li><a href="{{ url('traveler') }}/#">AUD<span class="right">A$</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="top-user-area-lang nav-drop">
                                        <a href="{{ url('traveler') }}/#">
                                            <img src="{{ url('traveler') }}/img/flags/32/uk.png" alt="Image Alternative text" title="Image Title" />ENG<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i>
                                        </a>
                                        <ul class="list nav-drop-menu">
                                            <li>
                                                <a title="German" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/de.png" alt="Image Alternative text" title="Image Title" /><span class="right">GER</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Japanise" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/jp.png" alt="Image Alternative text" title="Image Title" /><span class="right">JAP</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Italian" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/it.png" alt="Image Alternative text" title="Image Title" /><span class="right">ITA</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="French" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/fr.png" alt="Image Alternative text" title="Image Title" /><span class="right">FRE</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Russian" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/ru.png" alt="Image Alternative text" title="Image Title" /><span class="right">RUS</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Korean" href="{{ url('traveler') }}/#">
                                                    <img src="{{ url('traveler') }}/img/flags/32/kr.png" alt="Image Alternative text" title="Image Title" /><span class="right">KOR</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li><a href="{{ url('traveler') }}/index-2.html">Home</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/index-2.html">Default</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-1.html">Layout 1</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-3.html">Layout 2</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-4.html">Layout 3</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-5.html">Layout 4</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-6.html">Layout 5</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-7.html">Layout 6</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/index-8.html">Layout 7</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/success-payment.html">Pages</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/success-payment.html">Success Payment</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/user-profile.html">User Profile</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/user-profile.html">Overview</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-settings.html">Settings</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-photos.html">Photos</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-booking-history.html">Booking History</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-cards.html">Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/user-profile-wishlist.html">Wishlist</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/blog.html">Blog</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/blog.html">Sidebar Right</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-sidebar-left.html">Sidebar Left</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-full-width.html">Full Width</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/blog-post.html">Post</a>
                                            <ul>
                                                <li><a href="{{ url('traveler') }}/blog-post.html">Sidebar Right</a>
                                                </li>
                                                <li><a href="{{ url('traveler') }}/blog-post-sidebar-left.html">Sidebar Left</a>
                                                </li>
                                                <li><a href="{{ url('traveler') }}/blog-post-full-width.html">Full Width</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/404.html">404 page</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/contact-us.html">Contact Us</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/about.html">About</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/login-register.html">Login/Register</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/login-register.html">Full Page</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/login-register-normal.html">Normal</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/loading.html">Loading</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/comming-soon.html">Comming Soon</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/gallery.html">Gallery</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/gallery.html">4 Columns</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/gallery-3-col.html">3 columns</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/gallery-2-col.html">2 columns</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-full-width.html">Full Width</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-sidebar-right.html">Sidebar Right</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/page-sidebar-left.html">Sidebar Left</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/feature-typography.html">Features</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/feature-typography.html">Typography</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-icons.html">Icons</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-forms.html">Forms</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-icon-effects.html">Icon Effects</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-elements.html">Elements</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-grid.html">Grid</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-hovers.html">Hover effects</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-lightbox.html">Lightbox</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/feature-media.html">Media</a>
                                </li>
                            </ul>
                        </li>
                        <li class="active"><a href="{{ url('traveler') }}/hotels.html">Hotels</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/hotel-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-details-4.html">Layout 4</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/hotel-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="active"><a href="{{ url('traveler') }}/hotel-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotel-search.html">Layout 1</a>
                                        </li>
                                        <li class="active"><a href="{{ url('traveler') }}/hotel-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/hotels.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/hotels.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotels-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/hotel-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/flights.html">Flights</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/flight-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flight-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/flight-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flight-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flight-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/flights.html">List</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/flights.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/flights-search-results-4.html">Layout 4</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/rentals.html">Rentals</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/rentals-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-details-3.html">Layout 3</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rental-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rental-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rental-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rental-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rentals-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/rentals.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/rentals.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/rentals-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/cars.html">Cars</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/car-details.html">Details</a>
                                </li>
                                <li><a href="{{ url('traveler') }}/car-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/car-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/car-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/car-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/car-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/cars.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/cars.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/cars-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ url('traveler') }}/activities.html">Activities</a>
                            <ul>
                                <li><a href="{{ url('traveler') }}/activitiy-details.html">Details</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activitiy-details.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-details-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-details-3.html">Layout 3</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activity-search.html">Search</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activity-search.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activity-search-2.html">Layout 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activitiy-payment.html">Payment</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activitiy-payment.html">Registered</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activity-payment-registered-card.html">Existed Cards</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activitiy-payment-unregistered.html">Unregistered</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('traveler') }}/activities.html">Results</a>
                                    <ul>
                                        <li><a href="{{ url('traveler') }}/activities.html">Layout 1</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-2.html">Layout 2</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-3.html">Layout 3</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-4.html">Layout 4</a>
                                        </li>
                                        <li><a href="{{ url('traveler') }}/activities-search-results-5.html">Layout 5</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container">
            <h1 class="page-title">Search for Hotels</h1>
        </div>




        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <form>
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Where</label>
                                <input class="typeahead form-control" placeholder="City, Hotel Name or U.S. Zip Code" type="text" />
                            </div>
                            <div class="input-daterange" data-date-format="MM d, D">
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check in</label>
                                    <input class="form-control" name="start" type="text" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                    <label>Check out</label>
                                    <input class="form-control" name="end" type="text" />
                                </div>
                            </div>
                            <div class="form-group form-group- form-group-select-plus">
                                <label>Guests</label>
                                <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />1</label>
                                    <label class="btn btn-primary active">
                                        <input type="radio" name="options" />2</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />3</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />4</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />4+</label>
                                </div>
                                <select class="form-control hidden">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option selected="selected">5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                </select>
                            </div>
                            <div class="form-group form-group-select-plus">
                                <label>Rooms</label>
                                <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                    <label class="btn btn-primary active">
                                        <input type="radio" name="options" />1</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />2</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />3</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />4</label>
                                    <label class="btn btn-primary">
                                        <input type="radio" name="options" />4+</label>
                                </div>
                                <select class="form-control hidden">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option selected="selected">5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                </select>
                            </div>
                            <input class="btn btn-primary mt10" type="submit" value="Search for Hotels" />
                        </form>
                    </aside>
                </div>
                <div class="col-md-9">
                    <h3 class="mb20">Hotels in Popular Destinations</h3>
                    <div class="row row-wrap">
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/waipio_valley_800x600.jpg" alt="Image Alternative text" title="waipio valley" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Sydney Hotels</h5>
                                            <p>77126 reviews</p>
                                            <p class="mb0">738 offers from $94</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/upper_lake_in_new_york_central_park_800x600.jpg" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Atlantic City Hotels</h5>
                                            <p>59264 reviews</p>
                                            <p class="mb0">847 offers from $56</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/viva_las_vegas_800x600.jpg" alt="Image Alternative text" title="Viva Las Vegas" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Las Vegas</h5>
                                            <p>77796 reviews</p>
                                            <p class="mb0">759 offers from $54</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/sydney_harbour_800x600.jpg" alt="Image Alternative text" title="Sydney Harbour" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Sydney Hotels</h5>
                                            <p>69390 reviews</p>
                                            <p class="mb0">549 offers from $90</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/gaviota_en_el_top_800x600.jpg" alt="Image Alternative text" title="Gaviota en el Top" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>New York City Hotels</h5>
                                            <p>72580 reviews</p>
                                            <p class="mb0">300 offers from $77</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/street_800x600.jpg" alt="Image Alternative text" title="Street" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Disney World Hotels</h5>
                                            <p>57802 reviews</p>
                                            <p class="mb0">355 offers from $57</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/the_best_mode_of_transport_here_in_maldives_800x600.jpg" alt="Image Alternative text" title="the best mode of transport here in maldives" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Virginia Beach Hotels</h5>
                                            <p>65869 reviews</p>
                                            <p class="mb0">414 offers from $51</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/lack_of_blue_depresses_me_800x600.jpg" alt="Image Alternative text" title="lack of blue depresses me" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Miami Hotels</h5>
                                            <p>61970 reviews</p>
                                            <p class="mb0">635 offers from $51</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{ url('traveler') }}/#">
                                    <img src="{{ url('traveler') }}/img/el_inevitable_paso_del_tiempo_800x600.jpg" alt="Image Alternative text" title="El inevitable paso del tiempo" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>Budapest</h5>
                                            <p>71537 reviews</p>
                                            <p class="mb0">386 offers from $88</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="gap"></div>
                    <h3 class="mb20">Top Deals</h3>
                    <div class="row row-wrap">
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_2_800x600.jpg" alt="Image Alternative text" title="hotel 2" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-o"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">New York Hilton Midtown</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> Flushing, NY (LaGuardia Airport (LGA))</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$164</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/lhotel_porto_bay_sao_paulo_lobby_800x600.jpg" alt="Image Alternative text" title="LHOTEL PORTO BAY SAO PAULO lobby" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-half-empty"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">JFK Inn</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> New York, NY (Chelsea)</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$187</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_porto_bay_serra_golf_library_800x600.jpg" alt="Image Alternative text" title="hotel PORTO BAY SERRA GOLF library" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-half-empty"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">The Benjamin</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> East Elmhurst, NY (LaGuardia Airport (LGA))</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$432</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_eden_mar_suite_800x600.jpg" alt="Image Alternative text" title="hotel EDEN MAR suite" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Club Quarters Grand Central</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> New York, NY (Downtown - Wall Street)</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$377</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_porto_bay_serra_golf_suite2_800x600.jpg" alt="Image Alternative text" title="hotel PORTO BAY SERRA GOLF suite2" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Affinia Shelburne</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> Jamaica, NY (Kennedy Airport (JFK))</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$391</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_porto_bay_liberdade_800x600.jpg" alt="Image Alternative text" title="hotel PORTO BAY LIBERDADE" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-half-empty"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Holiday Inn Express Kennedy</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> New York, NY (Midtown East)</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$340</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/the_pool_800x600.jpg" alt="Image Alternative text" title="The pool" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-o"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Grand Hyatt New York</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> Jamaica, NY (Kennedy Airport (JFK))</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$337</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/lhotel_porto_bay_sao_paulo_suite_lhotel_living_room_800x600.jpg" alt="Image Alternative text" title="LHOTEL PORTO BAY SAO PAULO suite lhotel living room" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star-o"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Bryant Park Hotel</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> Ozone Park, NY (Kennedy Airport (JFK))</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$246</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumb">
                                <header class="thumb-header">
                                    <a class="hover-img" href="{{ url('traveler') }}/#">
                                        <img src="{{ url('traveler') }}/img/hotel_the_cliff_bay_spa_suite_800x600.jpg" alt="Image Alternative text" title="hotel THE CLIFF BAY spa suite" />
                                        <h5 class="hover-title-center">Book Now</h5>
                                    </a>
                                </header>
                                <div class="thumb-caption">
                                    <ul class="icon-group text-tiny text-color">
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Wellington Hotel</a></h5>
                                    <p class="mb0"><small><i class="fa fa-map-marker"></i> New York, NY (Downtown - Wall Street)</small>
                                    </p>
                                    <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$373</span><small> avg/night</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gap gap-small"></div>
                </div>
            </div>
        </div>



        <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="{{ url('traveler') }}/index-2.html">
                            <img src="{{ url('traveler') }}/img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
                        </a>
                        <p class="mb20">Booking, reviews and advices on hotels, resorts, flights, vacation rentals, travel packages, and lots more!</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest box-icon-normal round animate-icon-bottom-to-top" href="{{ url('traveler') }}/#"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3">
                        <h4>Newsletter</h4>
                        <form>
                            <label>Enter your E-mail Address</label>
                            <input type="text" class="form-control">
                            <p class="mt5"><small>*We Never Send Spam</small>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Subscribe">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="{{ url('traveler') }}/#">About US</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Press Centre</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Best Price Guarantee</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Travel News</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Jobs</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Privacy Policy</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Terms of Use</a>
                            </li>
                            <li><a href="{{ url('traveler') }}/#">Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Have Questions?</h4>
                        <h4 class="text-color">+91-11-45611178</h4>
                        <h4><a href="{{ url('traveler') }}/#" class="text-color">support@flygoldfinch.com</a></h4>
                        <p>24/7 Dedicated Customer Support</p>
                    </div>

                </div>
            </div>
        </footer>

        <script src="{{ url('traveler') }}/js/jquery.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap.js"></script>
        <script src="{{ url('traveler') }}/js/slimmenu.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap-datepicker.js"></script>
        <script src="{{ url('traveler') }}/js/bootstrap-timepicker.js"></script>
        <script src="{{ url('traveler') }}/js/nicescroll.js"></script>
        <script src="{{ url('traveler') }}/js/dropit.js"></script>
        <script src="{{ url('traveler') }}/js/ionrangeslider.js"></script>
        <script src="{{ url('traveler') }}/js/icheck.js"></script>
        <script src="{{ url('traveler') }}/js/fotorama.js"></script>
        <script src="{{ url('traveler') }}/https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
        <script src="{{ url('traveler') }}/js/typeahead.js"></script>
        <script src="{{ url('traveler') }}/js/card-payment.js"></script>
        <script src="{{ url('traveler') }}/js/magnific.js"></script>
        <script src="{{ url('traveler') }}/js/owl-carousel.js"></script>
        <script src="{{ url('traveler') }}/js/fitvids.js"></script>
        <script src="{{ url('traveler') }}/js/tweet.js"></script>
        <script src="{{ url('traveler') }}/js/countdown.js"></script>
        <script src="{{ url('traveler') }}/js/gridrotator.js"></script>
        <script src="{{ url('traveler') }}/js/custom.js"></script>
        <script src="{{ url('traveler') }}/js/switcher.js"></script>
    </div>
</body>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/hotel-search-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:42:09 GMT -->
</html>



