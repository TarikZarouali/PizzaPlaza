<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
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

                    <li class="breadcrumbs__item">#R1234</li>
                </ol>
            </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="<?= URLROOT ?>/reviewscontroller/update/<?= $data['review']->reviewId ?>">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit Review</legend>

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

                        <!-- Review Entity ID (Assuming it's related to a product or something similar) -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="reviewEntityId">Review
                                        Entity ID</label>
                                </div>
                                <div class="col-6@lg">
                                    <input class="form-control width-100" type="text" name="reviewEntityId" id="reviewEntityId" value="<?= $data['review']->reviewEntityId ?>" required>
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
                        <button class="btn btn--accent" aria-controls="dialog-delete-review-confirmation">Delete</button>
                        <button class="btn btn--primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg radius-md shadow-xs">
            <form action="<?= URLROOT; ?>reviewscontroller/updateImage/<?= $data['review']->reviewId ?>" method="post" enctype="multipart/form-data">
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
                                            <a href="<?= URLROOT; ?>reviewscontroller/deleteImage/<?= $data['image']->screenId ?>" class="btn btn--danger">Delete Image</a>
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
<div class="dialog dialog--sticky js-dialog" id="dialog-delete-review-confirmation" data-animation="on">
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1" aria-describedby="dialog-description">
        <div class="text-component">
            <h4 id="dialog-title-1">Are you sure you want to delete this review?</h4>
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
<script src="assets/js/scripts.js"></script>
</body>

</html>
<?php require APPROOT . '/views/includes/footer.php'; ?>