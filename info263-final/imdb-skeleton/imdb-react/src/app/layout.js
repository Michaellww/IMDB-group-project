"use client";

import 'bootstrap/dist/css/bootstrap.css';
import './css/style.css';
import { Inter } from 'next/font/google';
import { useEffect } from "react";

const inter = Inter({ subsets: ['latin'] });

export default function RootLayout({ children }) {
  useEffect(() => {
    require("bootstrap/dist/js/bootstrap.bundle.min.js");
  }, []);

  const isLoggedIn = false; // Replace with real login state
  const username = "Guest"; // Replace with actual session data

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
                <a className="nav-link p-2" href="#titles">Shorts</a>
                <a className="nav-link p-2" href="#titles">Series</a>
                <a className="nav-link p-2" href="#people">People</a>
                <a className="nav-link p-2" href="#genres">Genres</a>
                <a className="nav-link p-2" href="#rankings">Rankings</a>
              </div>

              <div className="navbar-nav ms-auto">
                {isLoggedIn ? (
                    <>
                      <span className="nav-link disabled">👤 Logged in as: <strong>{username}</strong></span>
                      <a className="nav-link p-2" href="#logout">Logout</a>
                    </>
                ) : (
                    <>
                      <span className="nav-link disabled">👤 Not logged in</span>
                      <a className="nav-link p-2" href="#login">Log In</a>
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
