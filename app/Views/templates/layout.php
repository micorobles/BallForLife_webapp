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


    <!-- Header start -->
    <?php
    $router = service('router'); // Router service
    $controller = $router->controllerName();
    $method = $router->methodName();

    if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
        ?>
        <header class="bg-accent text-white text-center m-0 p-0">
            <?= $this->include('templates/header'); ?>
        </header>
        <?php
    }
    ?>
    <!-- Header end -->


    <!-- Sidebar start -->
    <?php
    if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
        ?>
        <div class="page-container">
            <nav id="sidebar" class="sidebar bg-secondary">
                <?= $this->include('templates/sidebar'); ?>
            </nav>
        </div>
        <!-- Sidebar end -->

        <!-- Content start -->
        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- Content end -->

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
    <?= load_bundle_js() ?>
    <?= $this->renderSection('js') ?>
</body>

</html>