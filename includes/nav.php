<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="user_dashboard.php">DDMS</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_dashboard.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="user_dashboard.php">Home</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'upload_document.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="upload_document.php">Upload Document</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'view_documents.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="view_documents.php">View Documents</a>
            </li>
        </ul>
    </div>
    <a href="auth/logout.php" class="btn btn-danger">Logout</a>
</nav>
