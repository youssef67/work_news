<h2>Ajouter un commentaire</h2>
<form action="" method="">
    <p>
        <?= isset($erreurs) && in_array(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? "L'auteur est invalide" : '' ?>
        <label>Pseudo</label>
        <input type="text" name="pseudo" value="<?= isset($comment) ? htmlspecialchars($comment['auteur']) : '' ?>"/><br />

        <?= isset($erreurs) && in_array(\Entity\Comment::CONTENU_INVALIDE, $erreurs) ? "Le contenu est invalide" : ""?>
        <label>Contenu</label>
        <textarea name="contenu" row="7" cols="50"><?= isset($comment) ? htmlspecialchars($comment['contenu']) : ""?></textarea>

        <input type="submit" value="Commenter"/>
    </p>
</form>