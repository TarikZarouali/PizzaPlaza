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
    <script src="<?= URLROOT; ?>assets/js/dark-mode.js"></script>
    <link rel="stylesheet" href="<?= URLROOT ?>public\css\style.css">
    <title>Pizzaplaza</title>
</head>


<body class="bg-dark min-height-100vh flex flex-center padding-md">
    <form class="bg radius-md shadow-sm padding-lg max-width-xxs">
        <div class="text-center margin-bottom-md">
            <h1>Log in</h1>
        </div>
        <div class="margin-bottom-sm">
            <label class="form-label margin-bottom-xxxs" for="inputEmail1">Email</label>
            <input class="form-control width-100%" type="email" name="inputEmail1" id="inputEmail1"
                placeholder="email@myemail.com">
        </div>

        <div class="margin-bottom-sm">
            <div class="flex justify-between margin-bottom-xxxs">
                <label class="form-label" for="inputPassword1">Password</label>
                <span class="text-sm"><a href="password-reset.html">Forgot?</a></span>
            </div>

            <input class="form-control width-100%" type="password" name="inputPassword1" id="inputPassword1">
        </div>

        <div class="margin-bottom-sm">
            <button class="btn btn--primary btn--md width-100%">Login</button>
        </div>

        <div class="text-center">
            <p class="text-sm">Don't have an account? <a href="<?= URLROOT ?>homepages/register/">Get started</a></p>
        </div>
    </form>
    <script src="<? URLROOT . 'assets/js/script.js' ?>"></script>
</body>

</html>