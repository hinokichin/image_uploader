<?php

$dsn = 'mysql:dbname=uploaded_images;host=localhost';
$user = 'root';
$password = '0315';


$page = isset($_GET['page']) ? $_GET['page'] : null;


try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (empty($page)) {
        $offset = 0;
    } else {
        $offset = ($page - 1) * 16;
    }
    $sql = "SELECT * FROM images LIMIT 16 OFFSET $offset";
    $count_sql = "SELECT count(*) as count FROM images";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $dbh->query($count_sql);
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];

    if ($page == 1) {
        $prev = '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
    } else {
        $prevpage = $page - 1;
        $prev = <<<HTML
        <li class="page-item"><a class="page-link" href="list.php?page={$prevpage}" tabindex="-1">Previous</a></li>
HTML;
    }

    $list = "";
    $pageNo = 1;
    for ($i = 0; $i < $count; $i++) {
        if ($i == 0 || $i % 16 == 0) {
            $list .= <<<HTML
                <li class="page-item"><a class="page-link" href="list.php?page={$pageNo}">$pageNo</a></li>
HTML;
            $pageNo++;
        }
    }


    if (($page + 1) == $pageNo) {
        $next = '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a></li>';
    } else {
        $nextpage = $page + 1;
        $next = <<<HTML
        <li class="page-item"><a class="page-link" href="list.php?page={$nextpage}" tabindex="-1">Next</a></li>
HTML;
    }

    $paginator_tags = $prev . $list . $next;
} catch (Exception $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
}

?>


<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>写真のアップロード・閲覧</title>

    <style>
        .image_w100 {
            width: 100%;
        }

        .modal-content {
            background-color: unset;
        }

        #LightboxCanvas {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">


            <div class="app-service">
                <div class="app-name">
                    <h1>Image Uploader</h1>
                </div>
                <p class="app-gaiyou">画像の閲覧ができます。</p>
            </div>



            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">ホーム</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ギャラリー</li>
                </ol>
            </nav>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php echo $paginator_tags; ?>
                </ul>
            </nav>

            <div class="container">
                <div class="row row-cols-4">
                    <?php foreach ($result as $row) {
                        $info = pathinfo($row['path']);
                        $path = "./images/" . $info['filename']  . '.' . $info['extension'];
                        echo "<div class='col'><a data-modal='bs-lightbox' class='image_w100' href=\"" . $path . "\" target=\"_blank\"><img class='image_w100' src=\"" . $path . "\"></a></div>\n";
                    }
                    ?>
                </div>
            </div>


            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php echo $paginator_tags; ?>
                </ul>
            </nav>
        </div>
    </main>
    <script async type="text/javascript" src="https://cdn.jsdelivr.net/gh/avalon-studio/Bootstrap-Lightbox/bs5lightbox.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</body>

</html>