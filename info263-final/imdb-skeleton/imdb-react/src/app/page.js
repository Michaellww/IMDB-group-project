// src/app/page.js
"use client";

import React, { useEffect, useState } from "react";

function debounce(func, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}

export default function Page() {
    const [results, setResults] = useState([]);
    const [titles, setTitles] = useState([]);
    const [people, setPeople] = useState([]);
    const [genres, setGenres] = useState([]);
    const [rankings, setRankings] = useState([]);
    const [searchTerm, setSearchTerm] = useState("");
    const [showSuggestions, setShowSuggestions] = useState(false);

    useEffect(() => {
        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_titles.php")
            .then((res) => res.json())
            .then((data) => setTitles(data))
            .catch((err) => console.error("Title fetch error:", err));

        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_people.php")
            .then((res) => res.json())
            .then((data) => setPeople(data))
            .catch((err) => console.error("People fetch error:", err));

        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_genres.php")
            .then((res) => res.json())
            .then((data) => setGenres(data))
            .catch((err) => console.error("Genres fetch error:", err));

        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_rankings.php")
            .then((res) => res.json())
            .then((data) => setRankings(data))
            .catch((err) => console.error("Rankings fetch error:", err));

        const backToTopBtn = document.getElementById("backToTopBtn");

        const handleScroll = () => {
            if (window.scrollY > 55) {
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }
        };

        const handleClick = () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };

        window.addEventListener("scroll", handleScroll);
        backToTopBtn.addEventListener("click", handleClick);

        // Cleanup on unmount
        return () => {
            window.removeEventListener("scroll", handleScroll);
            backToTopBtn.removeEventListener("click", handleClick);
        };
    }, []);

    const fetchSearchResults = debounce((value) => {
        fetch(`http://localhost:8000/imdb-clean/info263-final/imdb-php/search.php?search=${encodeURIComponent(value)}`)
            .then((res) => res.json())
            .then((data) => {
                setResults(data);
                setShowSuggestions(true);
            })
            .catch((err) => console.error("Search fetch error:", err));
    }, 300); // You can tweak this delay (ms)


    const handleSearchInput = (e) => {
        const value = e.target.value;
        setSearchTerm(value);

        if (value.trim() === "") {
            setResults([]);
            setShowSuggestions(false);
            return;
        }

        fetchSearchResults(value); // Debounced call
    };


    const handleSuggestionClick = () => {
        setShowSuggestions(false);
    };

    return (
        <>
            <section id="home" className="row justify-content-center my-4">
                <img className="img-thumbnail img-banner" src="/images/rick.jpg" alt="Got you beach ahhaa" />
                <h4 className="text-center">Never gonna tell a lie and hurt you. saranghaeyo!</h4>
            </section>

            <section id="search" className="row align-middle align-items-center py-2">
                <div className="offset-2 col-7 align-middle position-relative">
                    <div className="search-wrapper">
                        <label htmlFor="searchInput" className="visually-hidden">
                            Search for movie or person
                        </label>
                        <input
                            type="text"
                            id="searchInput"
                            className="form-control"
                            placeholder="Search for movie or person..."
                            value={searchTerm}
                            onChange={handleSearchInput}
                            autoComplete="off"
                        />
                        {showSuggestions && results.length > 0 && (
                            <div className="list-group position-absolute w-100 zindex-dropdown bg-white border rounded mt-1" style={{ maxHeight: 'none', overflowY: 'visible' }}
                            >
                                {results.map((item, idx) => (
                                    <div
                                        key={idx}
                                        className="list-group-item list-group-item-action d-flex align-items-center"
                                        onClick={handleSuggestionClick}
                                    >
                                        {item.image && (
                                            <img
                                                src={item.image}
                                                alt={item.primaryName || item.primaryTitle}
                                                className="me-2"
                                                style={{ width: '40px', height: 'auto' }}
                                            />
                                        )}
                                        <div>
                                            <strong>{item.primaryName || item.primaryTitle}</strong>
                                            <br />
                                            <small>{item.primaryProfession || item.genres}</small>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
                <div className="col-2 d-grid col-2">
                    <button id="search-button" type="submit" className="btn btn-warning">
                        Search
                    </button>
                </div>
            </section>

            <section id="titles" className="container my-5">
                <h5>Titles</h5>
                <div className="row row-cols-1 row-cols-md-3 g-4">
                    {titles.map((title, idx) => (
                        <div className="col" key={idx}>
                            <div className="card h-100">
                                <div className="card-body">
                                    <h5 className="card-title">{title.primaryTitle}</h5>
                                    <p className="card-text">
                                        {title.startYear} | {title.runtimeMinutes} mins<br />
                                        Rating: {title.rating ?? "N/A"}
                                    </p>
                                    <div className="d-grid gap-2 mt-2">
                                        <button className="btn btn-outline-success btn-sm" disabled>
                                            ➕ Add to Wishlist
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            <section id="people" className="container my-5">
                <h5>People</h5>
                <div className="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4">
                    {people.map((person, idx) => (
                        <div className="col" key={idx}>
                            <div className="card h-100">
                                <div className="card-body">
                                    <h5 className="card-title">{person.primaryName}</h5>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            <section id="genres" className="container my-5">
                <h5>🎭 Movie Genres</h5>
                <div className="row">
                    {genres.map((genre, idx) => (
                        <div className="col-md-4 mb-3" key={idx}>
                            <a href={`genre.php?name=${encodeURIComponent(genre)}`} className="btn btn-warning w-100 text-start">
                                {genre}
                            </a>
                        </div>
                    ))}
                </div>
            </section>

            <section id="rankings" className="container my-5">
                <h5>🏆 Top Rated Movies</h5>
                <div className="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                    {rankings.map((movie, idx) => (
                        <div className="col" key={idx}>
                            <div className="card h-100 shadow-sm">
                                <div className="card-body">
                                    <div className="d-flex justify-content-between align-items-center mb-3">
                                        <div className="ranking-badge bg-warning text-dark fw-bold rounded-circle d-flex justify-content-center align-items-center" style={{ width: "40px", height: "40px" }}>
                                            {idx + 1}
                                        </div>
                                        <div className="text-warning">
                                            ★ {Number(movie.averageRating).toFixed(1)}
                                            <small className="text-muted"> ({Number(movie.numVotes).toLocaleString()} votes)</small>
                                        </div>
                                    </div>
                                    <h5 className="card-title">{movie.primaryTitle}</h5>
                                    <p className="card-text">
                                        {movie.startYear} • {movie.runtimeMinutes ?? "N/A"} mins
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            <footer className="text-center py-4">
                <p>&copy; {new Date().getFullYear()} IMDB 2 Project</p>
            </footer>

            <button
                id="backToTopBtn"
                className="btn btn-primary position-fixed"
                style={{
                    top: '50px',
                    left: '50%',
                    transform: 'translateX(-50%)',
                    display: 'none',
                    zIndex: 1050,
                }}
            >
                ↑ Back to Top
            </button>
        </>
    );
}
