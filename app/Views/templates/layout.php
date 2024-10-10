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
    <!-- <div class="container-fluid p-0">
        <div class="row p-0">
            <div class="col-2 p-0"> -->
                <?php
                $router = service('router'); // Router service
                $controller = $router->controllerName();
                $method = $router->methodName();

                // if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
                //     echo $this->include('templates/sidebar');
                // }
                ?>
            <!-- </div> -->
            <!-- <div class="col-10 p-0"> -->
                <?php
                if ($controller !== '\App\Controllers\AccountController' || ($method !== 'index' && $method !== 'registration')) {
                    echo $this->include('templates/header');
                }
                ?>


                <!-- <main class="col p-0"> -->
                    <?= $this->renderSection('content') ?>
                <!-- </main> -->
            <!-- </div>
        </div> -->



        <!-- <div class="row p-0"> -->



        <!-- </div> -->
    <!-- </div> -->

    <!-- <em>$copy; 2022</em> -->

    <?= load_bundle_js() ?>
    <?= $this->renderSection('js') ?>
</body>

</html>