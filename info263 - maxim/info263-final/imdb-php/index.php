<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>IMDB 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        /* Autocomplete dropdown style */
        #autocomplete-list {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: none;
        }
        .autocomplete-item {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .autocomplete-item:hover {
            background-color: #f8f9fa;
        }
        .autocomplete-item img {
            width: 40px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 3px;
        }
        .autocomplete-text {
            flex-grow: 1;
        }
        .suggestion-title {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
        }
        .suggestion-detail {
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>
<body>

<!-- Login status bubble (hidden by default) -->
<div id="login-bubble" class="bubble-text position-absolute top-0 end-0 mt-2 me-3" style="display: none;">
    🚫 Not Logged In
</div>

<main role="main" class="container bg-light py-4 position-relative" style="max-width: 720px;">
    <?php include_once 'navigation.php' ?>
    <?php if (isset($_SESSION['user_id'])): ?>
        <div id="wishlistSidebar" style="display:none;position:fixed;right:0;top:0;width:300px;height:100%;background:#f8f9fa;padding:10px;overflow-y:auto;z-index:1050;">
            <h5>Your Wishlist</h5>
            <div id="wishlistContent">Loading...</div>
            <button class="btn btn-danger btn-sm mt-2" id="clearWishlistBtn">Clear Wishlist</button>
            <button class="btn btn-warning btn-sm mt-2 d-none" id="undoBtn">Undo</button>
        </div>
    <?php endif; ?>

    <?php include_once 'database.php'; ?>

    <div class="row justify-content-center my-4">
        <img class="img-thumbnail img-banner" src="images/yoda.jpeg" alt="Yoda" />
        <h4 class="text-center mt-3">Yoda: “Looking? Found someone you have, eh?”</h4>
    </div>

    <div class="row align-middle align-items-center py-2 position-relative">
        <div class="offset-2 col-7 align-middle position-relative">
            <input id="searchInput" class="form-control" type="text" name="search" placeholder="Search for a Film, Series, or Person..." autocomplete="off" />
            <div id="autocomplete-list"></div> <!-- Autocomplete list -->
        </div>

        <div class="col-2 d-grid">
            <button id="search-button" type="button" class="btn btn-warning">Search</button>
        </div>
    </div>

    <div class="row mt-4">
        <div id="search-results" class="col-12"></div>
    </div>

    <?php include_once 'cookiepopup.php'; ?>
    <?php include_once 'footer.php'; ?>
</main>

<!-- JS scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="search.js"></script>
<script src="wishlist.js"></script>
</body>
</html>
