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
    <title>404 | Dashboard UI by CodyHouse</title>
</head>



<body class="bg-contrast-lower min-height-100vh flex flex-center padding-md">
    <div class="bg radius-lg shadow-sm padding-lg max-width-xxs">
        <div class="text-component text-center">
            <h1 class="text-xxxl">404</h1>
            <p>Sorry, but the page you were looking for could not be found.</p>
            <p><a href="<?= URLROOT . 'homepages/overview/' ?>">Go to homepage &rarr;</a></p>
        </div>
    </div>
    <script src="assets/js/scripts.js"></script>
</body>

</html>