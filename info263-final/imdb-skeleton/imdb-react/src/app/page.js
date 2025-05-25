// src/app/page.js
"use client";

import React, { useEffect, useState } from "react";

export default function Page() {
    const [results, setResults] = useState([]);
    const [titles, setTitles] = useState([]);
    const [people, setPeople] = useState([]);

    useEffect(() => {
        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/search.php?search=avatar")
            .then((res) => res.json())
            .then((data) => {
                console.log("Fetched data:", data);
                setResults(data);
            })
            .catch((err) => console.error("Fetch error:", err));

        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_titles.php")
            .then((res) => res.json())
            .then((data) => {
                setTitles(data);
            })
            .catch((err) => console.error("Title fetch error:", err));

        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_people.php")
            .then((res) => res.json())
            .then((data) => {
                setPeople(data);
            })
            .catch((err) => console.error("People fetch error:", err));
    }, []);

    return (
        <>
            <section id="home" className="row justify-content-center my-4">
                <img
                    className="img-thumbnail img-banner"
                    src="/images/rick.jpg"
                    alt="Got you beach ahhaa"
                />
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
                            autoComplete="off"
                        />
                        <div id="autocomplete-list" className="d-none"></div>
                    </div>
                </div>
                <div className="col-2 d-grid col-2">
                    <button id="search-button" type="submit" className="btn btn-warning">
                        Search
                    </button>
                </div>
            </section>

            <section id="titles" className="container my-5">
                <h5>Movie Titles</h5>
                {titles.length === 0 ? (
                    <div className="alert alert-warning">No titles found!</div>
                ) : (
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
                                            <button
                                                className="btn btn-outline-success btn-sm"
                                                disabled
                                            >
                                                ➕ Add to Wishlist
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </section>

            <section id="people" className="container my-5">
                <h5>People</h5>
                {people.length === 0 ? (
                    <div className="alert alert-warning">No people found!</div>
                ) : (
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
                )}
            </section>

            <section className="container my-5">
                <h5>Search Results:</h5>
                <ul className="list-group">
                    {results.map((item, idx) => (
                        <li key={idx} className="list-group-item d-flex align-items-center">
                            {item.image && (
                                <img src={item.image} alt={item.primaryName || item.primaryTitle} className="me-3" />
                            )}
                            <div>
                                <strong>{item.primaryName || item.primaryTitle}</strong>
                                <br />
                                <small>{item.primaryProfession || item.genres}</small>
                            </div>
                        </li>
                    ))}
                </ul>
            </section>

            <footer className="text-center py-4">
                <p>&copy; {new Date().getFullYear()} IMDB 2 Project</p>
            </footer>
        </>
    );
}
