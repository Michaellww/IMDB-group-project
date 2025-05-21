/*import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "leaflet/dist/leaflet.css";
import "../css/style.css";

const Navigation = ({ username }) => (
    <nav className="navbar navbar-expand-lg navbar-light" style={{ backgroundColor: "#FFD700" }}>
        <div className="container-fluid">
            <a className="navbar-brand p-2 fw-bold" href="#">IMDB 2</a>
            <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span className="navbar-toggler-icon"></span>
            </button>
            <div className="collapse navbar-collapse" id="mainNav">
                <div className="navbar-nav">
                    <a className="nav-link p-2" href="#movies">Movies</a>
                    <a className="nav-link p-2" href="#shorts">Shorts</a>
                    <a className="nav-link p-2" href="#series">Series</a>
                    <a className="nav-link p-2" href="#people">People</a>
                    <a className="nav-link p-2" href="#genres">Genres</a>
                    <a className="nav-link p-2" href="#rankings">Rankings</a>
                    {username ? (
                        <>
                            <span className="nav-link p-2 disabled">Welcome, {username}</span>
                            <a className="nav-link p-2" href="#logout">Logout</a>
                        </>
                    ) : (
                        <a className="nav-link p-2" href="#login">Log In</a>
                    )}
                </div>
            </div>
        </div>
    </nav>
);

const BackToTopButton = () => (
    <button className="btn btn-secondary position-fixed bottom-0 end-0 m-4">Top</button>
);

const CookiePopup = () => (
    <div className="alert alert-warning text-center mt-4" role="alert">
        This site uses cookies to enhance user experience.
    </div>
);

const Footer = () => (
    <footer className="bg-dark text-white text-center py-3 mt-4">
        <small>&copy; 2025 IMDB 2 Project</small>
    </footer>
);

const HomePage = () => {
    const [username, setUsername] = useState(null);

    useEffect(() => {
        // TODO: Replace this with real session/user check
        setUsername("Guest");
    }, []);

    return (
        <main role="main">
            <Navigation username={username} />
            <BackToTopButton />

            <div className="row justify-content-center my-4">
                <img className="img-thumbnail img-banner" src="../imdb-php/images/rick.jpg" alt="Rick Astley" />
                <h4 className="text-center">Never gonna tell a lie and hurt you. saranghaeyo!</h4>
            </div>

            <div className="row align-middle align-items-center py-2">
                <div className="offset-2 col-7 align-middle">
                    <input type="text" id="searchInput" className="form-control" placeholder="Search for movie or person..." autoComplete="off" />
                    <div id="autocomplete-list" className="d-none"></div>
                </div>
                <div className="col-2 d-grid col-2">
                    <button id="search-button" type="submit" className="btn btn-warning">Search</button>
                </div>
            </div>

            <CookiePopup />
            <Footer />
        </main>
    );
};

export default HomePage;
