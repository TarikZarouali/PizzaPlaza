<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">

    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Customer</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>customerscontroller/overview/" class="color-inherit">All Customers</a>
                        <span class="color-contrast-low margin-left-xxs" aria-hidden="true">/</span>
                    </li>

                    <li class="breadcrumbs__item">#U2123</li>
                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>customerscontroller/update/<?= $data['Customer']->customerId ?>">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit Selected Customer</legend>

                        <!-- Customer ID -->
                        <input type="hidden" name="customerId" value="<?= $data['Customer']->customerId ?>">

                        <!-- Customer Type (Customize as needed) -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerType">Customer
                                        Type</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="customerType" id="customerType" required>
                                        <option value="customer" <?= ($data['Customer']->customerType === 'customer') ? 'selected' : '' ?>>
                                            Customer
                                        </option>
                                        <option value="guest" <?= ($data['Customer']->customerType === 'guest') ? 'selected' : '' ?>>
                                            Guest
                                        </option>
                                        <option value="admin" <?= ($data['Customer']->customerType === 'admin') ? 'selected' : '' ?>>
                                            Admin
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Firstname -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerFirstName">Customer
                                        Firstname</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerFirstName" id="customerFirstName" value="<?= $data['Customer']->customerFirstName ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Lastname -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerLastName">Customer LastName</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerLastName" id="customerLastName" value="<?= $data['Customer']->customerLastName ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Email -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerEmail">Customer
                                        Email</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerEmail" id="customerEmail" value="<?= $data['Customer']->customerEmail ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Phone -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerPhone">Customer
                                        Phone</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerPhone" id="customerPhone" value="<?= $data['Customer']->customerPhone ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Address -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerAddress">Customer
                                        Address</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerAddress" id="customerAddress" value="<?= $data['Customer']->customerAddress ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Customer ZipCode -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerZipCode">Customer
                                        Zipcode</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerZipCode" id="customerZipCode" value="<?= $data['Customer']->customerZipCode ?>" required>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>
                <div class="flex flex-wrap gap-xs justify-between">
                    <button class="btn btn--primary" type="submit">Save</button>
                </div>

            </form>
        </div>
        <div class="bg radius-md shadow-xs">
            <form action="<?= URLROOT; ?>customerscontroller/updateImage/<?= $data['Customer']->customerId ?>" method="post" enctype="multipart/form-data">
                <div class="padding-md">
                    <!-- basic form controls -->
                    <fieldset class="margin-bottom-xl">
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="file">Image</label>
                                </div>
                                <div class="col-6@lg">
                                    <input type="file" name="file" id="file" accept="image/*">
                                </div>
                            </div>
                            <div class="margin-bottom-sm">
                                <div class="grid gap-xxs">
                                    <div class="col-3@lg">
                                        <label class="inline-block text-sm padding-top-xs@lg" for="file">file</label>
                                    </div>
                                    <div class="col-6@lg">
                                        <?php if ($data['imageSrc'] && $data['imageSrc'] !== URLROOT . 'public/default-image.jpg') : ?>
                                            <figure class="user-menu-control__img-wrapper radius-50%">
                                                <img class="user-menu-control__img image_picture" src="<?= $data['imageSrc'] ?>" alt="User picture">
                                            </figure>
                                        <?php else : ?>
                                            <p>There is no image uploaded</p>
                                        <?php endif; ?>
                                        <!-- Add delete button conditionally -->
                                        <?php if ($data['imageSrc'] && $data['imageSrc'] !== URLROOT . 'public/default-image.jpg') : ?>
                                            <a href="<?= URLROOT; ?>customerscontroller/deleteImage/<?= $data['image']->screenId ?>" class="btn btn--danger">Delete Image</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--primary">Save</button>
                    </div>
                </div>
            </form>
        </div>


    </main>
</div>

<!-- dialog -->
<div class="dialog dialog--sticky js-dialog" id="dialog-delete-user-confirmation" data-animation="on">
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1" aria-describedby="dialog-description">
        <div class="text-component">
            <h4 id="dialog-title-1">Are you sure you want to delete this user?</h4>
            <p id="dialog-description">This action cannot be undone.</p>
        </div>

        <footer class="margin-top-md">
            <div class="flex justify-end gap-xs flex-wrap">
                <button class="btn btn--subtle js-dialog__close">Cancel</button>
                <button class="btn btn--accent">Delete</button>
            </div>
        </footer>
    </div>
