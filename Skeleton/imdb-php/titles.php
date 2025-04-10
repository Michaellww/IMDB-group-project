<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/fontawesome.min.css" integrity="sha256-TBe0l9PhFaVR3DwHmA2jQbUf1y6yQ22RBgJKKkNkC50=" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<main role="main" class="container bg-light">
    <?php
    include_once 'navigation.php';
    include_once 'database.php';

    // Create API link
    $path_parts = explode("/", $_SERVER['REQUEST_URI']);
    array_pop($path_parts);
    $path = implode("/", $path_parts);
    $base_url = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $path;
    $api_link = $base_url . "/api.php";

    // Single or multiple vehicles
    if (isset($_GET["id"]) and !empty($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        if (isset($_GET['offset']) and !empty($_GET['offset'])) {
            $offset = $_GET["offset"];
        } else {
            $offset = 0;
        }

        if (isset($_GET['limit']) and !empty($_GET['limit'])) {
            $limit = $_GET["limit"];
        } else {
            $limit = 8;
        }

        // Filtering
        if (isset($_GET["title"]) and !empty($_GET["title"])) {
            $title = $_GET["title"];
        }

        // Titles
        $count = getTitleCount($title);
        $titles = getTitles($offset, $limit, $title);
    }
    ?>

    <? if (!isset($_GET["id"])): ?>
        <h1 id="title_count" class="text-center mt-2"><?= $count ?> Titles</h1>

        <div class="container p-5">
            <div class="row">
                <div class="col-3">
                    <label for="title-input">Title:</label>
                    <input id="title-input" type="text" class="form-control" value="<?= $title ?>">
                </div>
            </div>
        </div>

        <!-- HIDDEN API link. This can be capture by JavaScript to manipulate the HTML. -->
        <a id="api-link" href="<?= $api_link ?>" hidden>API link</a>
        <div id="title-data" class="row row-cols-1 row-cols-md-4">
            <? foreach ($titles as $title): ?>
                <a class="col-4 p-2" href="titles.php?id=<?= $title->getId() ?>">
                    <?= $title->toHtml(); ?>
                </a>
            <? endforeach; ?>
        </div>
    <? else: ?>
        <?
        $title = getTitle($id);
        ?>
        <div class="container m-2">
            <div class="row">
                <h2><?= $title->getOriginalTitle() ?></h2>
                <?= $title->toHtml() ?>
            </div>
    <? endif; ?>

</main>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/js/all.min.js" integrity="sha256-BAR0H3Qu2PCfoVr6CtZrcnbK3VKenmUF9C6IqgsNsNU=" crossorigin="anonymous"></script>
<script src="js/titles.js"></script>
</body>
</html>
