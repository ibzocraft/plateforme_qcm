<?php
require_once __DIR__ . '/../config/config.php';

function connectToDB(): PDO {
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    $db_connection = null;
    try {
        $db_connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
        // set the PDO error mode to exception
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        die("Connection to DB failed: " . $e->getMessage());
        // Ajouter une fonction qui affiche une page d'erreur avec la raison de l'erreur.
    }

    return $db_connection;
}

function createTables(): void {
    echo "Lancement du processus de création des tables...\n";
    echo "Tentative de connection à la la base de données: " . $_ENV['DB_NAME'] . " ...\n";
    $db_connection = connectToDB();
    echo "Connection à la base de données réussie!\n";
    
    echo "Creation des tables en cours...\n";
    $sql = file_get_contents(__DIR__ . '/sql/create-tables.sql');
    try {
        $db_connection->exec($sql);
        echo "Création des tables réussie!\n";
    } catch(PDOException $e) {
        die("Erreur lors de la création des tables dans la base de données:\n" . $e->getMessage());
    }
}

function seedDB(): void {
    echo "Lancement du processus de seeding de la base de données...\n";
    echo "Tentative de connection à la la base de données: " . $_ENV['DB_NAME'] . " ...\n";
    $db_connection = connectToDB();
    echo "Connection à la base de données réussie!\n";
    echo "Seeding de la base de données en cours...\n";
    try {
        // Démarrer la transaction
        $db_connection->beginTransaction();
        
        // 1- Seed des utilisateurs
        $test_users = [
            ['ADMIN', 'GUEYE', 'Ibrahima', 'admin@arsonry.com', password_hash('admin123', PASSWORD_DEFAULT), 'admin', null],
            ['ETU001', 'DIAKHATE', 'Baye Cheikh', 'cheikh@example.com', password_hash('etu123', PASSWORD_DEFAULT), 'etudiant', 'L2 GLAR'],
            ['ETU002', 'SECK', 'Samba Laobé', 'samba@example.com', password_hash('etu123', PASSWORD_DEFAULT), 'etudiant', 'L1 GLAR']
        ];
        
        $users_seed_sql = "INSERT INTO utilisateurs (numero_etudiant, nom, prenom, email, mot_de_passe, role, classe) VALUES";
        foreach ($test_users as $user) {
            $users_seed_sql .= "('" . implode("', '", $user) . "'),";
        }
        $users_seed_sql = rtrim($users_seed_sql, ',');
        
        $db_connection->exec($users_seed_sql);
        // --

        // 2- Seeding des autres tables
        $sql = file_get_contents(__DIR__ . '/sql/seed.sql');
        $db_connection->exec($sql);
        // --
        
        // Commit la transaction
        $db_connection->commit();
        
        echo "Seeding de la base de données réussie!\n";
    } catch(PDOException $e) {
        // Rollback transaction on error
        $db_connection->rollBack();
        die("Erreur lors du processus de seeding de la base de données:\n" . $e->getMessage());
    }
}