</div>

<!-- notification popover -->
<div id="notifications-popover" class="popover notif-popover bg radius-md shadow-md js-popover" role="dialog">
    <header class="bg bg-opacity-90% backdrop-blur-10 text-sm padding-sm shadow-xs position-sticky top-0 z-index-2">
        <div class="flex justify-between items-baseline">
            <h1 class="text-md">Notifications</h1>
            <a href="notifications.html" class="js-tab-focus">View all</a>
        </div>
    </header>

    <ul class="notif text-sm">
        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-primary" aria-hidden="true">
                    <img src="assets/img/table-v2-img-1.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p><i class="font-semibold">Olivia Saturday</i> commented on your <i class="font-semibold">"This
                                is all it takes to improve..."</i> post.</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>1 hour ago</time></p>
                    </div>
                </div>

                <div class="notif__dot margin-left-auto" aria-hidden="true"></div>
            </a>
        </li>

        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-accent" aria-hidden="true">
                    <img src="assets/img/table-v2-img-2.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p>It's <i class="font-semibold">David Smith</i>'s birthday. Wish him well!</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>12 hours ago</time></p>
                    </div>
                </div>

                <div class="notif__dot margin-left-auto" aria-hidden="true"></div>
            </a>
        </li>

        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-primary" aria-hidden="true">
                    <img src="assets/img/table-v2-img-3.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p><i class="font-semibold">Marta Rossi</i> posted <i class="font-semibold">"10 helpful tips to
                                learn web design"</i>.</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>a day ago</time></p>

                        <div class="bg radius-md padding-sm shadow-sm margin-top-sm">
                            <p class="color-contrast-medium line-height-lg">Lorem ipsum dolor sit amet consectetur,
                                adipisicing elit. Harum beatae commodi quibusdam officiis...</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>
<script src="assets/js/scripts.js"></script>
</body>

</html>
</footer>
</div>
</div>

<!-- notification popover -->
<div id="notifications-popover" class="popover notif-popover bg radius-md shadow-md js-popover" role="dialog">
    <header class="bg bg-opacity-90% backdrop-blur-10 text-sm padding-sm shadow-xs position-sticky top-0 z-index-2">
        <div class="flex justify-between items-baseline">
            <h1 class="text-md">Notifications</h1>
            <a href="notifications.html" class="js-tab-focus">View all</a>
        </div>
    </header>

    <ul class="notif text-sm">
        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-primary" aria-hidden="true">
                    <img src="assets/img/table-v2-img-1.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p><i class="font-semibold">Olivia Saturday</i> commented on your <i class="font-semibold">"This
                                is all it takes to improve..."</i> post.</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>1 hour ago</time></p>
                    </div>
                </div>

                <div class="notif__dot margin-left-auto" aria-hidden="true"></div>
            </a>
        </li>

        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-accent" aria-hidden="true">
                    <img src="assets/img/table-v2-img-2.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p>It's <i class="font-semibold">David Smith</i>'s birthday. Wish him well!</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>12 hours ago</time></p>
                    </div>
                </div>

                <div class="notif__dot margin-left-auto" aria-hidden="true"></div>
            </a>
        </li>

        <li class="notif__item ">
            <a class="notif__link flex padding-sm" href="#0">
                <figure class="notif__figure margin-right-xs color-primary" aria-hidden="true">
                    <img src="assets/img/table-v2-img-3.jpg" alt="user picture">
                </figure>

                <div class="flex-grow margin-right-xs">
                    <div>
                        <p><i class="font-semibold">Marta Rossi</i> posted <i class="font-semibold">"10 helpful tips
                                to learn web design"</i>.</p>
                        <p class="text-sm color-contrast-medium margin-top-xxxs"><time>a day ago</time></p>

                        <div class="bg radius-md padding-sm shadow-sm margin-top-sm">
                            <p class="color-contrast-medium line-height-lg">Lorem ipsum dolor sit amet consectetur,
                                adipisicing elit. Harum beatae commodi quibusdam officiis...</p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>