<!-- run the the following command in a terminal: 
         npx @tailwindcss/cli -i input.css -o output.css --watch 
     for automatic compiling of used tailwindcss & daisyUI stuff  -->

<!-- php -S localhost:8000 to serve -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/server/db.php';
require_once __DIR__ . '/server/auth.php';

dbInit();

$page = $_GET['page'] ?? 'dashboard'; // default page
$id   = $_GET['id'] ?? null;
$isLoggedIn = isset($_SESSION['user']);

// Sanitize page to prevent directory traversal
$page = basename($page);

// Detect AJAX requests
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Handle logout by route
if ($page === 'logout') {
    logout();
    if ($isAjax) {
        jsonResponse(['success' => true, 'redirect' => 'index.php?page=login']);
    }
    header('Location: index.php?page=login');
    exit;
}

// No in-page POST handling here; async auth endpoints are in server/api.php
$postError = null;


// Determine which file to include
$pageFile = "app/pages/{$page}.php";
if (!file_exists($pageFile)) {
    $pageFile = "app/pages/404.php"; // fallback page
}

// Optional: set page title
$title = ucfirst($page);

// Capture content
ob_start();
include $pageFile;
$content = ob_get_clean();

ob_start();
include __DIR__ . '/app/layouts/notification.php';
$notificationMarkup = ob_get_clean();

if ($isAjax) {
    // Return only the content for AJAX requests
    echo $notificationMarkup . $content;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Project</title>
  <link href="app/assets/output.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-base-200 text-base-content">
  <div class="app-layout <?= $isLoggedIn ? 'app-layout--with-sidebar' : 'app-layout--guest' ?>">
    <!-- Dynamic Navbar -->
    <?php include 'app/layouts/navbar.php'; ?>
    <?= $notificationMarkup ?>

    <div class="app-layout__body">
      <!-- Main content --> 
      <div class="app-workspace">
        <main id="main-content" class="app-main w-full min-w-0">
          <?= $content ?>
        </main>
      </div>
    </div>
  </div>

</body>
</html>
