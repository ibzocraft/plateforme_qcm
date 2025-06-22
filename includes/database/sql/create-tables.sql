-- Table utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_etudiant VARCHAR(20) UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'etudiant') DEFAULT 'etudiant',
    classe VARCHAR(50),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table qcms
CREATE TABLE qcms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table questions
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    qcm_id INT NOT NULL,
    texte_question TEXT NOT NULL,
    FOREIGN KEY (qcm_id) REFERENCES qcms(id) ON DELETE CASCADE
);

-- Table reponses
CREATE TABLE reponses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    texte_reponse TEXT NOT NULL,
    est_correcte BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

-- Table resultats
CREATE TABLE resultats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    qcm_id INT NOT NULL,
    score DECIMAL(5,2),
    date_passe TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (qcm_id) REFERENCES qcms(id) ON DELETE CASCADE
);

-- Table notes
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    matiere VARCHAR(100) NOT NULL,
    valeur DECIMAL(5,2) NOT NULL,
    date_note TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);
