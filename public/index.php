<?php

?>


<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>画像のアップロード・閲覧</title>

    <style>
        .w95{
            width:95%;
        }
    </style>
</head>

<body>
    <main>  
        <div class="app-service">
            <div class="app-name">
                <h1>Image Uploader</h1>
            </div>
            <p class="app-gaiyou">画像のアップロードと閲覧が行えます。</p>
        </div>
    </main>

    <br>

    <div class="d-grid gap-2 text-center">
            <a href="upload.php"><button class="w95 btn btn-primary" type="button">画像のアップロード</button></a>
            <a href="list.php"><button class="w95 btn btn-primary" type="button">ギャラリーで閲覧</button></a>
    </div>
</body>

</html>