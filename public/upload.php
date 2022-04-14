<?php

$GLOBALS['message'] = '';
$color = 'red';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $length = count($_FILES['upload']['name']);
    for ($i = 0; $i < $length; $i++) {
        $tempfile = $_FILES['upload']['tmp_name'][$i];
        $filename = $_FILES['upload']['name'][$i];
        $path =  __DIR__ . "/images/" . $filename; //imagesディレクトリに入れる
        if (is_uploaded_file($tempfile)) {
            if (file_exists($path)) { //同じファイルは別名にする
                $info = pathinfo($path);
                $md5_file = md5_file($tempfile);
                $md5 = md5($md5_file . microtime());
                $path = $info['dirname'] . "/" . $info['filename'] . $md5 . '.' . $info['extension'];
            }
            if (move_uploaded_file($tempfile, $path)) {
                $GLOBALS['message'] = $filename . "をアップロードしました。";
                $color = 'green';

                insert($filename, $path);
            } else {
                $GLOBALS['message'] = "ファイルをアップロードできません。";
            }
        } else {
            $GLOBALS['message'] = "ファイルが選択されていません。";
        }
    }
}


function insert($name, $filename)
{
    $dsn = 'mysql:dbname=uploaded_images;host=localhost';
    $user = 'root';
    $password = '0315';
    try {
        $dbh = new PDO($dsn, $user, $password);

        $sql = 'insert images(name,path)value(?,?)';
        $stmt = $dbh->prepare($sql);

        $flag = $stmt->execute([$name, $filename]);
    } catch (PDOException $e) {
        print('Connection failed:' . $e->getMessage());
        die();
    }



    if ($flag) {
        $GLOBALS['message'] .= 'データの追加に成功しました<br>';
    } else {
        $GLOBALS['message'] .= 'データの追加に失敗しました<br>';
    }
}


?>


<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>画像のアップロード</title>
</head>

<body>
    <main>
        <div class="container">


            <div class="app-service">
                <div class="app-name">
                    <h1>Image Uploader</h1>
                </div>
                <p class="app-gaiyou">画像のアップロードが行えます。</p>
            </div>



            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">ホーム</a></li>
                    <li class="breadcrumb-item active" aria-current="page">アップロード</li>
                </ol>
            </nav>
            <?php
            if ($color === 'green') {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $GLOBALS['message'];
                    ?>
                </div>
            <?php
            }
            ?>
            <?php
            if ($color === 'red' && $GLOBALS['message'] !== '') {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $GLOBALS['message'];
                    ?>
                </div>
            <?php
            }
            ?>
            <form action="./upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">画像ファイルを選択</label>
                    <input type="file" class="form-control" id="formFileMultiple" name="upload[]" multiple>
                </div>
                <button id="send_button" class="btn btn-primary" type="submit">アップロード</button>
            </form>

        </div>
    </main>
</body>

<script src="./js/jquery-3.6.0.js"></script>
<script>
    $(function() {
        let sendflag = false;
        $("#send_button").on('click', function() {
            let isError = false;

            if (isError === true) {
                return false;
            }

            if (false === sendflag) {
                sendflag = true; //送信済み
                let spinner = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>';
                $(this).html(spinner);
                $(this).submit();
                $("#postcode_error").hide();
                $("#address_error").hide();
                return true; //送信OK
            }
            alert("二重送信禁止");
            return false;
        });


    });
</script>

</html>