<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des tags</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Liste des tags</h1>
    <ul>
        <?php foreach ($tags as $tag): ?>
            <li>
                <?= htmlspecialchars($tag['libelle']) ?>
                <form action="index.php?action=listTag" method="post">
                    <input type="hidden" name="idTag" value="<?= $tag['idTag'] ?>">
                    <button type="submit">S'abonner</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
