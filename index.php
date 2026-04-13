<?php
require_once 'db_config.php';
$cats = $db->query("SELECT * FROM categories ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
$lieux = $db->query("SELECT l.*, c.nom as cat_nom FROM lieux l LEFT JOIN categories c ON l.categorie_id = c.id WHERE l.actif = 1")->fetchAll(PDO::FETCH_ASSOC);
$logo_path = file_exists('assets/logo_path.txt') ? file_get_contents('assets/logo_path.txt') : 'assets/default_logo.png';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Interactive</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <button id="menu-toggle" onclick="toggleSidebar()">
        <div class="line"></div><div class="line"></div><div class="line"></div>
    </button>

    <div id="sidebar" class="hidden">
        <div class="sidebar-header">
            <img src="<?= $logo_path ?>?v=<?= time() ?>" alt="logo">
        </div>
        <div class="sidebar-content">
            <p>Explorer les thématiques</p>
            <button class="filter-btn active" onclick="filterMarkers('all', this)">Tous les lieux</button>
            <?php foreach($cats as $cat): ?>
                <button class="filter-btn" onclick="filterMarkers(<?= $cat['id']; ?>, this)">
                    <?= htmlspecialchars($cat['nom']); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
    <script>
        const lieuxData = <?= json_encode($lieux); ?>;
        initMap(lieuxData);
    </script>
</body>
</html>