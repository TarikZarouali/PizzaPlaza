<?php require APPROOT . '/views/includes/header.php'; ?>

<section class="adv-filter padding-y-lg js-adv-filter">
    <div class="container max-width-adaptive-lg">
        <div class="margin-bottom-md hide@md no-js:is-hidden">
            <button class="btn btn--subtle width-100%" aria-controls="filter-panel">Show filters</button>
        </div>

        <div class="flex@md">
            <aside id="filter-panel" class="sidebar sidebar--static@md js-sidebar" aria-labelledby="filter-panel-title">
                <div class="sidebar__panel max-width-100% width-100%">
                    <header class="sidebar__header bg padding-y-sm padding-x-md border-bottom z-index-2">
                        <h1 class="text-md text-truncate" id="filter-panel-title">Filters</h1>

                        <button class="reset sidebar__close-btn js-sidebar__close-btn js-tab-focus">
                            <svg class="icon icon--xs" viewBox="0 0 16 16">
                                <title>Close panel</title>
                                <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10">
                                    <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                                    <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                                </g>
                            </svg>
                        </button>
                    </header>

                    <form>
                        <div class="padding-md padding-0@md margin-bottom-sm@md">
                            <a style="margin-bottom:1rem;" href="<?= URLROOT ?>homepages/overview/"
                                class="btn btn--primary">reset all filters</a>

                            <div class="search-input search-input--icon-left text-sm@md">
                                <input class="search-input__input form-control" type="search" name="search" id="search"
                                    aria-label="Search" data-filter="searchInput" aria-controls="adv-filter-gallery"
                                    value="<?= $data['params']['search'] ?? '' ?>">

                                <button type="submit" class="search-input__btn">
                                    <svg class="icon" viewBox="0 0 20 20">
                                        <title>Submit</title>
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <circle cx="8" cy="8" r="6" />
                                            <line x1="12.242" y1="12.242" x2="18" y2="18" />
                                        </g>
                                    </svg>
                                </button>
                            </div>

                        </div>

                        <ul class="accordion js-accordion" data-animation="on" data-multi-items="on">
                            <li class="accordion__item accordion__item--is-open js-accordion__item js-adv-filter__item"
                                data-default-text="All" data-multi-select-text="{n} filters selected">
                                <button
                                    class="reset accordion__header padding-y-sm padding-x-md padding-x-xs@md js-tab-focus"
                                    type="button">
                                    <div>
                                        <div class="text-sm@md">Ingredients</div>
                                        <div class="text-sm color-contrast-low">
                                            <i class="sr-only">Active filters:</i>
                                            <span class="js-adv-filter__selection">
                                                <?php
                                                $selectedIngredients = $data['params']['ingredients'] ?? [];
                                                echo !empty($selectedIngredients) ? count($selectedIngredients) . ' selected' : 'All';
                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden" viewBox="0 0 20 20">
                                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </g>
                                    </svg>
                                </button>

                                <div class="accordion__panel js-accordion__panel">
                                    <div class="padding-top-xxxs padding-x-md padding-bottom-md padding-x-xs@md">
                                        <?php foreach ($data['ingredients'] as $ingredient) : ?>
                                        <div>
                                            <input class="checkbox" name="ingredients" type="checkbox"
                                                id="checkbox-<?= $ingredient->ingredientId ?>"
                                                value="<?= $ingredient->ingredientId ?>"
                                                data-filter="<?= $ingredient->ingredientId ?>"
                                                <?= in_array($ingredient->ingredientId, $selectedIngredients) ? 'checked' : '' ?>>
                                            <label for="checkbox-<?= $ingredient->ingredientId ?>">
                                                <?= $ingredient->ingredientName ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>



                            <li class="accordion__item js-accordion__item js-adv-filter__item" data-default-text="All">
                                <button
                                    class="reset accordion__header padding-y-sm padding-x-md padding-x-xs@md js-tab-focus"
                                    type="button">
                                    <div>
                                        <div class="text-sm@md">product category</div>
                                        <div class="text-sm color-contrast-low"><i class="sr-only">Active filters:
                                            </i><span class="js-adv-filter__selection">All</span></div>
                                    </div>

                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden" viewBox="0 0 20 20">
                                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </g>
                                    </svg>
                                </button>

                                <div class="accordion__panel js-accordion__panel">
                                    <div class="padding-top-xxxs padding-x-md padding-bottom-md padding-x-xs@md">
                                        <ul class="adv-filter__radio-list flex flex-column gap-xxxs"
                                            aria-controls="adv-filter-gallery">
                                            <li>
                                                <input class="radio" type="radio" value="" name="type" id="radio-all"
                                                    data-filter="*" checked>
                                                <label for="radio-all">All</label>
                                            </li>
                                            <?php foreach ($data['productTypes'] as $key => $value) : ?>
                                            <li>
                                                <input class="radio" type="radio" name="type" id="radio-<?= $key ?>"
                                                    data-filter="<?= $key ?>" value="<?= $key ?>"
                                                    <?= $key == ($data['params']['type'] ?? '') ? 'checked' : '' ?>>
                                                <label for="radio-<?= $key ?>"><?= $value ?></label>
                                            </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>

                            </li>

                            <li class="accordion__item accordion__item--is-open js-accordion__item js-adv-filter__item">
                                <button
                                    class="reset accordion__header padding-y-sm padding-x-md padding-x-xs@md js-tab-focus"
                                    type="button">
                                    <div>
                                        <div class="text-sm@md">Price Range</div>
                                        <div class="text-sm color-contrast-low">
                                            <i class="sr-only">Active filters:</i>
                                            <span class="js-adv-filter__selection">
                                                $<?= $data['params']['pricemin'] ?? '1' ?> -
                                                $<?= $data['params']['pricemax'] ?? '20' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden" viewBox="0 0 20 20">
                                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </g>
                                    </svg>
                                </button>

                                <div class="accordion__panel js-accordion__panel">
                                    <div
                                        class="padding-top-xxxs padding-x-md padding-bottom-md padding-x-xs@md flex justify-center">
                                        <div class="slider slider--multi-value js-slider ">
                                            <div class="slider__range">
                                                <label class="sr-only" for="min">Slider min value</label>
                                                <input class="slider__input" type="range" id="slider-min-value"
                                                    name="pricemin" min="1" max="20" step="1"
                                                    value="<?= $data['params']['pricemin'] ?? '1' ?>">
                                            </div>

                                            <div class="slider__range">
                                                <label class="sr-only" for="max">Slider max value</label>
                                                <input class="slider__input" type="range" id="slider-max-value"
                                                    name="pricemax" min="1" max="20" step="1"
                                                    value="<?= $data['params']['pricemax'] ?? '20' ?>">
                                            </div>

                                            <div class="margin-top-xs text-center text-sm" aria-hidden="true">
                                                <span class="slider__value">
                                                    $<span
                                                        class="js-slider__value"><?= $data['params']['pricemin'] ?? '1' ?></span>
                                                    -
                                                    $<span
                                                        class="js-slider__value"><?= $data['params']['pricemax'] ?? '20' ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li class="accordion__item js-accordion__item js-adv-filter__item" data-default-text="All"
                                data-multi-select-text="{n} filters selected" data-number-format="{n}+">
                                <button
                                    class="reset accordion__header padding-y-sm padding-x-md padding-x-xs@md js-tab-focus"
                                    type="button">
                                    <div>
                                        <div class="text-sm@md">Review rating</div>
                                        <div class="text-sm color-contrast-low">
                                            <i class="sr-only">Active filters:</i>
                                            <span class="js-adv-filter__selection">
                                                <?php echo isset($data['params']['rating']) ? $data['params']['rating'] : 'All'; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden" viewBox="0 0 20 20">
                                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </g>
                                    </svg>
                                </button>

                                <div class="accordion__panel js-accordion__panel">
                                    <div class="padding-top-xxxs padding-x-md padding-bottom-md padding-x-xs@md">
                                        <div class="flex justify-between items-center">
                                            <label class="text-sm" for="rating">Quantity</label>

                                            <div class="number-input number-input--v2 js-number-input js-filter__custom-control"
                                                aria-controls="adv-filter-gallery" data-filter="indexValue">
                                                <input class="form-control text-sm@md js-number-input__value"
                                                    type="number" name="rating" id="rating" min="0" max="10" step="1"
                                                    value="<?php echo isset($data['params']['rating']) ? $data['params']['rating'] : '0'; ?>">

                                                <button
                                                    class="reset number-input__btn number-input__btn--plus js-number-input__btn"
                                                    aria-label="Increase Number">
                                                    <svg class="icon" viewBox="0 0 12 12" aria-hidden="true">
                                                        <path
                                                            d="M11,5H7V1A1,1,0,0,0,5,1V5H1A1,1,0,0,0,1,7H5v4a1,1,0,0,0,2,0V7h4a1,1,0,0,0,0-2Z" />
                                                    </svg>
                                                </button>

                                                <button
                                                    class="reset number-input__btn number-input__btn--minus js-number-input__btn"
                                                    aria-label="Decrease Number">
                                                    <svg class="icon" viewBox="0 0 12 12" aria-hidden="true">
                                                        <path d="M11,7H1A1,1,0,0,1,1,5H11a1,1,0,0,1,0,2Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li
                                class="accordion__item accordion__item--is-open position-relative z-index-2 js-accordion__item js-adv-filter__item">
                                <button
                                    class="reset accordion__header padding-y-sm padding-x-md padding-x-xs@md js-tab-focus"
                                    type="button">
                                    <div>
                                        <div class="text-sm@md">Select</div>
                                        <div class="text-sm color-contrast-low"><i class="sr-only">Active filters:
                                            </i><span class="js-adv-filter__selection">All</span></div>
                                    </div>
                                    <svg class="icon accordion__icon-arrow-v2 no-js:is-hidden" viewBox="0 0 20 20">
                                        <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="3" y1="3" x2="17" y2="17" />
                                            <line x1="17" y1="3" x2="3" y2="17" />
                                        </g>
                                    </svg>
                                </button>

                                <div class="accordion__panel js-accordion__panel">
                                    <div class="padding-top-xxxs padding-x-md padding-bottom-md padding-x-xs@md flex">
                                        <label class="sr-only" for="select-filter-option">Select Option:</label>

                                        <div class="select width-100% js-select"
                                            data-trigger-class="btn btn--subtle flex-grow">
                                            <!-- data-trigger-class -> custom select component 👆 -->
                                            <select name="select-filter-option" id="select-filter-option"
                                                aria-controls="adv-filter-gallery" data-filter="true">
                                                <option value="" disabled selected>All</option>
                                                <?php foreach ($data['stores'] as $store) : ?>
                                                <option value="<?php echo $store->storeId; ?>">
                                                    <?php echo $store->storeStreetName; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <svg class="icon icon--xxs margin-left-xxs" aria-hidden="true"
                                                viewBox="0 0 12 12">
                                                <path
                                                    d="M10.947,3.276A.5.5,0,0,0,10.5,3h-9a.5.5,0,0,0-.4.8l4.5,6a.5.5,0,0,0,.8,0l4.5-6A.5.5,0,0,0,10.947,3.276Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <ul style="margin: 20px;">
                                <?php if (isset($_SESSION['user'])) : ?>
                                <button class="btn btn--primary" aria-controls="modal-form">Show form</button>

                                <div class="modal modal--animate-scale flex flex-center bg-black bg-opacity-90% padding-md js-modal"
                                    id="modal-form">
                                    <div class="modal__content width-100% max-width-xs max-height-100% overflow-auto padding-md bg radius-md inner-glow shadow-md"
                                        role="alertdialog" aria-labelledby="modal-form-title"
                                        aria-describedby="modal-form-description">
                                        <div class="text-component margin-bottom-md">
                                            <h3 id="modal-form-title">Join our Newsletter</h3>
                                            <p id="modal-form-description">Lorem ipsum dolor, sit amet consectetur
                                                adipisicing
                                                elit. Suscipit asperiores molestiae ex.</p>
                                        </div>

                                        <form class="margin-bottom-sm">
                                            <div class="flex flex-column flex-row@xs gap-xxxs">
                                                <input aria-label="Email" class="form-control flex-grow" type="email"
                                                    placeholder="Email">
                                                <button class="btn btn--primary">Subscribe</button>
                                            </div>
                                        </form>

                                        <div class="text-component">
                                            <p class="text-xs color-contrast-medium">Lorem ipsum dolor sit, amet <a
                                                    href="#0" class="color-contrast-high">consectetur adipisicing</a>
                                                elit. Nisi molestias
                                                hic voluptatibus.</p>
                                        </div>
                                    </div>

                                    <button
                                        class="reset modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
                                        <svg class="icon icon--sm" viewBox="0 0 24 24">
                                            <title>Close modal window</title>
                                            <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="3" y1="3" x2="21" y2="21" />
                                                <line x1="21" y1="3" x2="3" y2="21" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                                <?php endif ?>
                            </ul>

                        </ul>
                        <button type="submit" class="btn btn--primary text-sm width-100%">Apply Filters</button>
                    </form>
                </div>
            </aside>

            <main class="flex-grow padding-left-xl@md sidebar-loaded:show">
                <div class="flex items-center justify-between margin-bottom-sm">
                    <p class="text-sm"><span class="js-adv-filter__results-count"></span>
                        results</p>

                    <div class="flex items-baseline">
                        <label class="text-sm color-contrast-medium margin-right-xs" for="select-sorting">Sort:</label>

                        <?php
                        // Generate links for each sorting option within the same container
                        $currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
                        ?> <a href="<?php echo $currentUrl; ?>?sort=price-asc"
                            class="text-sm color-contrast-medium margin-right-xs">Price Ascending</a>
                        <a href="<?php echo $currentUrl; ?>?sort=price-desc"
                            class="text-sm color-contrast-medium margin-right-xs">Price Descending</a>
                    </div>
                </div>




                <div>
                    <ul class="grid gap-sm js-adv-filter__gallery" id="adv-filter-gallery">
                        <?php foreach ($data['products'] as $product) : ?>
                        <li class="col-6@xs flex flex-center padding-sm">
                            <div class="card" style="width: 400px;">
                                <!-- Set a fixed width for the card -->
                                <figure class="card__img-wrapper" style="height: 200px;  overflow: hidden;">
                                    <?php if ($product->imagePath) : ?>
                                    <img src="<?= $product->imagePath ?>" alt="<?= $product->productName ?>"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else : ?>
                                    <!-- Add a default image or placeholder if the imagePath is not available -->
                                    <img src="<?= URLROOT . '/path/to/default/image.jpg' ?>" alt="Default Image"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php endif; ?>
                                </figure>
                                <div class="padding-xs">
                                    <h3
                                        class="margin-top-xs margin-bottom-sm text-sm color-contrast-medium line-height-md">
                                        <?= $product->productName ?></h3>
                                    <div class="margin-top-xs">
                                        <span class="prod-card__price">€<?= $product->productPrice ?></span>
                                    </div>
                                    <button class="btn btn--primary text-sm width-100% addToCartBtn">Add To
                                        Cart</button>
                                    <input type="hidden" class="productId" value="<?= $product->productId ?>">
                                    <input type="hidden" class="productName" value="<?= $product->productName ?>">
                                    <input type="hidden" class="productPrice" value="<?= $product->productPrice ?>">
                                    <input type="hidden" class="imagePath" value="<?= $product->imagePath ?>">
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>


                    <nav class="pagination" aria-label="Pagination">
                        <ol class="pagination__list flex flex-wrap gap-xxxs justify-center">
                            <li>
                                <!-- Previous Page Link -->
                                <a href="<?= $data['urlQuery']['prevPage'] ?>"
                                    class="pagination__item <?= $data['currentPage'] == 1 ? 'pagination__item--disabled' : ''; ?>"
                                    aria-label="Go to previous page">
                                    <svg class="icon icon--xs margin-right-xxxs flip-x" viewBox="0 0 16 16">
                                        <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                    <span>Prev</span>
                                </a>
                            </li>

                            <!-- Loop through pages and generate pagination links -->
                            <?php
                            $numberButtons = $data['urlQuery']['numberButtons'];
                            $currentPage = $data['currentPage'];
                            $totalPages = $data['totalPages'];

                            for ($i = 1; $i <= $totalPages; $i++) :
                                if ($i <= 3 || $i >= $currentPage - 1 && $i <= $currentPage + 1 || $i > $totalPages - 3) : ?>
                            <!-- Page Link -->
                            <li class="display@sm">
                                <a href="<?= $numberButtons[$i] ?>"
                                    class="pagination__item <?= $currentPage == $i ? 'pagination__item--selected' : ''; ?>"
                                    aria-label="Go to page <?= $i; ?>"><?= $i; ?></a>
                            </li>
                            <?php elseif ($i == 4 && $currentPage > 4) : ?>
                            <!-- Dots (...) after the third page if currentPage is greater than 4 -->
                            <li class="display@sm">
                                <span class="pagination__item pagination__item--disabled">...</span>
                            </li>
                            <?php elseif ($i == $totalPages - 3 && $currentPage < $totalPages - 3) : ?>
                            <!-- Dots (...) before the last three pages if currentPage is less than totalPages - 3 -->
                            <li class="display@sm">
                                <span class="pagination__item pagination__item--disabled">...</span>
                            </li>
                            <?php endif;
                            endfor; ?>

                            <li>
                                <!-- Next Page Link -->
                                <a href="<?= $data['urlQuery']['nextPage'] ?>"
                                    class="pagination__item <?= $currentPage == $totalPages ? 'pagination__item--disabled' : ''; ?>"
                                    aria-label="Go to next page">
                                    <span>Next</span>
                                    <svg class="icon icon--xs margin-left-xxxs" viewBox="0 0 16 16">
                                        <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </a>
                            </li>
                        </ol>
                    </nav>



                </div>
            </main>
        </div>
    </div>

</section>
<?php require APPROOT . '/views/includes/foot.php'; ?>