<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $blogTitle ?></title>
        <link rel="stylesheet" media="screen" href=<?= $cssFile1 ?> />
        <link rel="stylesheet" media="screen" href=<?= $cssFile2 ?> />
        <link rel="stylesheet" media="screen" href=<?= $cssFile3 ?> />
        <?= $headContent ?>
    </head>
        
    <body>
        <header>
            <?= $headerButtons ?>

            <a href=<?= $headLink ?> >
                <p>
                    <img id=<?= $imgId ?> src=<?= $scr ?> alt=<?= $alt ?> />
                </p>
            </a>
        </header>

        <?= $blogContent ?>
    </body>
</html>