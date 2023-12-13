<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">

    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Update selected employee</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>employees/overview/{page:1}}/" class="color-inherit">All Employees</a>
                    </li>

                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>/employees/update/{employeeId:<?= $data['Employee']->employeeId ?>}">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit form</legend>

                        <!-- Employee ID (hidden input for updating the correct employee) -->
                        <input type="hidden" name="employeeId" value="<?= $data['Employee']->employeeId ?>">

                        <!-- Select Store -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="employeeStoreId">Select
                                        Store</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="employeeStoreId" id="employeeStoreId" required>
                                        <?php foreach ($data['Store'] as $store) : ?>
                                            <option value="<?= $store->storeId ?>" <?= ($store->storeId == $data['Employee']->employeeStoreId) ? 'selected' : '' ?>>
                                                <?= $store->storeId . "-" . $store->storeStreetName ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Firstname -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="employeeFirstName">employee
                                        Firstname</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="employeeFirstName" id="employeeFirstName" value="<?= $data['Employee']->employeeFirstName ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Lastname -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerLastName">Employee LastName</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="employeeLastName" id="employeeLastName" value="<?= $data['Employee']->employeeLastName ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Zipcode -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="employeeZipCode">Employee
                                        Zipcode</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="employeeZipCode" id="employeeZipCode" value="<?= $data['Employee']->employeeZipCode ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Role -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="employeeRole">Employee
                                        Role</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="employeeRole" id="employeeRole" required>
                                        <option value="baker" <?= ($data['Employee']->employeeRole === 'Employee') ? 'selected' : '' ?>>
                                            Baker
                                        </option>
                                        <option value="deliverer" <?= ($data['Employee']->employeeRole === 'deliverer') ? 'selected' : '' ?>>
                                            Deliverer
                                        </option>
                                        <option value="manager" <?= ($data['Employee']->employeeRole === 'manager') ? 'selected' : '' ?>>
                                            Manager
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Description -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="employeeDescription">Employee Description</label>
                                </div>
                                <div class="col-6@lg">
                                    <textarea class="form-control width-100" name="employeeDescription" id="employeeDescription" required><?= $data['Employee']->employeeDescription ?></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--accent" aria-controls="dialog-delete-vehicle-confirmation">Delete</button>
                        <button class="btn btn--primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg radius-md shadow-xs">
            <form action="<?= URLROOT; ?>employees/updateImage/{employeeId:<?= $data['Employee']->employeeId ?>}" method="post" enctype="multipart/form-data">
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
                                            <a href="#" aria-controls="dialog-delete-user-confirmation" class="btn btn--danger">Delete Image</a>
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

<!-- DIALOG -->
<div class="dialog dialog--sticky js-dialog" id="dialog-delete-user-confirmation" data-animation="on">
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1" aria-describedby="dialog-description">
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
                <a class="btn btn--accent" href="<?= URLROOT; ?>employees/deleteImage/{screenId:<?= $data['image']->screenId . ';' . 'employeeId:' . $data['Employee']->employeeId ?>}">Delete</a>
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
                        <p><i class="font-semibold">Marta Rossi</i> posted <i class="font-semibold">"10 helpful tips
                                to
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