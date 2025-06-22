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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
        }
        .project-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .project-card:hover {
            box-shadow: 0 10px 24px 0 rgba(76,81,255,0.15), 0 1.5px 4px 0 rgba(0,0,0,0.07);
            transform: translateY(-4px) scale(1.03);
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

<body class="min-h-screen flex items-center justify-center">
    <div class="glass p-10 rounded-3xl shadow-2xl w-full max-w-lg border border-gray-200">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                <i class="fas fa-folder-open text-indigo-500"></i>
                Projects
            </h2>
            <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold shadow">
                <?= $totalProjects ?> total
            </span>
        </div>
        <ul class="space-y-5">
            <?php foreach ($projectsToShow as $project): ?>
                <li>
                    <a href="#" onclick="handleNavigation('<?= htmlspecialchars($project, ENT_QUOTES, 'UTF-8') ?>/')"
                        class="project-card flex items-center gap-4 px-6 py-4 bg-white rounded-2xl shadow hover:bg-indigo-50 transition cursor-pointer border border-gray-100">
                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 text-xl">
                            <i class="fas fa-folder"></i>
                        </span>
                        <span class="flex-1 text-lg font-semibold text-gray-800 truncate">
                            <?= ucfirst(htmlspecialchars($project, ENT_QUOTES, 'UTF-8')) ?>
                        </span>
                        <span class="ml-auto text-indigo-400 hover:text-indigo-700 transition">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="flex justify-between items-center mt-10">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" title="Previous Page"
                   class="flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow">
                    <i class="fas fa-angle-left"></i>
                    <span>Prev</span>
                </a>
            <?php else: ?>
                <span class="flex items-center gap-1 px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="fas fa-angle-left"></i>
                    <span>Prev</span>
                </span>
            <?php endif; ?>

            <span class="px-4 py-2 text-gray-600 font-semibold text-sm">
                Page <?= $page ?> of <?= $totalPages ?>
            </span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" title="Next Page"
                   class="flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow">
                    <span>Next</span>
                    <i class="fas fa-angle-right"></i>
                </a>
            <?php else: ?>
                <span class="flex items-center gap-1 px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    <span>Next</span>
                    <i class="fas fa-angle-right"></i>
                </span>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>