<?php
$host = 'localhost:3306';
$dbname = 'plsk_vct01_umarevolution';
$username = 'plsk_vct01_Jus';
$password = 'Justine1234!';

try {
    $objet_PDO = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $objet_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_sql = "SELECT username FROM users WHERE username = :username AND password = :password";
        $login_stmt = $objet_PDO->prepare($login_sql);
        $login_stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $login_stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $login_stmt->execute();

        if ($login_stmt->rowCount() > 0) {
            $_SESSION['username'] = $username;
            echo "<div class='alert alert-success'>Connexion réussie ! Bienvenue $username.</div>";
        } else {
            echo "<div class='alert alert-danger'>Nom d'utilisateur ou mot de passe incorrect.</div>";
        }
    }

    // Récupération des versions
    $version_sql = "SELECT DISTINCT version_en FROM caracters";
    $version_stmt = $objet_PDO->prepare($version_sql);
    $version_stmt->execute();
    $versions = $version_stmt->fetchAll(PDO::FETCH_ASSOC);

    $caracters = [];

    if (isset($_POST['version_select'])) {
        $selected_version = $_POST['version_select'];
        $caracter_sql = "SELECT name_en FROM caracters WHERE version_en = :version";
        $caracter_stmt = $objet_PDO->prepare($caracter_sql);
        $caracter_stmt->bindParam(':version', $selected_version, PDO::PARAM_STR);
        $caracter_stmt->execute();
        $caracters = $caracter_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valeur'])) {
        $new_value = intval($_POST['valeur']);
        $caracter = $_POST['caracter'];
        $version = $_POST['version'];
        $user = $_SESSION['username'];

        $sql = "SELECT valeur FROM caracters WHERE name_en = :caracter AND version_en = :version";
        $stmt = $objet_PDO->prepare($sql);
        $stmt->bindParam(':caracter', $caracter, PDO::PARAM_STR);
        $stmt->bindParam(':version', $version, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $current_value = $row['valeur'];
            if ($new_value > $current_value) {
                $update_sql = "UPDATE caracters SET valeur = :new_value, Trainer = :user WHERE name_en = :caracter AND version_en = :version";
                $update_stmt = $objet_PDO->prepare($update_sql);
                $update_stmt->bindParam(':new_value', $new_value, PDO::PARAM_INT);
                $update_stmt->bindParam(':user', $user, PDO::PARAM_STR);
                $update_stmt->bindParam(':caracter', $caracter, PDO::PARAM_STR);
                $update_stmt->bindParam(':version', $version, PDO::PARAM_STR);
                $update_stmt->execute();
                echo "<div class='alert alert-success'>Valeur mise à jour avec succès par $user !</div>";
            } else {
                echo "<div class='alert alert-danger'>Erreur : la nouvelle valeur doit être supérieure à la valeur actuelle ($current_value).</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Erreur : aucun enregistrement trouvé pour ce personnage et cette version.</div>";
        }
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur de connexion : " . $e->getMessage() . "</div>";
}
?>