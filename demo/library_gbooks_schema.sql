CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE books (
    id TEXT PRIMARY KEY,
    url TEXT,
    title TEXT NOT NULL,
    contributor TEXT,
    library_id INTEGER,
    FOREIGN KEY (library_id) REFERENCES library(id)
);
CREATE TABLE labels (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id TEXT NOT NULL,
    label TEXT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);
CREATE INDEX idx_books_library_id ON books(library_id);
CREATE INDEX idx_labels_book_id ON labels(book_id);
CREATE TABLE IF NOT EXISTS "library" (
	"id"	INTEGER,
	"list_title"	TEXT NOT NULL,
	"blurb"	TEXT,
	"url"	TEXT UNIQUE,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "identifiers" (
	"id"	INTEGER,
	"book_id"	TEXT NOT NULL UNIQUE,
	"type"	TEXT NOT NULL,
	"value"	TEXT NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("book_id") REFERENCES "books"("id")
);
CREATE INDEX idx_identifiers_book_id ON identifiers(book_id);
CREATE INDEX idx_identifiers_type ON identifiers(type);
CREATE VIEW ISBN_duplicate AS
SELECT book_id
FROM identifiers AS T1
INNER JOIN (
    SELECT T2.value
    FROM identifiers AS T2
    GROUP BY T2.value
    HAVING COUNT(*) > 1
) AS T3 ON T1.value = T3.value
/* ISBN_duplicate(book_id) */;
