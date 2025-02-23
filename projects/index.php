<?php
$projects = array_filter(glob('*'), 'is_dir');
$projectsPerPage = 5;
$totalProjects = count($projects);
$totalPages = ceil($totalProjects / $projectsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$offset = ($page - 1) * $projectsPerPage;
$projectsToShow = array_slice($projects, $offset, $projectsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
        }

        a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 8px;
            font-size: 18px;
            transition: all 0.3s ease;
            text-align: center;
        }

        a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .pagination .disabled {
            background-color: #e9ecef;
            color: #6c757d;
            pointer-events: none;
        }

        .page-info {
            margin: 0 15px;
            font-size: 16px;
            color: #6c757d;
        }
    </style>
    <script>
        function handleNavigation(projectUrl) {
            localStorage.setItem('lastVisited', 'project');
            window.location.href = projectUrl;
        }

        window.onload = function() {
            const lastVisited = localStorage.getItem('lastVisited');
            if (lastVisited === 'project') {
                localStorage.removeItem('lastVisited');
                location.reload();
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>My Projects</h2>
        <ul>
            <?php foreach ($projectsToShow as $project): ?>
                <li><a href="#" onclick="handleNavigation('<?= htmlspecialchars($project, ENT_QUOTES, 'UTF-8') ?>/')">
                        <?= ucfirst(htmlspecialchars($project, ENT_QUOTES, 'UTF-8')) ?>
                    </a></li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" title="Previous Page"><i class="fas fa-angle-left"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-angle-left"></i></span>
            <?php endif; ?>

            <span class="page-info">Page <?= $page ?> of <?= $totalPages ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" title="Next Page"><i class="fas fa-angle-right"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-angle-right"></i></span>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>