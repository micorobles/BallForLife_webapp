<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- Additional CSS -->
    <?= $this->renderSection('css') ?>
</head>
<body>
    <?= $this->renderSection('content') ?>

<em>$copy; 2022</em>
</body>

</html>