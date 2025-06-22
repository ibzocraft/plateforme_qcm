<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/utils/console.service.php';


function connectToServer(): PDO {
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];

    $server_connection = null;
    try {
        $server_connection = new PDO("mysql:host=$servername", $username, $password);
        $server_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die(color_error("Connection to MySQL server failed: " . $e->getMessage()));
    }

    return $server_connection;
}

function connectToDB(): PDO {
    $servername = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    $db_connection = null;
    try {
        $db_connection = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    
        // set the PDO error mode to exception
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        die("Connection to DB failed: " . $e->getMessage());
        // Ajouter une fonction qui affiche une page d'erreur avec la raison de l'erreur.
    }

    return $db_connection;
}

function createDB(): void {
    echo_info("Lancement du processus de création de la base de données [".$_ENV['DB_NAME']."]...\n");
    echo_info("Tentative de connection au serveur MySQL...\n");
    $server_connection = connectToServer();
    echo_success("Connection au serveur MySQL réussie!\n");

    echo "Tentative de création de la base de données si elle n'existe pas...\n";
    $sql = "CREATE DATABASE " . $_ENV['DB_NAME'] .";";
    try {
        $server_connection->exec($sql);
        echo_success("Création de la base de données réussie!\n\n");
    } catch(PDOException $e) {
        die(color_error("Erreur lors de la création de la base de données:\n" . $e->getMessage()));
    }
}

function createTables(): void {
    echo_info("Lancement du processus de création des tables...\n");

    echo_info("Tentative de connection à la la base de données: " . $_ENV['DB_NAME'] . " ...\n");
    $db_connection = connectToDB();
    echo_success("Connection à la base de données réussie!\n");
    
    echo_info("Creation des tables en cours...\n");
    $sql = file_get_contents(__DIR__ . '/sql/create-tables.sql');
    try {
        $db_connection->exec($sql);
        echo_success("Création des tables réussie!\n");
    } catch(PDOException $e) {
        die(color_error("Erreur lors de la création des tables dans la base de données: " . $e->getMessage()));
    }
}

function seedDB(): void {
    echo_info("Lancement du processus de seeding de la base de données...\n");
    echo_info("Tentative de connection à la la base de données: " . $_ENV['DB_NAME'] . " ...\n");
    $db_connection = connectToDB();
    echo_success("Connection à la base de données réussie!\n");
    echo_info("Seeding de la base de données en cours...\n");
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
        
        echo_success("Seeding de la base de données réussie!\n");
    } catch(PDOException $e) {
        // Rollback transaction on error
        $db_connection->rollBack();
        die(color_error("Erreur lors du processus de seeding de la base de données:\n" . $e->getMessage()));
    }
}

function dropTables(): void {
    echo_info("Êtes-vous sûr de vouloir supprimer toutes les tables? (Y/N): ");
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if(strtolower(trim($line)) != 'y'){
        echo_info("Opération annulée.\n");
        return;
    }
    fclose($handle);
    echo_info("Lancement du processus de suppression des tables...\n");
    echo_info("Tentative de connection à la la base de données: " . $_ENV['DB_NAME'] . " ...\n");
    $db_connection = connectToDB();
    echo_success("Connection à la base de données réussie!\n");

    echo_info("Suppression des tables en cours...\n");
    $sql = file_get_contents(__DIR__ . '/sql/drop-tables.sql');
    try {
        $db_connection->exec($sql);
        echo_success("Suppression des tables réussie!\n");
    } catch(PDOException $e) {
        die(color_error("Erreur lors de la suppression des tables dans la base de données: " . $e->getMessage()));
    }
}

function dropDB(): void {
    echo_info("Êtes-vous sûr de vouloir supprimer la base de données? (Y/N): ");
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if(strtolower(trim($line)) != 'y'){
        echo_info("Opération annulée.\n");
        return;
    }
    fclose($handle);
    echo_info("Lancement du processus de suppression de la base de données...\n");
    echo_info("Tentative de connection au serveur MySQL...\n");
    $server_connection = connectToServer();
    echo_success("Connection au serveur MySQL réussie!\n");

    echo "Tentative de suppression de la base de données...\n";
    $sql = "DROP DATABASE " . $_ENV['DB_NAME'] .";";
    try {
        $server_connection->exec($sql);
        echo_success("Suppression de la base de données réussie!\n");
    } catch(PDOException $e) {
        die(color_error("Erreur lors de la suppression de la base de données:\n" . $e->getMessage()));
    }
}