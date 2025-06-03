<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="text" encoding="UTF-8" indent="no"/>
    
    <!-- Main template -->
    <xsl:template match="/">
        <xsl:text>-- SQLite Database Schema and Data Import Script
-- Generated from XML library data using XSLT transformation

-- Create the library table
CREATE TABLE IF NOT EXISTS library (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_title TEXT NOT NULL,
    blurb TEXT,
    url TEXT
);

-- Create the books table
CREATE TABLE IF NOT EXISTS books (
    id TEXT PRIMARY KEY,
    url TEXT,
    title TEXT NOT NULL,
    contributor TEXT,
    library_id INTEGER,
    FOREIGN KEY (library_id) REFERENCES library(id)
);

-- Create the identifiers table (for ISBN and other identifiers)
CREATE TABLE IF NOT EXISTS identifiers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id TEXT NOT NULL,
    type TEXT NOT NULL,
    value TEXT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Create the labels table (for future use)
CREATE TABLE IF NOT EXISTS labels (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id TEXT NOT NULL,
    label TEXT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Insert library information
INSERT INTO library (list_title, blurb, url) VALUES 
('</xsl:text>
        <xsl:call-template name="escape-quotes">
            <xsl:with-param name="text" select="library/list_title"/>
        </xsl:call-template>
        <xsl:text>', '</xsl:text>
        <xsl:call-template name="escape-quotes">
            <xsl:with-param name="text" select="library/blurb"/>
        </xsl:call-template>
        <xsl:text>', '</xsl:text>
        <xsl:call-template name="escape-quotes">
            <xsl:with-param name="text" select="library/url"/>
        </xsl:call-template>
        <xsl:text>');

-- Insert books data
INSERT INTO books (id, url, title, contributor, library_id) VALUES </xsl:text>
        
        <!-- Process each book -->
        <xsl:for-each select="library/books/book">
            <xsl:text>
('</xsl:text>
            <xsl:call-template name="escape-quotes">
                <xsl:with-param name="text" select="id"/>
            </xsl:call-template>
            <xsl:text>', '</xsl:text>
            <xsl:call-template name="escape-quotes">
                <xsl:with-param name="text" select="url"/>
            </xsl:call-template>
            <xsl:text>', '</xsl:text>
            <xsl:call-template name="escape-quotes">
                <xsl:with-param name="text" select="title"/>
            </xsl:call-template>
            <xsl:text>', </xsl:text>
            <xsl:choose>
                <xsl:when test="contributor and contributor != ''">
                    <xsl:text>'</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="contributor"/>
                    </xsl:call-template>
                    <xsl:text>'</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>NULL</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:text>, 1)</xsl:text>
            <xsl:if test="position() != last()">
                <xsl:text>,</xsl:text>
            </xsl:if>
        </xsl:for-each>
        
        <xsl:text>;

-- Insert ISBN identifiers</xsl:text>
        
        <!-- Check if there are any identifiers -->
        <xsl:if test="library/books/book/identifier">
            <xsl:text>
INSERT INTO identifiers (book_id, type, value) VALUES </xsl:text>
            
            <!-- Process identifiers -->
            <xsl:for-each select="library/books/book[identifier]">
                <xsl:variable name="book-id" select="id"/>
                <xsl:for-each select="identifier">
                    <xsl:text>
('</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="$book-id"/>
                    </xsl:call-template>
                    <xsl:text>', '</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="type"/>
                    </xsl:call-template>
                    <xsl:text>', '</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="value"/>
                    </xsl:call-template>
                    <xsl:text>')</xsl:text>
                    <xsl:if test="position() != last() or ../following-sibling::book[identifier]">
                        <xsl:text>,</xsl:text>
                    </xsl:if>
                </xsl:for-each>
            </xsl:for-each>
            <xsl:text>;</xsl:text>
        </xsl:if>
        
        <!-- Process labels if they exist -->
        <xsl:if test="library/books/book/labels/label">
            <xsl:text>

-- Insert labels
INSERT INTO labels (book_id, label) VALUES </xsl:text>
            
            <xsl:for-each select="library/books/book[labels/label]">
                <xsl:variable name="book-id" select="id"/>
                <xsl:for-each select="labels/label">
                    <xsl:text>
('</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="$book-id"/>
                    </xsl:call-template>
                    <xsl:text>', '</xsl:text>
                    <xsl:call-template name="escape-quotes">
                        <xsl:with-param name="text" select="."/>
                    </xsl:call-template>
                    <xsl:text>')</xsl:text>
                    <xsl:if test="position() != last() or ../following-sibling::book[labels/label]">
                        <xsl:text>,</xsl:text>
                    </xsl:if>
                </xsl:for-each>
            </xsl:for-each>
            <xsl:text>;</xsl:text>
        </xsl:if>
        
        <xsl:text>

-- Create indexes for better query performance
CREATE INDEX IF NOT EXISTS idx_books_library_id ON books(library_id);
CREATE INDEX IF NOT EXISTS idx_identifiers_book_id ON identifiers(book_id);
CREATE INDEX IF NOT EXISTS idx_identifiers_type ON identifiers(type);
CREATE INDEX IF NOT EXISTS idx_labels_book_id ON labels(book_id);

-- Query examples to verify the data:
-- SELECT * FROM library;
-- SELECT * FROM books;
-- SELECT * FROM identifiers;
-- SELECT b.title, b.contributor, i.value as isbn 
--   FROM books b 
--   LEFT JOIN identifiers i ON b.id = i.book_id 
--   WHERE i.type = 'ISBN';

-- Count books by contributor:
-- SELECT contributor, COUNT(*) as book_count 
--   FROM books 
--   WHERE contributor IS NOT NULL 
--   GROUP BY contributor 
--   ORDER BY book_count DESC;
</xsl:text>
    </xsl:template>
    
    <!-- Template to escape single quotes in SQL strings -->
    <xsl:template name="escape-quotes">
        <xsl:param name="text"/>
        <xsl:choose>
            <xsl:when test="contains($text, &quot;'&quot;)">
                <xsl:value-of select="substring-before($text, &quot;'&quot;)"/>
                <xsl:text>''</xsl:text>
                <xsl:call-template name="escape-quotes">
                    <xsl:with-param name="text" select="substring-after($text, &quot;'&quot;)"/>
                </xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$text"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    
</xsl:stylesheet>