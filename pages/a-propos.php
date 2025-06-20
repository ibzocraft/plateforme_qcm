<?php
require_once __DIR__ . '/../includes/layout/page.php';
require_once __DIR__ . '/../includes/services/utils/path.php';
?>

<!-- DEBUT PAGE -->
<?php begin_page("À propos") ?>
<!-- /DEBUT PAGE -->

<?php include_once __DIR__ . '/../includes/layout/header.php'; ?>

<style>
    .hero-section {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 400px;
        color: white;
    }
    .hero-title {
        font-size: 2.5rem; /* ~text-4xl */
        font-weight: 900; /* font-black */
    }
    .hero-subtitle {
        font-size: 1.125rem; /* text-lg */
        max-width: 640px; /* max-w-2xl */
    }
    .section-title {
        font-size: 2rem; /* ~text-3xl */
        font-weight: bold;
    }
    .feature-card {
    
        transition: transform 0.2s;
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
    .feature-icon {
        width: 48px;
        height: 48px;
        color: #0d6efd;
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

    @media (min-width: 768px) {
        .hero-title {
            font-size: 3.5rem; /* ~text-6xl */
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section d-flex align-items-center justify-content-center text-center rounded-bottom-4 mx-4 mt-3 rounded-3"
     style='background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop");'>
    <div class="p-5">
        <h1 class="hero-title">À propos de Questions</h1>
        <p class="hero-subtitle mx-auto">
            Notre mission est de fournir une plateforme intuitive et puissante pour faciliter l'apprentissage et l'évaluation des connaissances.
        </p>
    </div>
</div>

<div class="container-lg py-5">
    <!-- Our Story Section -->
    <div class="row align-items-center g-5 py-5">
        <div class="col-lg-6">
            <h2 class="section-title mb-3">Notre Histoire</h2>
            <p class="text-muted">
                "Questions" est né de la volonté de moderniser les outils pédagogiques. Face aux défis de l'enseignement à distance et à la nécessité d'un suivi personnalisé des étudiants, nous avons imaginé une plateforme simple, complète et accessible à tous. Notre objectif est de permettre aux enseignants de créer des évaluations pertinentes en quelques clics et d'offrir aux étudiants un moyen ludique et efficace de tester et d'améliorer leurs connaissances.
            </p>
        </div>
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1542744095-291d1f67b221?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded-3 shadow" alt="Team working">
        </div>
    </div>

    <!-- What We Offer Section -->
    <div class="text-center py-5">
        <h2 class="section-title mb-4">Ce que nous proposons</h2>
        <p class="text-muted mb-5 mx-auto" style="max-width: 720px;">
            "Questions" est une plateforme complète conçue pour aider les étudiants et les administrateurs à gérer efficacement leurs activités académiques. De la création et la passation de quiz au suivi des progrès, "Questions" fournit les outils dont vous avez besoin pour réussir.
        </p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100 p-3">
                    <div class="card-body text-center">
                        <div class="feature-icon bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256"><path d="M224,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h64a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"></path></svg>
                        </div>
                        <h5 class="fw-bold">Quiz Interactifs</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100 p-3">
                    <div class="card-body text-center">
                         <div class="feature-icon bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H128a8,8,0,0,1,0-16h88A8,8,0,0,1,224,128ZM128,72h88a8,8,0,0,0,0-16H128a8,8,0,0,0,0,16Zm88,112H128a8,8,0,0,0,0,16h88a8,8,0,0,0,0-16ZM82.34,42.34,56,68.69,45.66,58.34A8,8,0,0,0,34.34,69.66l16,16a8,8,0,0,0,11.32,0l32-32A8,8,0,0,0,82.34,42.34Zm0,64L56,132.69,45.66,122.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32,0l32-32a8,8,0,0,0-11.32-11.32Zm0,64L56,196.69,45.66,186.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32,0l32-32a8,8,0,0,0-11.32-11.32Z"></path></svg>
                        </div>
                        <h5 class="fw-bold">Suivi des Progrès</h5>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100 p-3">
                    <div class="card-body text-center">
                         <div class="feature-icon bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256"><path d="M216,40H136V24a8,8,0,0,0-16,0V40H40A16,16,0,0,0,24,56V176a16,16,0,0,0,16,16H79.36L57.75,219a8,8,0,0,0,12.5,10l29.59-37h56.32l29.59,37a8,8,0,1,0,12.5-10l-21.61-27H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,136H40V56H216V176ZM104,120v24a8,8,0,0,1-16,0V120a8,8,0,0,1,16,0Zm32-16v40a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm32-16v56a8,8,0,0,1-16,0V88a8,8,0,0,1,16,0Z"></path></svg>
                        </div>
                        <h5 class="fw-bold">Interface Conviviale</h5>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-lg-3">
                <div class="card feature-card h-100 p-3">
                    <div class="card-body text-center">
                         <div class="feature-icon bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256"><path d="M128,24a104,104,0,1,0,104,104A104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-88a40,40,0,1,1-40-40A40,40,0,0,1,168,128Z"></path></svg>
                        </div>
                        <h5 class="fw-bold">Gestion Simplifiée</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Join Us Section -->
    <div class="cta-section bg-theme text-center p-5 rounded-3">
        <h2 class="section-title mb-3">Rejoignez-nous</h2>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 600px;">
            Que vous soyez un étudiant cherchant à renforcer ses compétences ou un administrateur à la recherche d'un outil d'évaluation efficace, "Questions" est fait pour vous.
        </p>
        <a href="<?= get_full_url('/pages/auth/inscription.php') ?>" class="btn btn-custom-1 rounded-pill px-4">
             <span class="text-truncate">Commencer</span>
        </a>
    </div>

</div>

<?php include_once __DIR__ . '/../includes/layout/footer.php'; ?>

<!-- DEBUT PAGE -->
<?php end_page() ?>
<!-- /DEBUT PAGE -->
