<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
-<main role="main" class="container bg-light">
    <? include_once 'navigation.php' ?>
    <? include_once 'database.php'; ?>

    <div class="row align-middle align-items-center py-2">
        <div class="offset-2 col-7 align-middle">
            <input id="search-input" class="form-control" type="text" name="search" placeholder="Search for a Film, Series, Person, ..." />
        </div>

        <div class="col-2 d-grid col-2">
            <button id="search-button" type="submit" class="btn btn-warning">Search</button>
        </div>
    </div>

    <? include_once 'footer.php' ?>
</main>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="js/home.js"></script>
</body>
</html>