-- Create Core Tables
CREATE TABLE title_basics_trim (
                                   tconst TEXT PRIMARY KEY,
                                   titleType TEXT,
                                   primaryTitle TEXT,
                                   originalTitle TEXT,
                                   isAdult INTEGER,
                                   startYear INTEGER,
                                   endYear INTEGER,
                                   runtimeMinutes INTEGER,
                                   genres TEXT
);

CREATE TABLE name_basics_trim (
                                  nconst TEXT PRIMARY KEY,
                                  primaryName TEXT,
                                  birthYear INTEGER,
                                  deathYear INTEGER,
                                  primaryProfession TEXT
);

-- Create Associative Tables
CREATE TABLE title_writer_trim (
                                   tconst TEXT,
                                   writer TEXT,
                                   FOREIGN KEY(tconst) REFERENCES title_basics_trim(tconst),
                                   PRIMARY KEY(tconst, writer)
);

CREATE TABLE title_director_trim (
                                     tconst TEXT,
                                     director TEXT,
                                     FOREIGN KEY(tconst) REFERENCES title_basics_trim(tconst),
                                     PRIMARY KEY(tconst, director)
);

CREATE TABLE title_principals_trim (
                                       tconst TEXT,
                                       ordering TEXT,
                                       nconst TEXT,
                                       category TEXT,
                                       job TEXT,
                                       characters TEXT,
                                       FOREIGN KEY(tconst) REFERENCES title_basics_trim(tconst),
                                       FOREIGN KEY(nconst) REFERENCES name_basics_trim(nconst)
);

CREATE TABLE known_for_titles_trim (
                                       nconst TEXT,
                                       tconst TEXT,
                                       FOREIGN KEY(nconst) REFERENCES name_basics_trim(nconst),
                                       FOREIGN KEY(tconst) REFERENCES title_basics_trim(tconst),
                                       PRIMARY KEY(nconst, tconst)
);