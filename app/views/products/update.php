<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Edit Selected Product</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>products/overview//{page:1}}/" class="color-inherit">All Products</a>
                    </li>

                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>products/update/{productId:<?= $data['Product']->productId ?>}">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit form</legend>

                        <!-- Product ID -->
                        <input type="hidden" name="productId" value="<?= $data['Product']->productId ?>">

                        <!-- Product Name -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="productName">Product
                                        Name</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="productName"
                                        id="productName" value="<?= $data['Product']->productName ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg"
                                        for="productDescription">Product Description</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="productDescription"
                                        id="productDescription" value="<?= $data['Product']->productDescription ?>"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Product Price -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="productPrice">Product
                                        Price</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="productPrice"
                                        id="productPrice" value="<?= $data['Product']->productPrice ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Check if 'productType' exists before using it -->
                        <?php if (isset($data['Product']->productType)) : ?>
                        <!-- Product Type (Customize as needed) -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="productType">Product
                                        Type</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="productType" id="productType" required>
                                        <option value="pizza"
                                            <?= ($data['Product']->productType === 'pizza') ? 'selected' : '' ?>>Pizza
                                        </option>
                                        <option value="coupons"
                                            <?= ($data['Product']->productType === 'coupons') ? 'selected' : '' ?>>
                                            Coupons</option>
                                        <option value="drinks"
                                            <?= ($data['Product']->productType === 'drinks') ? 'selected' : '' ?>>Drinks
                                        </option>
                                        <option value="snacks"
                                            <?= ($data['Product']->productType === 'snacks') ? 'selected' : '' ?>>Snacks
                                        </option>
                                        <!-- Add more options based on your product types -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </fieldset>
                </div>
                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg radius-md shadow-xs">
            <form action="<?= URLROOT; ?>products/updateImage/{productId:<?= $data['Product']->productId ?>}"
                method="post" enctype="multipart/form-data">
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
                                            <img class="user-menu-control__img image_picture"
                                                src="<?= $data['imageSrc'] ?>" alt="User picture">
                                        </figure>
                                        <?php else : ?>
                                        <p>There is no image uploaded</p>
                                        <?php endif; ?>
                                        <!-- Add delete button conditionally -->
                                        <?php if ($data['imageSrc'] && $data['imageSrc'] !== URLROOT . 'public/default-image.jpg') : ?>
                                        <a href="#" aria-controls="dialog-delete-user-confirmation"
                                            class="btn btn--danger">Delete Image</a>

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
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1"
        aria-describedby="dialog-description">
        <div class="text-component">
            <br>
            <br>
            <h4 id="dialog-title-1">Are you sure you want to delete this image?
            </h4>
            <p id="dialog-description">This action cannot be undone.</p>
        </div>
        <footer class="margin-top-md">
            <div class="flex justify-end gap-xs flex-wrap">
                <button class="btn btn--subtle js-dialog__close">Cancel</button>
                <a class="btn btn--accent"
                    href="<?= URLROOT; ?>employees/deleteImage/{screenId:<?= $data['image']->screenId . ';' . 'productId:' . $data['Product']->productId ?>}">Delete</a>
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