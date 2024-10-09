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
    
    <?= $this->renderSection('content') ?>


<!-- <em>$copy; 2022</em> -->

    <?= load_bundle_js() ?>
    <?= $this->renderSection('js') ?>
</body>

</html>