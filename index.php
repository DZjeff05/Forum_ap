<?php
    session_start();
    require('actions/users/securityAction.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    <?php include 'includes/navbar.php'; ?>
    <br></br>

    <div class="container">
        <!-- Formulaire de recherche -->
        <form method="GET" action="search.php">
            <div class="form-group">
                <input type="text" class="form-control" name="query" placeholder="Rechercher une question...">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
        <br>

        <!-- Affichage des questions récentes -->
        <h2>Questions récentes</h2>
        <?php
        require('actions/questions/getRecentQuestions.php');
        while ($question = $getRecentQuestions->fetch()) {
            ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $question['title']; ?></h5>
                    <p class="card-text"><?= $question['content']; ?></p>
                    <a href="question.php?id=<?= $question['id']; ?>" class="btn btn-primary">Voir la question</a>
                </div>
            </div>
            <br>
            <?php
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>