<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <?= load_bundle_css() ?>
    <!-- Additional CSS -->
    <?= $this->renderSection('css') ?>
</head>

<body>

<div class="spinner-overlay" id="loader">
    <div class="spinner">
        <div class="ball"></div>
    </div>
</div>

    <!-- Header start -->
    <?php
    $router = service('router'); // Router service
    $controller = $router->controllerName();
    $method = $router->methodName();

    if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
    ?>
        <!-- <header class="bg-accent text-white text-center m-0 p-0"> -->
        <?= $this->include('templates/header'); ?>
        <!-- </header> -->
    <?php
    }
    ?>
    <!-- Header end -->


    <!-- Sidebar start -->
    <?php
    if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
    ?>
        <div class="page-container">
            <!-- <nav id="sidebar" class="sidebar bg-secondary"> -->
            <?= $this->include('templates/sidebar'); ?>
            <!-- </nav> -->
        </div>
        <!-- Sidebar end -->

        <!-- Content start -->
        <div class="content">
            <div class="header-container d-flex justify-content-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('homepage'); ?>">Home</a>
                    </li>
                    <?php
                    $breadcrumbs = generate_breadcrumbs(); // Get the breadcrumbs
                    $last_index = count($breadcrumbs) - 1; // Get the index of the last breadcrumb

                    foreach ($breadcrumbs as $index => $breadcrumb) {
                        if ($index === $last_index) {
                            // If it's the last breadcrumb, display it as plain text
                            echo '<li class="breadcrumb-item active" aria-current="page"><a href="javascript:;"> ' . esc($breadcrumb['title']) . '</a></li>';
                        } else {
                            echo '<li class="breadcrumb-item"><a href="' . esc($breadcrumb['url']) . '">' . esc($breadcrumb['title']) . '</a></li>';
                        }
                    }
                    ?>
                </ol>
            </div>
            <div class="panel border">
                <div class="panel-header">
                    <span class="page-header regular-text"><?= $title ?></span>
                </div>
                <div class="panel-body">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
        </div>
        <!-- Content end -->

        <div class="overlay"></div>
        <!-- Footer start -->
        <footer class="bg-light text-center text-muted p-2">
            <span>&copy; 2024 Your Company</span>
        </footer>
        <!-- Footer end -->

    <?php
    } else {
    ?>

        <?= $this->renderSection('content') ?>

    <?php
    }
    ?>

    </div>
    <script>
        const getUserURL = '<?= base_url('getUser') ?>'
        const baseURL = '<?= base_url(); ?>';
    </script>
    <?= load_bundle_js() ?>
    <?= $this->renderSection('js') ?>
</body>

</html>