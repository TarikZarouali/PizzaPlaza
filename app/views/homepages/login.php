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
    <link rel="stylesheet" href="<?= URLROOT; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= URLROOT ?>public\css\style.css">
    <title>Pizzaplaza</title>
</head>


<body class="bg-dark min-height-100vh flex flex-center padding-md">
    <form class="bg radius-md shadow-sm padding-lg max-width-xxs" id="loginform" onsubmit="signIn(event)">
        <div class="text-center margin-bottom-md">
            <h1>Log in</h1>
        </div>

        <input type="hidden" name="loginFailed">
        <div class="margin-bottom-sm">
            <label class="form-label margin-bottom-xxxs" for="customerEmail">Email</label>
            <input class="form-control width-100%" type="text" name="customerEmail" id="customerEmail"
                placeholder="email@myemail.com">
        </div>

        <div class="margin-bottom-sm">
            <div class="flex justify-between margin-bottom-xxxs">
                <label class="form-label" for="customerPassword">Password</label>
            </div>

            <input class="form-control width-100%" type="password" name="customerPassword" id="customerPassword">
        </div>

        <div class="margin-bottom-sm">
            <button class="btn btn--primary btn--md width-100%">Login</button>
        </div>

        <div class="text-center">
            <p class="text-sm">Don't have an account? <a href="<?= URLROOT ?>homepages/register/">Get started</a></p>
        </div>
    </form>
    <script src="<?= URLROOT; ?>assets/js/scripts.js"></script>
    <script src="<?= URLROOT; ?>public/js/app.js"></script>
</body>