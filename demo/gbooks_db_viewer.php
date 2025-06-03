<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Database Viewer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .search-section {
            padding: 30px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr 1fr 200px;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #374151;
        }

        .form-control {
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .filter-tag {
            background: #e0e7ff;
            color: #3730a3;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f1f5f9;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #4f46e5;
            display: block;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            margin-top: 5px;
        }

        .results-section {
            padding: 30px;
        }

        .results-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-options {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #4f46e5;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .book-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .book-contributor {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .book-isbn {
            background: #f3f4f6;
            padding: 8px 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #374151;
            margin-bottom: 10px;
        }

        .book-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .page-btn:hover, .page-btn.active {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-results h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .book-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Book Database Viewer</h1>
            <p>Search and explore your book collection</p>
        </div>

        <?php
        // Database configuration
        $db_file = 'library_gbooks.db'; // Change this to your database file path
        
        try {
            $pdo = new PDO("sqlite:$db_file");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        // Get search parameters
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $sort = $_GET['sort'] ?? 'title';
        $page = max(1, intval($_GET['page'] ?? 1));
        $per_page = 12;
        $offset = ($page - 1) * $per_page;

        // Build search query
        $where_conditions = [];
        $params = [];

        if (!empty($search)) {
            $where_conditions[] = "(b.title LIKE :search OR b.contributor LIKE :search OR i.value LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($category)) {
            $where_conditions[] = "b.contributor LIKE :category";
            $params[':category'] = '%' . $category . '%';
        }

        $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

        // Sort options
        $sort_options = [
            'title' => 'b.title ASC',
            'contributor' => 'b.contributor ASC',
            'recent' => 'b.id DESC'
        ];
        $order_clause = 'ORDER BY ' . ($sort_options[$sort] ?? $sort_options['title']);

        // Get statistics
        $stats_query = "
            SELECT 
                COUNT(DISTINCT b.id) as total_books,
                COUNT(DISTINCT b.contributor) as total_contributors,
                COUNT(DISTINCT i.value) as total_isbns,
                COUNT(DISTINCT l.id) as total_libraries
            FROM books b
            LEFT JOIN identifiers i ON b.id = i.book_id
            LEFT JOIN library l ON b.library_id = l.id
        ";
        $stats = $pdo->query($stats_query)->fetch(PDO::FETCH_ASSOC);

        // Get contributors for filter
        $contributors_query = "SELECT DISTINCT contributor FROM books WHERE contributor IS NOT NULL ORDER BY contributor";
        $contributors = $pdo->query($contributors_query)->fetchAll(PDO::FETCH_COLUMN);

        // Main query for books
        $count_query = "
            SELECT COUNT(DISTINCT b.id) as total
            FROM books b
            LEFT JOIN identifiers i ON b.id = i.book_id
            $where_clause
        ";
        $count_stmt = $pdo->prepare($count_query);
        $count_stmt->execute($params);
        $total_results = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_results / $per_page);

        $books_query = "
            SELECT DISTINCT 
                b.id, b.title, b.contributor, b.url as book_url,
                GROUP_CONCAT(i.value, ', ') as isbns
            FROM books b
            LEFT JOIN identifiers i ON b.id = i.book_id AND i.type = 'ISBN'
            $where_clause
            GROUP BY b.id, b.title, b.contributor, b.url
            $order_clause
            LIMIT $per_page OFFSET $offset
        ";
        $books_stmt = $pdo->prepare($books_query);
        $books_stmt->execute($params);
        $books = $books_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="search-section">
            <form method="GET" class="search-form">
                <div class="form-group">
                    <label for="search">Search Books</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Search by title, author, or ISBN..." 
                           value="<?= htmlspecialchars($search) ?>">
                </div>
                
                <div class="form-group">
                    <label for="category">Filter by Contributor</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">All Contributors</option>
                        <?php foreach ($contributors as $contributor): ?>
                            <option value="<?= htmlspecialchars($contributor) ?>" 
                                    <?= $category === $contributor ? 'selected' : '' ?>>
                                <?= htmlspecialchars($contributor) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sort">Sort By</label>
                    <select id="sort" name="sort" class="form-control">
                        <option value="title" <?= $sort === 'title' ? 'selected' : '' ?>>Title A-Z</option>
                        <option value="contributor" <?= $sort === 'contributor' ? 'selected' : '' ?>>Author A-Z</option>
                        <option value="recent" <?= $sort === 'recent' ? 'selected' : '' ?>>Recently Added</option>
                    </select>
                </div>

                <div class="form-group" style="align-self: end;">
                    <button type="submit" class="btn btn-primary">🔍 Search</button>
                </div>
            </form>

            <?php if (!empty($search) || !empty($category)): ?>
            <div class="filters">
                <span style="font-weight: 600; color: #374151;">Active filters:</span>
                <?php if (!empty($search)): ?>
                    <span class="filter-tag">Search: "<?= htmlspecialchars($search) ?>"</span>
                <?php endif; ?>
                <?php if (!empty($category)): ?>
                    <span class="filter-tag">Contributor: <?= htmlspecialchars($category) ?></span>
                <?php endif; ?>
                <a href="?" class="btn btn-secondary btn-small">Clear All</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="stats">
            <div class="stat-card">
                <span class="stat-number"><?= number_format($stats['total_books']) ?></span>
                <div class="stat-label">Total Books</div>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= number_format($stats['total_contributors']) ?></span>
                <div class="stat-label">Contributors</div>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= number_format($stats['total_isbns']) ?></span>
                <div class="stat-label">ISBNs</div>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= number_format($total_results) ?></span>
                <div class="stat-label">Search Results</div>
            </div>
        </div>

        <div class="results-section">
            <?php if (empty($books)): ?>
                <div class="no-results">
                    <h3>No books found</h3>
                    <p>Try adjusting your search criteria or browse all books.</p>
                    <a href="?" class="btn btn-primary" style="margin-top: 20px;">View All Books</a>
                </div>
            <?php else: ?>
                <div class="results-header">
                    <h3>Showing <?= count($books) ?> of <?= number_format($total_results) ?> books</h3>
                </div>

                <div class="book-grid">
                    <?php foreach ($books as $book): ?>
                        <div class="book-card">
                            <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                            
                            <?php if ($book['contributor']): ?>
                                <div class="book-contributor">
                                    👤 <?= htmlspecialchars($book['contributor']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($book['isbns']): ?>
                                <div class="book-isbn">
                                    📖 ISBN: <?= htmlspecialchars($book['isbns']) ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="book-actions">
                                <?php if ($book['book_url']): ?>
                                    <a href="<?= htmlspecialchars($book['book_url']) ?>" 
                                       target="_blank" class="btn btn-primary btn-small">
                                        🔗 View Online
                                    </a>
                                <?php endif; ?>
                                <button onclick="copyToClipboard('<?= htmlspecialchars($book['title']) ?>')" 
                                        class="btn btn-secondary btn-small">
                                    📋 Copy Title
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" 
                               class="page-btn">« Previous</a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" 
                               class="page-btn">Next »</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Create a temporary notification
                const notification = document.createElement('div');
                notification.textContent = 'Title copied to clipboard!';
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #10b981;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    z-index: 1000;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        // Auto-submit form on sort change
        document.getElementById('sort').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html>
