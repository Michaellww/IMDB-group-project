"use client";

import 'bootstrap/dist/css/bootstrap.css';
import './css/style.css';
import { Inter } from 'next/font/google';
import React, { useEffect, useState } from "react";

const inter = Inter({ subsets: ['latin'] });

export default function RootLayout({ children }) {
    const [session, setSession] = useState({ loggedIn: false, userName: "Guest" });

    useEffect(() => {
        require("bootstrap/dist/js/bootstrap.bundle.min.js");

        // Check login session from PHP
        fetch("http://localhost:8000/imdb-clean/info263-final/imdb-php/api_session_status.php", {
            credentials: "include",
        })
            .then(res => res.json())
            .then(data => setSession(data))
            .catch(err => console.error("Session check failed:", err));
    }, []);

    return (
        <html lang="en">
        <head>
            <title>IMDB 2</title>
        </head>
        <body>
        <main role="main" className="container bg-light">
            <nav className="navbar navbar-expand-lg navbar-light" style={{ backgroundColor: "#FFD700" }}>
                <div className="container-fluid">
                    <a className="navbar-brand p-2 fw-bold" href="#home">IMDB 2</a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse justify-content-between" id="mainNav">
                        <div className="navbar-nav">
                            <a className="nav-link p-2" href="#titles">Movies</a>
                            <a className="nav-link p-2" href="#shorts">Shorts</a>
                            <a className="nav-link p-2" href="#series">Series</a>
                            <a className="nav-link p-2" href="#people">People</a>
                            <a className="nav-link p-2" href="#genres">Genres</a>
                            <a className="nav-link p-2" href="#rankings">Rankings</a>
                        </div>

                        <div className="navbar-nav ms-auto">
                            {session.loggedIn ? (
                                <>
                                    <span className="nav-link disabled">👤 Logged in as: <strong>{session.userName}</strong></span>
                                    <a className="nav-link p-2" href="http://localhost:8000/imdb-clean/info263-final/imdb-php/logout.php?redirect=http://localhost:3000">
                                        Logout
                                    </a>
                                </>
                            ) : (
                                <>
                                    <span className="nav-link disabled">👤 Not logged in</span>
                                    <a className="nav-link p-2" href="http://localhost:8000/imdb-clean/info263-final/imdb-php/login.php?redirect=http://localhost:3000">Log In</a>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </nav>

            {children}
        </main>
        </body>
        </html>
    );
}
