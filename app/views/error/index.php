<!DOCTYPE html>
<html data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="<?= JS; ?>jquery-3.7.1.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        media="screen"
        href="<?= CSS; ?>bootstrap-5.3.3.css" />
    <script src="<?= JS; ?>bootstrap.bundle.min-5.3.3.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        media="screen"
        href="<?= CSS; ?>error.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Aaaaaaaaa Error</title>
</head>

<body>
    <div id="wrapper">
        <div id="error-banner">
            <h1>[<?= isset($data['code']) ? $data['code'] : 'Aaaaaaa' ?>] Error</h1>
            <div id="error-picture-wrapper">
                <div id="error-picture">
                    <img src="<?= IMGS; ?>miyu_sad.jpg" />
                </div>
                <p>sad Miyu:(</p>
            </div>
            <form action="logout">
                <button class="btn btn-primary" type="submit" id="btn-back">GO BACK AT START POINT</button>
            </form>
        </div>
        <div id="error-message">
            <p><?= isset($data['message']) ? $data['message'] : 'Something went wrong' ?></p>
        </div>
    </div>

</body>

</html>