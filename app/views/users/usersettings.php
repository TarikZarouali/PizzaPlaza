<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="app-ui js-app-ui">
    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Update selected order</h1>
        </div>



        <div class="bg radius-md shadow-xs">
            <form method="POST" onsubmit="editUser(event)" id="editUserForm">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit form</legend>

                        <!-- Order ID (hidden input for updating the correct order) -->
                        <input type="hidden" name="orderId" value="<?= $_SESSION['user']->customerFirstName ?>">



                        <!-- customer first name -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerFirstName">First
                                        name</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerFirstName" id="customerFirstName" value="<?= $_SESSION['user']->customerFirstName ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer last name -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerLastName">Last
                                        name</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerLastName" id="customerLastName" value="<?= $_SESSION['user']->customerLastName ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer email -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerEmail">Email</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerEmail" id="customerEmail" value="<?= $_SESSION['user']->customerEmail ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer password -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerPassword">Password</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerPassword" id="customerPassword" value="<?= $_SESSION['user']->customerPassword ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer phone -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerPhone">Phone
                                        number</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerPhone" id="customerPhone" value="<?= $_SESSION['user']->customerPhone ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer address -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerAddress">Address</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerAddress" id="customerAddress" value="<?= $_SESSION['user']->customerAddress ?>">
                                </div>
                            </div>
                        </div>

                        <!-- customer ZipCode -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="customerZipCode">Address</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100%" type="text" name="customerZipCode" id="customerZipCode" value="<?= $_SESSION['user']->customerZipCode ?>">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--primary" type="submit">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </main>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?>