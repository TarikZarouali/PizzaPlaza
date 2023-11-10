<?php require APPROOT . '/views/includes/head.php'; ?>
<!-- main content -->
<main class="app-ui__body padding-md js-app-ui__body">
    <div class="margin-bottom-md">
        <h1 class="text-lg">Review</h1>
    </div>

    <div class="margin-bottom-md">
        <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
            <ol class="flex flex-wrap gap-xxs">
                <li class="breadcrumbs__item">
                    <a href="<?= URLROOT ?>reviewscontroller/index" class="color-inherit">All Reviews</a>
                    <span class="color-contrast-low margin-left-xxs" aria-hidden="true">/</span>
                </li>

                <li class="breadcrumbs__item">#U2123</li>
            </ol>
        </nav>
    </div>

    <div class="bg radius-md shadow-xs">
        <form method="POST" action="<?= URLROOT ?>/reviewscontroller/create">
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
                    <label class="form-label margin-bottom-xxs" for="entityId">Select Entity</label>
                    <select class="form-control width-100" name="reviewEntityId" id="entityId" required>
                        <!-- Replace with your list of available entities -->
                        <option value="1">Entity 1</option>
                        <option value="2">Entity 2</option>
                        <option value="3">Entity 3</option>
                        <!-- Add more entity options as needed -->
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