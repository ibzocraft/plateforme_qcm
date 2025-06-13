<?php
    require_once __DIR__ . '/../includes/layout/page.php';
    require_once __DIR__ . '/../includes/database/db.php';

    // if (!is_authenticated()) redirect("./auth/connection.php");
    // createTables();
    // seedDB();
?>

<!-- DEBUT PAGE -->
<?php begin_page("Accueil") ?>
<!-- /DEBUT PAGE -->

<?php include_once __DIR__ . '/../includes/layout/header.php'; ?>

<style>
    .hero-section {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 480px;
    }
    .hero-title {
        font-size: 2.25rem; /* text-4xl */
        font-weight: 900; /* font-black */
        line-height: 1.25; /* leading-tight */
        letter-spacing: -0.033em;
    }
    .hero-subtitle {
        font-size: 0.875rem; /* text-sm */
    }
    .btn-custom-1 {
        background-color: #dce8f3;
        color: #121416;
        height: 2.5rem; /* h-10 */
        font-size: 0.875rem; /* text-sm */
        font-weight: bold;
        letter-spacing: 0.015em;
        min-width: 84px;
        max-width: 480px;
    }
    .btn-custom-1:hover { background-color: #c9d7e6; }
    .btn-custom-2 {
        background-color: #f1f2f4;
        color: #121416;
        height: 2.5rem; /* h-10 */
        font-size: 0.875rem; /* text-sm */
        font-weight: bold;
        letter-spacing: 0.015em;
        min-width: 84px;
        max-width: 480px;
    }
    .btn-custom-2:hover { background-color: #e1e2e4; }

    .section-title {
        font-size: 2rem; /* text-[32px] */
        font-weight: bold;
        letter-spacing: -0.01em; /* tracking-light */
    }

    .card-img {
        aspect-ratio: 16/9;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Approximating container queries with media queries using Bootstrap breakpoints */
    @media (min-width: 576px) { /* sm breakpoint for ~480px */
        .hero-section-wrapper {
            padding: 1.5rem;
        }
        .hero-section {
            gap: 2rem !important;
        }
        .hero-title {
            font-size: 3rem; /* text-5xl */
        }
        .hero-subtitle {
            font-size: 1rem; /* text-base */
        }
        .btn-custom-1, .btn-custom-2 {
            height: 3rem; /* h-12 */
            padding-left: 1.25rem; /* px-5 */
            padding-right: 1.25rem; /* px-5 */
            font-size: 1rem; /* text-base */
        }
        .section-title {
            font-size: 2.25rem; /* text-4xl */
            font-weight: 900; /* font-black */
            letter-spacing: -0.033em;
        }
        .cta-section {
            padding-top: 5rem; /* py-20 */
            padding-bottom: 5rem; /* py-20 */
            padding-left: 2.5rem; /* px-10 */
            padding-right: 2.5rem; /* px-10 */
        }
    }
</style>


<div class="container-lg py-4">
    <div class="d-flex flex-column">
        <div class="hero-section-wrapper">
            <div class="hero-section d-flex flex-column justify-content-end gap-4 p-4 rounded-4"
                 style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDq2zCMQ-50IDhr6s_fBVvq_IumRM1nZ8j_Sf-Yyh37yo_xYT7UHzkanpwCox5sxKSJbIOiTFvqFqrdaOUxZMECEr8arOetea6tZzOz3zKse3nrwDGygfDMU50mhtblTlwVXHK9BLdxZj1yBCE79247U036bRKASc6r0Fr2qPAJ3-aom2o4s_Rp4AVbQ7V1UOv8-yU6SAheaUX6nLwIFSNUktonnQqIvow-UGigMu0Xu7naMJ1Yc1fHFqoHj5Hhd6fDwVT0ttAnVrw");'>
                <div class="d-flex flex-column gap-2 text-start text-white">
                    <h1 class="hero-title">
                        Renforcez votre parcours d'apprentissage avec Questions
                    </h1>
                    <h2 class="hero-subtitle fw-normal lh-normal">
                        Questions est une plateforme complète conçue pour aider les étudiants et les administrateurs à gérer efficacement leurs activités académiques. De la création et la passation de quiz au suivi des progrès, Questions fournit les outils dont vous avez besoin pour réussir.
                    </h2>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <button class="btn btn-custom-1 rounded-pill px-4">
                        <span class="text-truncate">Commencer</span>
                    </button>
                    <button class="btn btn-custom-2 rounded-pill px-4">
                        <span class="text-truncate">En savoir plus</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column gap-4 px-4 py-5">
            <div class="d-flex flex-column gap-3">
                <h1 class="section-title" style="max-width: 720px;">
                    Fonctionnalités Clés
                </h1>
                <p class="text-body" style="max-width: 720px;">
                    Questions offre une gamme de fonctionnalités adaptées pour répondre aux besoins des étudiants et des administrateurs.
                </p>
            </div>
            <div class="row g-3">
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex flex-column flex-grow-1 gap-3 rounded-3 border border-gray p-4 h-100">
                        <div class="text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M224,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h64a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"></path>
                            </svg>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="h5 fw-bold">Quiz Interactifs</h2>
                            <p class="text-muted small">
                                Créez et participez à des quiz interactifs avec différents types de questions, y compris des choix multiples, vrai/faux et des réponses courtes.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex flex-column flex-grow-1 gap-3 rounded-3 border border-gray p-4 h-100">
                        <div class="text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M224,128a8,8,0,0,1-8,8H128a8,8,0,0,1,0-16h88A8,8,0,0,1,224,128ZM128,72h88a8,8,0,0,0,0-16H128a8,8,0,0,0,0,16Zm88,112H128a8,8,0,0,0,0,16h88a8,8,0,0,0,0-16ZM82.34,42.34,56,68.69,45.66,58.34A8,8,0,0,0,34.34,69.66l16,16a8,8,0,0,0,11.32,0l32-32A8,8,0,0,0,82.34,42.34Zm0,64L56,132.69,45.66,122.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32,0l32-32a8,8,0,0,0-11.32-11.32Zm0,64L56,196.69,45.66,186.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32,0l32-32a8,8,0,0,0-11.32-11.32Z"></path>
                            </svg>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="h5 fw-bold">Suivi des Progrès</h2>
                            <p class="text-muted small">
                                Surveillez vos progrès académiques avec des rapports et des analyses détaillés, identifiant les domaines à améliorer.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex flex-column flex-grow-1 gap-3 rounded-3 border border-gray p-4 h-100">
                        <div class="text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M216,40H136V24a8,8,0,0,0-16,0V40H40A16,16,0,0,0,24,56V176a16,16,0,0,0,16,16H79.36L57.75,219a8,8,0,0,0,12.5,10l29.59-37h56.32l29.59,37a8,8,0,1,0,12.5-10l-21.61-27H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,136H40V56H216V176ZM104,120v24a8,8,0,0,1-16,0V120a8,8,0,0,1,16,0Zm32-16v40a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm32-16v56a8,8,0,0,1-16,0V88a8,8,0,0,1,16,0Z"></path>
                            </svg>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <h2 class="h5 fw-bold">Interface Conviviale</h2>
                            <p class="text-muted small">
                                Profitez d'une expérience fluide et intuitive avec notre design moderne et responsive, accessible sur n'importe quel appareil.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column gap-4 px-4 py-5">
            <div class="d-flex flex-column gap-3">
                <h1 class="section-title" style="max-width: 720px;">
                    Pour les Étudiants
                </h1>
                <p class="text-body" style="max-width: 720px;">Améliorez votre expérience d'apprentissage avec les fonctionnalités de Questions axées sur les étudiants.</p>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC8Htnpd7IRW3BmMeQFiPiVOYapCSPkEcxtyZhpxByge3dJTzo06XIVeFgbIKB-jzbjJDLPQ7a8F15m-yICd313-dtPHUaMDsiltAUbka9PkS9i1DticKJuObU1vQZYbfdU-jPYOK30xBJvJrfM9dAdFnuhyxORpOOcwMJmiImqUN4xmutYU5yFxKOd86-778zFjJgl0KX3tRSiFACyP8hJv2aOA1e_tlMQNbJs3fh36MuuVBsQNoOmuWJkSc6pYPpAAxsmW0Pmi78");'></div>
                        <div>
                            <p class="h6 fw-medium">Passer des Quiz</p>
                            <p class="text-muted small">Participez aux quiz créés par vos professeurs et testez vos connaissances sur divers sujets.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAeI0UN-_o5nZ15zSCWHLoeEeQZpIpjA7b4g-lXFoYYZDqq891Mk_koLKKX6hN3vIEZuDw09DbDfxwX3G0-Oxh0qZrVNcRQOU7ONrl5rhE68r0IPHV8hh3eSN5BVwqpN7BhjMReymHFDXBKPXMrSwRw56I0828spXRr1ELUt0jlssI4M3WkyjhyngqCozeXOBxMvYKOnEwTDVQJvbQm3osmmpWCVYYrSuphzj9yFLesiqOOsOQDpxh3EuVFx4ALn7nAgduf-ahfn6o");'></div>
                        <div>
                            <p class="h6 fw-medium">Suivre les Progrès</p>
                            <p class="text-muted small">
                                Consultez des rapports détaillés sur vos performances aux quiz, y compris les scores, le temps passé et les points à améliorer.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC8HSpw6WmTer5NhJOAKBxLTBBddAMuhuAFyN9W6FkBk6NFBtYd_0dLIHy02F5ngkaAlq4TIkwIzCpUTW2FZS-cX3krRK47KO_1BGnP8QnY0b2PqYgZyKE-ZqR218kRI2MXl4rnmNrXvySkh9aGqDUnDoucudSNNK6n3U7aY6FEghVvP4gWQl--ciJpFGor8REz2eFo7CjIeCc0DiRiZaeXdQziZePhCxYIEk6hcGDGsUfShT37k2vsvMZHn6SbMus0JXG7rhuPEXA");'></div>
                        <div>
                            <p class="h6 fw-medium">Consulter les Résultats</p>
                            <p class="text-muted small">Accédez aux résultats des quiz précédents et revoyez vos réponses pour identifier les domaines où vous pouvez vous améliorer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column gap-4 px-4 py-5">
            <div class="d-flex flex-column gap-3">
                <h1 class="section-title" style="max-width: 720px;">
                    Pour les Administrateurs
                </h1>
                <p class="text-body" style="max-width: 720px;">Optimisez vos tâches administratives avec les outils puissants de Questions.</p>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBShGI5npvKszyN-p2PLV89l2YlTQOfMH_HL1KrMMvUs1ip5OPLdQp85tEPiViTQwhNcbNG588vE6jZVMmxEAM9mVMn8AD2FbG5eTHKMXn8EyXKZW4hex_dBjzRgNqpNoq3fYPAQaj1rOXy3jnkmAYoihiZlQFFQEWN7dh15FolHcSzbUbReaG4IR6t1Gijvz20nx_MZXQuwwK_mYtcJ20zJJi9jyAXzxvVocHK76acwozvXmKBepBQvqxRUmfvEihcv-aA9A6qJjE");'></div>
                        <div>
                            <p class="h6 fw-medium">Créer des Quiz</p>
                            <p class="text-muted small">Créez et personnalisez facilement des quiz avec une variété de types de questions et de paramètres.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAsUtg97USMh9ToATWWvg-KZF9NWi3Ny7Sd24Ixd6AbcSzXjztB480E9qHl5E1CuMxU3Q8Yje2tGBIiCxD1iuijPlj-GaAKjQW-4j4xC3YyhULrQ9qdvDgK4qHnKlKqJV-sw9TDj1BXpN4gWpnfRRuwtkhVWFBsHBtiDj4Q8F1kAXAWCB6t0B1z6vciWJ581P6U5f6xSnPYsb9kC39OVwGrzCQ8Z2Ri4UnjJ_hcQBMBXcztEKXdBJa6O3bcW_mnS4zQoJ1vl0Lbq0I");'></div>
                        <div>
                            <p class="h6 fw-medium">Gérer les Utilisateurs</p>
                            <p class="text-muted small">Gérez les comptes et les autorisations des étudiants, garantissant un environnement d'apprentissage sécurisé et organisé.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column gap-3 pb-3">
                        <div class="w-100 rounded-3 card-img"
                             style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBh1l1uQGuEB6GElrMpcuE3egfgMjJhHWy59akbtC-8eHciYUQ9uYq4CbajIWYkWAeXFRf5SbhJaOcjn2wIDCQNKpbA90n3hrs8PoR9HxfykFOuKTtbOJihjUin7zLnqead3SOeaGfh_WXtSHowH5nAzxOtw6qW9iQPbCFiUFkSvcw-tFOB3M-APzmhoNRp-s3KkcITgCcwGczK2K3yg1S9eCRjDK6HEosiy4OQUyy0Ft6-H3atGdtExtL7CUCzroFAW9iOzF_2BPg");'></div>
                        <div>
                            <p class="h6 fw-medium">Voir les Performances</p>
                            <p class="text-muted small">
                                Surveillez les performances des étudiants avec des analyses et des rapports complets, suivez les progrès et identifiez les tendances.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cta-section d-flex flex-column justify-content-end gap-3 px-4 py-5 text-center">
            <div class="d-flex flex-column gap-2">
                <h1 class="section-title mx-auto" style="max-width: 720px;">
                    Prêt à commencer ?
                </h1>
                <p class="text-body mx-auto" style="max-width: 720px">
                    Rejoignez Questions aujourd'hui et faites passer votre expérience d'apprentissage ou d'enseignement au niveau supérieur.
                </p>
            </div>
            <div class="d-grid gap-2 col-8 col-md-6 col-lg-4 mx-auto">
                <button class="btn btn-custom-1 rounded-pill px-4">
                    <span class="text-truncate">Commencer</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../includes/layout/footer.php'; ?>

<!-- FIN PAGE -->
<?php end_page() ?>
<!-- /FIN PAGE -->
