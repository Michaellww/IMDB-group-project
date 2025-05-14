<div class="modal fade" id="allMoviesModal" tabindex="-1" aria-labelledby="allMoviesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allMoviesLabel">🎬 Full Movie List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Sort Dropdown -->
                    <div class="mb-3 text-end">
                        <label for="sortMovies" class="form-label me-2">Sort by:</label>
                        <select id="sortMovies" class="form-select d-inline-block w-auto">
                            <option value="asc">A → Z</option>
                            <option value="desc">Z → A</option>
                        </select>
                    </div>

                    <!-- Movie Titles Grid -->
                    <div id="movieListContainer" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                        <div class="col"><div class="p-2 border rounded text-center">Shiva und die Galgenblume</div></div>
                        <div class="col"><div class="p-2 border rounded text-center">Let There Be Light</div></div>
                        <div class="col"><div class="p-2 border rounded text-center">Nagarik</div></div>
                        <div class="col"><div class="p-2 border rounded text-center">Rosa blanca</div></div>
                        <div class="col"><div class="p-2 border rounded text-center">Gregorio and His Angel</div></div>
                        <!-- Add more movie titles here as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>