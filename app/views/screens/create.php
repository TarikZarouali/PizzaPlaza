<?php require APPROOT . '/views/includes/head.php'; ?>
<!-- main content -->
<main class="app-ui__body padding-md js-app-ui__body">
    <div class="margin-bottom-md">
        <h1 class="text-lg">screen</h1>
    </div>

    <div class="margin-bottom-md">
        <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
            <ol class="flex flex-wrap gap-xxs">
                <li class="breadcrumbs__item">
                    <a href="<?= URLROOT ?>screenscontroller/index" class="color-inherit">All Screens</a>
                    <span class="color-contrast-low margin-left-xxs" aria-hidden="true">/</span>
                </li>

                <li class="breadcrumbs__item">#U2123</li>
            </ol>
        </nav>
    </div>

    <div class="bg radius-md shadow-xs">
        <form method="POST" action="<?= URLROOT ?>/screenscontroller/create">
            <div class="grid gap-sm">
                <div class="col-12">
                    <label class="form-label margin-bottom-xxs" for="entityId">Select Entity</label>
                    <select class="form-control width-100" name="screenEntityId" id="entityId" required>
                        <!-- Replace with your list of available entities -->
                        <option value="1">Entity 1</option>
                        <option value="2">Entity 2</option>
                        <option value="3">Entity 3</option>
                        <!-- Add more entity options as needed -->
                    </select>
                </div>
                <!-- Add more fields for other screen details here -->
            </div>
            <footer class="padding-md border-top border-alpha">
                <div class="flex justify-end gap-xs">
                    <button class="btn btn--subtle js-modal__close">Cancel</button>
                    <button type="submit" class="btn btn--primary" onclick="js-openToast()">Create Screen</button>
                </div>
            </footer>
        </form>

    </div>
</main>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>