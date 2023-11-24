<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="container">
    <div class="text-center">
        <h1>Choose a store</h1>
    </div>

    <div class="grid gap-md">
        <?php foreach ($data['Stores'] as $store) { ?>
        <div class="card col-4">
            <div class="padding-xs">
                <h4><?= $store->storeCity ?></h4>

                <p class="margin-top-xs margin-bottom-sm text-sm color-contrast-medium line-height-md">
                    <?= $store->storeStreetName . ' ' . $store->storeZipCode ?>
                </p>
                <p class="margin-top-xs margin-bottom-sm text-sm color-contrast-medium line-height-md">
                    <?= $store->storePhone ?>
                </p>

                <footer>
                    <a href="<?= URLROOT; ?>stores/index/<?= $store->storeId ?>" class="btn btn--primary text-sm">Go to
                        shop</a>
                </footer>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?>