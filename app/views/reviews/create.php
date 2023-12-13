<?php require APPROOT . '/views/includes/head.php'; ?>
<!-- main content -->
<main class="app-ui__body padding-md js-app-ui__body">
    <div class="margin-bottom-md">
        <h1 class="text-lg">Create review</h1>
    </div>

    <div class="margin-bottom-md">
        <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
            <ol class="flex flex-wrap gap-xxs">
                <li class="breadcrumbs__item">
                    <a href="<?= URLROOT ?>reviews/index" class="color-inherit">All Reviews</a>
                    <span class="color-contrast-low margin-left-xxs" aria-hidden="true">/</span>
                </li>

                <li class="breadcrumbs__item">#U2123</li>
            </ol>
        </nav>
    </div>

    <div class="bg radius-md shadow-xs">
        <form method="POST" action="<?= URLROOT ?>/reviews/create">
            <div class="grid gap-sm">
                <div class="col-12">
                    <label class="form-label margin-bottom-xxs" for="customerId">Select Customer</label>
                    <select class="form-control width-100" name="reviewCustomerId" id="customerId" required>
                        <?php foreach ($data['Customers'] as $customer) : ?>
                            <option value="<?= $customer->customerId ?>">
                                <?= $customer->customerId . " - " . $customer->customerFirstName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label margin-bottom-xxs" for="entityType">Select Entity Type</label>
                    <select class="form-control width-100" name="entityType" id="entityType" onchange="updateEntityOptions()" required>
                        <option value="1">Order</option>
                        <option value="2">Store</option>
                        <option value="3">Product</option>
                    </select>
                </div>
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
                <div class="col-12 js-productDropdown" style="display:none;">
                    <input type="hidden" name="reviewEntityId" id="productEntityId" value="">
                    <label class="form-label margin-bottom-xxs" for="productId">Select Product</label>
                    <select class="form-control width-100" name="reviewEntityId" id="productId" required>
                        <?php foreach ($data['Products'] as $product) : ?>
                            <option value="<?= $product->productId ?>">
                                <?= $product->productName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label margin-bottom-xxs" for="reviewRating">Rating</label>
                    <input class="form-control width-100" type="number" name="reviewRating" id="reviewRating" required>
                </div>
                <div class="col-12">
                    <label class="form-label margin-bottom-xxs" for="reviewDescription">Review Description</label>
                    <textarea class="form-control width-100" name="reviewDescription" id="reviewDescription" rows="4" required></textarea>
                </div>
                <!-- Add more fields for other review details here -->
            </div>
            <footer class="padding-md border-top border-alpha">
                <div class="flex justify-end gap-xs">
                    <button class="btn btn--subtle js-modal__close">Cancel</button>
                    <button type="submit" class="btn btn--primary" onclick="js-openToast()">Submit Review</button>
                </div>
            </footer>
        </form>

    </div>
</main>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>