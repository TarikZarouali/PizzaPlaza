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
    <link rel="stylesheet" href="<?= URLROOT ?>public/css/style.css">
    <title>Pizzaplaza</title>
</head>



<body class="bg-dark min-height-100vh flex flex-center padding-md">
    <form class="bg radius-md shadow-sm padding-lg max-width-xxs" id="registrationForm" onsubmit="signUp(event)" method="POST" action="<?= URLROOT ?>users/register">

        <div class="text-component text-center margin-bottom-md">
            <h1>Get started</h1>
            <p>Already have an account? <a href="<?= URLROOT ?>users/login/">Login</a></p>
        </div>
        <div class="margin-bottom-sm">
            <div class="grid gap-xs">
                <div class="col-6@md">
                    <label class="form-label margin-bottom-xxxs" for="customerFirstName">First name</label>
                    <input class="form-control width-100%" type="text" name="customerFirstName" id="js-FirstName" placeholder="John">
                </div>

                <div class="col-6@md">
                    <label class="form-label margin-bottom-xxxs" for="customerLastName">Last name</label>
                    <input class="form-control width-100%" type="text" name="customerLastName" id="js-LastName" placeholder="Doe">
                </div>
            </div>
        </div>

        <div class="margin-bottom-sm">
            <label class="form-label margin-bottom-xxxs" for="customerEmail">Email</label>
            <input class="form-control width-100%" type="email" name="customerEmail" id="js-Email" placeholder="email@myemail.com">
        </div>

        <div class="margin-bottom-sm">
            <div class="password-strength flex flex-column-reverse gap-xxs js-password-strength">
                <div>
                    <!-- requirements list -->
                    <p class="sr-only">Password requirements:</p>

                    <ul class="text-sm">
                        <li class="password-strength__req js-password-strength__req" data-password-req="length:6">
                            <svg class="icon" viewBox="0 0 16 16" aria-hidden="true">
                                <g class="password-strength__icon-group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2">
                                    <line x1="-6" y1="8" x2="8" y2="8" />
                                    <line x1="8" y1="8" x2="22" y2="8" />
                                </g>
                            </svg>

                            <span>At least six characters</span>
                        </li>

                        <li class="password-strength__req js-password-strength__req" data-password-req="special">
                            <svg class="icon" viewBox="0 0 16 16" aria-hidden="true">
                                <g class="password-strength__icon-group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2">
                                    <line x1="-6" y1="8" x2="8" y2="8" />
                                    <line x1="8" y1="8" x2="22" y2="8" />
                                </g>
                            </svg>

                            <span>At least one special character</span>
                        </li>

                        <li class="password-strength__req js-password-strength__req" data-password-req="uppercase">
                            <svg class="icon" viewBox="0 0 16 16" aria-hidden="true">
                                <g class="password-strength__icon-group" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2">
                                    <line x1="-6" y1="8" x2="8" y2="8" />
                                    <line x1="8" y1="8" x2="22" y2="8" />
                                </g>
                            </svg>

                            <span>At least one uppercase character</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <!-- password field + stregth level (value + meter) -->
                    <label class="form-label margin-bottom-xxs" for="customerPassword">Password</label>

                    <div class="password js-password ">
                        <input class="password__input form-control width-100% js-password-strength__input js-password__input" type="password" name="customerPassword" id="js-Password" placeholder="password">

                        <button class="password__btn flex flex-center js-password__btn js-tab-focus">
                            <span class="password__btn-label" aria-label="Show password" title="Show password"><svg class="icon block" viewBox="0 0 32 32">
                                    <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none">
                                        <path d="M1.409,17.182a1.936,1.936,0,0,1-.008-2.37C3.422,12.162,8.886,6,16,6c7.02,0,12.536,6.158,14.585,8.81a1.937,1.937,0,0,1,0,2.38C28.536,19.842,23.02,26,16,26S3.453,19.828,1.409,17.182Z" stroke-miterlimit="10"></path>
                                        <circle cx="16" cy="16" r="6" stroke-miterlimit="10"></circle>
                                    </g>
                                </svg></span>
                            <span class="password__btn-label" aria-label="Hide password" title="Hide password"><svg class="icon block" viewBox="0 0 32 32">
                                    <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none">
                                        <path data-cap="butt" d="M8.373,23.627a27.659,27.659,0,0,1-6.958-6.445,1.938,1.938,0,0,1-.008-2.37C3.428,12.162,8.892,6,16.006,6a14.545,14.545,0,0,1,7.626,2.368" stroke-miterlimit="10" stroke-linecap="butt"></path>
                                        <path d="M27,10.923a30.256,30.256,0,0,1,3.591,3.887,1.937,1.937,0,0,1,0,2.38C28.542,19.842,23.026,26,16.006,26A12.843,12.843,0,0,1,12,25.341" stroke-miterlimit="10"></path>
                                        <path data-cap="butt" d="M11.764,20.243a6,6,0,0,1,8.482-8.489" stroke-miterlimit="10" stroke-linecap="butt"></path>
                                        <path d="M21.923,15a6.005,6.005,0,0,1-5.917,7A6.061,6.061,0,0,1,15,21.916" stroke-miterlimit="10"></path>
                                        <line x1="2" y1="30" x2="30" y2="2" fill="none" stroke-miterlimit="10"></line>
                                    </g>
                                </svg></span>
                        </button>
                    </div>

                    <div class="margin-top-xxs js-password-strength__meter-wrapper">
                        <div class="grid gap-xxs text-sm items-center">
                            <div class="password-strength__meter col-6@xs bg-contrast-lower js-password-strength__meter" min="0" max="4" value="0" aria-hidden="true"><span class="block height-100%"></span>
                            </div>

                            <p class="col-6@xs text-right@xs color-contrast-medium" aria-live="polite" aria-atomic="true">
                                Password strength: <span class="color-contrast-high js-password-strength__value"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="margin-bottom-md">
            <label class="form-label margin-bottom-xxxs" for="customerConfirmPassword">Confirm password</label>
            <input class="form-control width-100%" type="password" name="customerConfirmPassword" id="js-ConfirmPassword" placeholder="confirm password">
        </div>



        <div class="margin-bottom-sm">
            <button class="btn btn--primary btn--md width-100%" id="joinButton">Join</button>
        </div>


    </form>

    <?php require APPROOT . '/views/includes/footer.php'; ?>