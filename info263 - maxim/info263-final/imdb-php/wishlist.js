document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('wishlistSidebar');
    const wishlistBtn = document.getElementById('toggleWishlist');
    const wishlistContent = document.getElementById('wishlistContent');

    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', () => {
            if (!IS_LOGGED_IN) {
                alert("Please log in to view your wishlist.");
                window.location.href = "login.php";
                return;
            }

            sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block';
            loadWishlist();
        });
    }

    // Load current wishlist into sidebar
    function loadWishlist() {
        fetch('wishlist_api.php')
            .then(res => res.json())
            .then(data => {
                wishlistContent.innerHTML = data.length
                    ? data.map(item => `
                        <div class="wishlist-item mb-2">
                            <strong>${item.primaryTitle}</strong><br>
                            ${item.startYear} | ${item.runtimeMinutes ?? 'N/A'} mins
                            <button class="btn btn-sm btn-outline-danger mt-1 remove-wishlist" data-tconst="${item.tconst}">Remove</button>
                            <hr>
                        </div>
                    `).join('')
                    : "<p>No items in wishlist.</p>";

                // Bind remove buttons
                document.querySelectorAll('.remove-wishlist').forEach(button => {
                    button.addEventListener('click', function () {
                        const tconst = this.dataset.tconst;

                        fetch(window.location.pathname, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ wishlist_toggle: tconst })
                        }).then(res => res.json()).then(data => {
                            if (data.status === 'removed') {
                                loadWishlist();

                                const pageBtn = document.querySelector(`.wishlist-button[data-tconst="${tconst}"]`);
                                if (pageBtn) {
                                    pageBtn.textContent = '➕ Add to Wishlist';
                                    pageBtn.classList.remove('btn-success');
                                    pageBtn.classList.add('btn-outline-success');
                                }
                            }
                        });
                    });
                });
            });
    }

    // Bind toggle buttons on page
    document.querySelectorAll('.wishlist-button').forEach(button => {
        button.addEventListener('click', function () {
            if (!IS_LOGGED_IN) {
                const loginModal = new bootstrap.Modal(document.getElementById('loginPromptModal'));
                loginModal.show();
                return;
            }


            const tconst = this.dataset.tconst;

            fetch(window.location.pathname, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ wishlist_toggle: tconst })
            }).then(res => res.json()).then(data => {
                if (data.status === 'added') {
                    this.textContent = '✅ Added';
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success');
                } else if (data.status === 'removed') {
                    this.textContent = '➕ Add to Wishlist';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-success');
                }

                if (sidebar && sidebar.style.display === 'block') {
                    loadWishlist();
                }
            });
        });
    });
});
