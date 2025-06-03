CREATE TABLE library (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_title TEXT NOT NULL,
    blurb TEXT,
    url TEXT
);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE books (
    id TEXT PRIMARY KEY,
    url TEXT,
    title TEXT NOT NULL,
    contributor TEXT,
    library_id INTEGER,
    FOREIGN KEY (library_id) REFERENCES library(id)
);
CREATE TABLE identifiers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id TEXT NOT NULL,
    type TEXT NOT NULL,
    value TEXT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);
CREATE TABLE labels (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id TEXT NOT NULL,
    label TEXT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);
CREATE INDEX idx_books_library_id ON books(library_id);
CREATE INDEX idx_identifiers_book_id ON identifiers(book_id);
CREATE INDEX idx_identifiers_type ON identifiers(type);
CREATE INDEX idx_labels_book_id ON labels(book_id);
