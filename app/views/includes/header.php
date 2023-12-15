<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    document.getElementsByTagName("html")[0].className += " js";
    </script>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= URLROOT ?>public\css\style.css">
    <title>Pizzaplaza</title>
</head>


<body>
    <?php session_start() ?>

    <header class="header position-relative js-header ">
        <div class="header__container container max-width-lg">
            <div class="header__logo">
                <a href="<?= URLROOT ?>homepages/overview">
                    <svg width="104" height="50" viewBox="0 0 104 30">
                        <title>Go to homepage</title>
                        <img src="<?= URLROOT  . 'public/media/pizzaplaza.jpg' ?>" alt="" width="80" height="50">
                    </svg>
                </a>
            </div>



            <button class="btn btn--subtle header__trigger js-header__trigger" aria-label="Toggle menu"
                aria-expanded="false" aria-controls="header-nav">
                <i class="header__trigger-icon" aria-hidden="true"></i>
                <span>Menu</span>
            </button>


            <button class="reset user-menu-control" aria-controls="user-menu" aria-label="Toggle user menu">
                <figure class="user-menu-control__img-wrapper radius-50%">
                    <img class="user-menu-control__img" src="<?= URLROOT . 'public/media/profile.jpg' ?>"
                        alt="User picture">
                </figure>

                <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true" viewBox="0 0 12 12">
                    <polyline points="1 4 6 9 11 4" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" />
                </svg>
            </button>
            <menu id="user-menu" class="menu js-menu">
                <?php if (isset($_SESSION['user'])) : ?>
                <!-- Displayed when user is logged in -->
                <li role="menuitem">
                    <a class="menu__content js-menu__content" href="#0">
                        <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <circle cx="8" cy="3.5" r="3.5" />
                            <path
                                d="M14.747,14.15a6.995,6.995,0,0,0-13.494,0A1.428,1.428,0,0,0,1.5,15.4a1.531,1.531,0,0,0,1.209.6H13.288a1.531,1.531,0,0,0,1.209-.6A1.428,1.428,0,0,0,14.747,14.15Z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                </li>
                <li role="menuitem">
                    <a class="menu__content js-menu__content" href="<?= URLROOT . 'homepages/logout' ?>">Logout</a>
                </li>
                <?php else : ?>
                <!-- Displayed when user is not logged in -->
                <li role="menuitem">
                    <a class="menu__content js-menu__content" href="<?= URLROOT . 'homepages/register/' ?>">
                        <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <path
                                d="M8,11c-1.657,0-3-1.343-3-3s1.343-3,3-3s3,1.343,3,3S9.657,11,8,11z M8,6.5c-1.104,0-2,0.896-2,2s0.896,2,2,2s2-0.896,2-2 S9.104,6.5,8,6.5z" />
                        </svg>
                        <span>Register</span>
                    </a>
                </li>
                <li role="menuitem">
                    <a class="menu__content js-menu__content" href="<?= URLROOT . 'homepages/login/' ?>">
                        <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <circle cx="8" cy="4.5" r="2.5" />
                            <circle cx="8" cy="9.5" r="2.5" />
                            <path
                                d="M8,12c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S10.757,12,8,12z M8,3.5C6.896,3.5,6,4.396,6,5.5S6.896,7.5,8,7.5 s2,0.896,2,1.999S9.104,10.5,8,10.5s-2-0.896-2-1.999C6,4.396,6.896,3.5,8,3.5z" />
                        </svg>
                        <span>Login</span>
                    </a>
                </li>
                <?php endif; ?>
            </menu>


            <nav class="header__nav js-header__nav" id="header-nav" role="navigation" aria-label="Main">
                <div class="header__nav-inner">
                    <div class="header__label">Main menu</div>
                    <ul class="header__list">
                        <li class="header__item">
                            <!-- Replace the Download link with a cart icon -->
                            <a href="<?= URLROOT ?>homepages/overview/" class="header__nav-btn btn btn--primary">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <!-- Your cart icon SVG code goes here -->
                                    <path
                                        d="M3 3h2v2H3zM2 6h3.586L7 14.414l1.707-1.707L2 4.586V8H0V2h7l1.263 8.579 1.986-1.986L5.586 0h5.828L14 4.586l2.722-1.722 1.986 1.986L14.414 6H21v2h2v2H5.408L4 18.414l-2 2V20h16v-1.586l2-2V6H2z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>



        </div>
    </header>