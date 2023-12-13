<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Update selected order</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>orders/overview//{page:1}}/" class="color-inherit">All Orders</a>
                    </li>

                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>/orders/update/{orderId:<?= $data['Orders']->orderId ?>}">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit form</legend>

                        <!-- Order ID (hidden input for updating the correct order) -->
                        <input type="hidden" name="orderId" value="<?= $data['Orders']->orderId ?>">

                        <!-- Select Customer -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderCustomerId">Select
                                        Customer</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="orderCustomerId" id="orderCustomerId" required>
                                        <?php foreach ($data['Customers'] as $customer) : ?>
                                            <option value="<?= $customer->customerId ?>" <?= ($customer->customerId == $data['Orders']->orderCustomerId) ? 'selected' : '' ?>>
                                                <?= $customer->customerId . '-' . $customer->customerFirstName . ' ' . $customer->customerLastName ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Select Store -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderStoreId">Select
                                        Store</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="orderStoreId" id="orderStoreId" required>
                                        <?php foreach ($data['Stores'] as $store) : ?>
                                            <option value="<?= $store->storeId ?>" <?= ($store->storeId == $data['Orders']->orderStoreId) ? 'selected' : '' ?>>
                                                <?= $store->storeId . "-" . $store->storeStreetName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Select State -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderState">Select Order
                                        State</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="orderState" id="orderState" required>
                                        <option value="inTheMake" <?= ($data['Orders']->orderState === 'inTheMake') ? 'selected' : '' ?>>In
                                            the make</option>
                                        <option value="inOven" <?= ($data['Orders']->orderState === 'inOven') ? 'selected' : '' ?>>In the
                                            oven</option>
                                        <option value="isDelivered" <?= ($data['Orders']->orderState === 'isDelivered') ? 'selected' : '' ?>>Is
                                            delivered</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Select Status -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderStatus">Select Order
                                        Status</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="orderStatus" id="orderStatus" required>
                                        <option value="pending" <?= ($data['Orders']->orderStatus === 'pending') ? 'selected' : '' ?>>
                                            Pending</option>
                                        <option value="succes" <?= ($data['Orders']->orderStatus === 'succes') ? 'selected' : '' ?>>Success
                                        </option>
                                        <option value="failed" <?= ($data['Orders']->orderStatus === 'failed') ? 'selected' : '' ?>>Failed
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- order Price -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderDescription">Order
                                        Price</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="orderPrice" id="orderPrice" value="<?= $data['Orders']->orderPrice ?>">
                                </div>
                            </div>
                        </div>

                        <!-- order Description -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="orderDescription">Order
                                        Description</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="orderDescription" id="orderDescription" value="<?= $data['Orders']->orderDescription ?>">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--accent" aria-controls="dialog-delete-order-confirmation">Delete</button>
                        <button class="btn btn--primary" type="submit">Save</button>
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