<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
    <div class="toast toast--hidden toast--top-right js-toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast-5">
        <div class="flex items-start justify-between">
            <div class="toast__icon-wrapper toast__icon-wrapper--success margin-right-xs">
                <svg class="icon" viewBox="0 0 16 16">
                    <title>Success</title>
                    <g>
                        <path d="M6,15a1,1,0,0,1-.707-.293l-5-5A1,1,0,1,1,1.707,8.293L5.86,12.445,14.178.431a1,1,0,1,1,1.644,1.138l-9,13A1,1,0,0,1,6.09,15C6.06,15,6.03,15,6,15Z">
                        </path>
                    </g>
                </svg>
            </div>

            <div class="text-component text-sm">
                <h1 class="toast__title text-md">Title Five</h1>
                <p class="toast__p">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Explicabo esse
                    maiores assumenda.</p>
            </div>

            <button class="reset toast__close-btn margin-left-xxxxs js-toast__close-btn js-tab-focus">
                <svg class="icon" viewBox="0 0 12 12">
                    <title>Close notification</title>
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <line x1="1" y1="1" x2="11" y2="11" />
                        <line x1="11" y1="1" x2="1" y2="11" />
                    </g>
                </svg>
            </button>
        </div>
    </div>

    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Create order</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>orders/overview/" class="color-inherit">All Orders</a>
                        <span class="color-contrast-low margin-left-xxs" aria-hidden="true">/</span>
                    </li>

                    <li class="breadcrumbs__item">#U2123</li>
                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>/orders/create">
                <div class="grid gap-sm">

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="orderCustomerId">Select Customer</label>
                        <select class="form-control width-100" name="orderCustomerId" id="orderCustomerId" required>
                            <?php foreach ($data['Customers'] as $customer) : ?>
                                <option value="<?= $customer->customerId ?>">
                                    <?= $customer->customerId . '-' . $customer->customerType . '-' . $customer->customerFirstName . '-' . $customer->customerLastName ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="storeId">Select Store</label>
                        <select class="form-control width-100" name="orderStoreId" id="storeId" required>
                            <?php foreach ($data['Stores'] as $store) : ?>
                                <option value="<?= $store->storeId ?>">
                                    <?= $store->storeId . "-" . $store->storeStreetName ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="orderState">Select order state</label>
                        <select class="form-control width-100" name="orderState" id="orderState" required>
                            <option value="inTheMake">In the make</option>
                            <option value="inOven">In the oven</option>
                            <option value="isDelivered">Is delivered</option>
                            <!-- Add more vehicle types as needed -->
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="orderStatus">Select order status</label>
                        <select class="form-control width-100" name="orderStatus" id="orderStatus" required>
                            <option value="succes">Succes</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                            <!-- Add more vehicle types as needed -->
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="modal-customer-orderPrice">Price</label>
                        <input class="form-control" type="number" step="0.01" min="0" name="orderPrice" id="modal-customer-orderPrice" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label margin-bottom-xxs" for="modal-customer-orderDescription">Description</label>
                        <textarea class="form-control width-100%" name="orderDescription" id="modal-customer-orderDescription" rows="3" required></textarea>
                    </div>


                    <!-- Add more fields for other vehicle details here -->
                </div>
                <footer class="padding-md border-top border-alpha">
                    <div class="flex justify-end gap-xs">
                        <button class="btn btn--subtle js-modal__close">Cancel</button>
                        <button type="submit" class="btn btn--primary" onclick="js-openToast()">Save</button>
                    </div>
                </footer>
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