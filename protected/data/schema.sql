CREATE TABLE books (author varchar(240), created varchar(20), id INTEGER PRIMARY KEY, isbn varchar(10), isbn13 varchar(13), notes TEXT, publisher varchar(240), summary TEXT, title varchar(100));

CREATE TABLE movies (cast TEXT, genre varchar(100), runtime varchar(10), updated varchar(20), created varchar(20), id INTEGER PRIMARY KEY, imdbID varchar(25), summary TEXT, title varchar(100), year NUMERIC, director varchar(100));

CREATE UNIQUE INDEX imdbID ON movies(imdbID ASC);

CREATE TABLE comics (created integer, cvID VARCHAR(50), id INTEGER PRIMARY KEY, name varchar(100), url VARCHAR(250));
