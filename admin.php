<?php
session_start();
require_once 'db_config.php';
$admin_password = '';

// --- AUTHENTIFICATION ---
if (isset($_POST['login_pass']) && $_POST['login_pass'] === $admin_password) $_SESSION['carte_inter'] = true;
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit; }
if (!isset($_SESSION['carte_inter'])) {
    die('<div style="text-align:center;margin-top:100px;font-family:sans-serif;"><h2>Admin</h2><form method="POST"><input type="password" name="login_pass"><button>Entrer</button></form></div>');
}

// --- GESTION DU LOGO ---
if (isset($_FILES['new_logo'])) {
    $target_dir = "assets/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
    $ext = pathinfo($_FILES['new_logo']['name'], PATHINFO_EXTENSION);
    $target_file = $target_dir . "logo_principal." . $ext;
    
    if (move_uploaded_file($_FILES['new_logo']['tmp_name'], $target_file)) {
        // On enregistre le chemin dans un fichier de config simple ou on force le nom
        file_put_contents('assets/logo_path.txt', $target_file);
        $msg = "Logo mis à jour !";
    }
}

// --- LOGIQUE CRUD (Lieux & Catégories) ---
$lieux = $db->query("SELECT l.*, c.nom as cat_nom FROM lieux l LEFT JOIN categories c ON l.categorie_id = c.id ORDER BY l.id DESC")->fetchAll(PDO::FETCH_ASSOC);
$cats = $db->query("SELECT * FROM categories ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
$logo_actuel = file_exists('assets/logo_path.txt') ? file_get_contents('assets/logo_path.txt') : 'assets/default_logo.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Interactive</title>
    <link rel="stylesheet" href="style.css"> <style>
        body { overflow-y: auto; background: #f1f5f9; padding: 20px; flex-direction: column; }
        .admin-container { max-width: 800px; margin: 0 auto; width: 100%; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 6px; }
        button { background: #1e293b; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; }
        .logo-preview { height: 60px; display: block; margin-bottom: 10px; border: 1px dashed #ccc; padding: 5px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Console Administration</h1>
        <p><a href="admin.php?logout=1">Se déconnecter</a> | <a href="index.php" target="_blank">Voir la carte</a></p>

        <div class="card">
            <h3>🖼️ Logo de la Sidebar</h3>
            <img src="<?= $logo_actuel ?>?v=<?= time() ?>" class="logo-preview">
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="new_logo" accept="image/*" required>
                <button type="submit">Changer le logo</button>
            </form>
            <?php if(isset($msg)) echo "<p style='color:green'>$msg</p>"; ?>
        </div>

        <div class="card">
            <h3>📍 Ajouter / Modifier un Lieu</h3>
            </div>
        
        <div class="card">
            <h3>📋 Liste des points</h3>
            </div>
    </div>
</body>
</html>