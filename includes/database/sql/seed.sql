-- Insertion d'utilisateurs (dans db.php)

-- Insertion de QCMs de test
INSERT INTO qcms (titre, description) VALUES
('Mathématiques - QCM 1', 'QCM sur les bases des mathématiques'),
('Physique - QCM 1', 'QCM sur les bases de la physique');

-- Insertion de questions de test
INSERT INTO questions (qcm_id, texte_question) VALUES
(1, 'Combien font 2 + 2 ?'),
(1, 'Quelle est la racine carrée de 9 ?'),
(2, 'Quelle est la formule de la vitesse ?'),
(2, 'Quel est le symbole du Newton ?');

-- Insertion de réponses de test
INSERT INTO reponses (question_id, texte_reponse, est_correcte) VALUES
(1, '4', TRUE),
(1, '5', FALSE),
(2, '3', TRUE),
(2, '6', FALSE),
(3, 'v = d / t', TRUE),
(3, 'v = m * a', FALSE),
(4, 'N', TRUE),
(4, 'J', FALSE);

-- Insertion de résultats de test
INSERT INTO resultats (utilisateur_id, qcm_id, score) VALUES
(2, 1, 100.00),
(3, 2, 75.00);

-- Insertion de notes de test
INSERT INTO notes (utilisateur_id, matiere, valeur) VALUES
(2, 'Mathématiques', 15.50),
(3, 'Physique', 13.00);
