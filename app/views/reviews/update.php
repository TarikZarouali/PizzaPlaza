<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Update selected review</h1>
        </div>

        <div class="margin-bottom-md">
            <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
                <ol class="flex flex-wrap gap-xxs">
                    <li class="breadcrumbs__item">
                        <a href="<?= URLROOT ?>reviews/overview/{page:1}}/" class="color-inherit">All Reviews</a>
                    </li>


                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>/reviews/update/{reviewId:<?= $data['review']->reviewId ?>}">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit form</legend>

                        <!-- Review ID (hidden input for updating the correct review) -->
                        <input type="hidden" name="reviewId" value="<?= $data['review']->reviewId ?>">

                        <!-- Select Customer -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="reviewCustomerId">Select
                                        Customer</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="reviewCustomerId" id="reviewCustomerId" required>
                                        <?php foreach ($data['Customer'] as $customer) : ?>
                                            <option value="<?= $customer->customerId ?>" <?= ($customer->customerId == $data['review']->reviewCustomerId) ? 'selected' : '' ?>>
                                                <?= $customer->customerId . "-" . $customer->customerFirstName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="form-label margin-bottom-xxs" for="entityType">Select Entity
                                        Type</label>
                                    <select class="form-control width-100" name="entityType" id="entityType" onchange="updateEntityOptions()" required>
                                        <option value="1">Order</option>
                                        <option value="2">Store</option>
                                        <option value="3">Product</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <div class="col-12 js-storeDropdown" style="display:none;">
                                        <input type="hidden" name="reviewEntityId" id="storeEntityId" value="">
                                        <label class="form-label margin-bottom-xxs" for="storeId">Select Store</label>
                                        <select class="form-control width-100" name="reviewEntityId" id="storeId" required>
                                            <?php foreach ($data['Stores'] as $store) : ?>
                                                <option value="<?= $store->storeId ?>">
                                                    <?= $store->storeStreetName ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <div class="col-12 js-orderDropdown" style="display:none;">
                                        <input type="hidden" name="reviewEntityId" id="orderEntityId" value="">
                                        <label class="form-label margin-bottom-xxs" for="orderId">Select Order</label>
                                        <select class="form-control width-100" name="reviewEntityId" id="orderId" required>
                                            <?php foreach ($data['Orders'] as $order) : ?>
                                                <option value="<?= $order->orderId ?>">
                                                    <?= $order->orderId ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <div class="col-12 js-productDropdown" style="display:none;">
                                        <input type="hidden" name="reviewEntityId" id="productEntityId" value="">
                                        <label class="form-label margin-bottom-xxs" for="productId">Select
                                            Product</label>
                                        <select class="form-control width-100" name="reviewEntityId" id="productId" required>
                                            <?php foreach ($data['Products'] as $product) : ?>
                                                <option value="<?= $product->productId ?>">
                                                    <?= $product->productName ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Rating -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="reviewRating">Review
                                        Rating</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100" type="number" name="reviewRating" id="reviewRating" value="<?= $data['review']->reviewRating ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Review Description -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="reviewDescription">Review
                                        Description</label>
                                </div>
                                <div class="col-6@lg">
                                    <textarea class="form-control width-100" name="reviewDescription" id="reviewDescription" rows="4" required><?= $data['review']->reviewDescription ?></textarea>
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
        <div class="bg radius-md shadow-xs">
            <form action="<?= URLROOT; ?>reviews/updateImage/{reviewId:<?= $data['review']->reviewId ?>}" method="post" enctype="multipart/form-data">
                <div class="padding-md">
                    <!-- basic form controls -->
                    <fieldset class="margin-bottom-xl">
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="file">Image</label>
                                </div>
                                <div class="col-6@lg">
                                    <input type="file" name="file[]" id="file" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="screenScope">Screen
                                        Scope</label>
                                </div>
                                <div class="col-6@lg">
                                    <input type="text" name="screenScope[]" class="form-control width-100%" id="screenScope">
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="file">Files</label>
                                </div>
                                <div class="col-6@lg">
                                    <?php foreach ($data['images'] as $image) : ?>
                                        <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-2@xl">
                                            <div class="flex flex-wrap gap-xxs items-center">
                                                <div>
                                                    <h3 class="color-contrast-low">
                                                        <?= !empty($image->screenScope) ? $image->screenScope : "No Scope" ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <img class="text-xxl font-semibold color-contrast-higher" src="<?= $image->imagePath ?>" height="200px" width="100%">
                                            <?php if ($image && $image !== URLROOT . 'public/default-image.jpg') : ?>
                                                <!-- Modify the link to include aria-controls dynamically -->
                                                <a href="#" aria-controls="dialog-delete-user-confirmation" class="btn btn--danger">Delete Image</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
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
            <br>
            <br>
            <h4 id="dialog-title-1">Are you sure you want to delete this image?
            </h4>
            <p id="dialog-description">This action cannot be undone.</p>
        </div>
        <footer class="margin-top-md">
            <div class="flex justify-end gap-xs flex-wrap">
                <button class="btn btn--subtle js-dialog__close">Cancel</button>
                <a class="btn btn--accent" href="<?= URLROOT; ?>reviews/deleteImage/{screenId:<?= $image->screenId . ';' . 'reviewId:' . $data['review']->reviewId ?>}">Delete</a>
            </div>
        </footer>
    </div>
</div>
<script src="assets/js/scripts.js"></script>
</body>

</html>
<?php require APPROOT . '/views/includes/footer.php'; ?>