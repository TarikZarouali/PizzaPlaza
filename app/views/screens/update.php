<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="app-ui js-app-ui">
    <!-- main content -->
    <main class="app-ui__body padding-md js-app-ui__body">
        <div class="margin-bottom-md">
            <h1 class="text-lg">Screen</h1>
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
            <form method="POST" action="<?= URLROOT ?>/screenscontroller/update/<?= $data['screen']->screenId ?>">
                <div class="padding-md">
                    <fieldset class="margin-bottom-xl">
                        <legend class="form-legend margin-bottom-md">Edit Screen</legend>

                        <!-- Screen ID (hidden input for updating the correct screen) -->
                        <input type="hidden" name="screenId" value="<?= $data['screen']->screenId ?>">

                        <!-- Select Entity -->
                        <div class="margin-bottom-sm">
                            <div class="grid gap-xxs">
                                <div class="col-3@lg">
                                    <label class="inline-block text-sm padding-top-xs@lg" for="screenEntityId">Select
                                        Entity</label>
                                </div>
                                <div class="col-6@lg">
                                    <select class="form-control width-100" name="screenEntityId" id="screenEntityId"
                                        required>
                                        <!-- Replace with your list of available entities -->
                                        <option value="1"
                                            <?= ($data['screen']->screenEntityId == 1) ? 'selected' : '' ?>>Entity 1
                                        </option>
                                        <option value="2"
                                            <?= ($data['screen']->screenEntityId == 2) ? 'selected' : '' ?>>Entity 2
                                        </option>
                                        <option value="3"
                                            <?= ($data['screen']->screenEntityId == 3) ? 'selected' : '' ?>>Entity 3
                                        </option>
                                        <!-- Add more entity options as needed -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Add more fields for other screen details here -->
                    </fieldset>
                </div>

                <div class="border-top border-alpha padding-md">
                    <div class="flex flex-wrap gap-xs justify-between">
                        <button class="btn btn--accent"
                            aria-controls="dialog-delete-screen-confirmation">Delete</button>
                        <button class="btn btn--primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- dialog -->
<div class="dialog dialog--sticky js-dialog" id="dialog-delete-screen-confirmation" data-animation="on">
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1"
        aria-describedby="dialog-description">
        <div class="text-component">
            <h4 id="dialog-title-1">Are you sure you want to delete this screen?</h4>
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