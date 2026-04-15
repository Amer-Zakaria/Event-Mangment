<?php
/**
 * about.php
 * Information about the Syrian Virtual University events directory
 */
include 'header.php';
?>

<div class="container">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="display-4 mb-4">About Our Directory</h1>
            <p class="lead">The SVU Events Directory is a dedicated platform designed to bridge the gap between students and university activities.</p>
            <p>Our vision is to create a vibrant campus life by making information accessible, organized, and interactive. Whether you're looking for academic workshops, cultural festivals, or sporting events, we have it all in one place.</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/img/SVU-LOGO.webp" class="img-fluid rounded shadow" alt="About Image">
        </div>
    </div>

    <section class="mb-5">
        <h2 class="text-center mb-5">Meet Our Team</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3 text-center">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/person1.webp" class="card-img-top rounded-circle p-4" alt="Team Member">
                    <div class="card-body">
                        <h5 class="card-title">Amer</h5>
                        <p class="text-muted">Lead Developer</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/person2.webp" class="card-img-top rounded-circle p-4" alt="Team Member">
                    <div class="card-body">
                        <h5 class="card-title">Participant 2</h5>
                        <p class="text-muted">UI/UX Designer</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="card border-0 shadow-sm">
                    <img src="assets/img/person3.webp" class="card-img-top rounded-circle p-4" alt="Team Member">
                    <div class="card-body">
                        <h5 class="card-title">Participant 3</h5>
                        <p class="text-muted">Database Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light p-5 rounded">
        <h2 class="mb-4 text-center">Event Submission Policies</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent">Events must be affiliated with SVU or its partners.</li>
                    <li class="list-group-item bg-transparent">Submissions must be made at least 48 hours in advance.</li>
                    <li class="list-group-item bg-transparent">Content must be appropriate for all audiences.</li>
                    <li class="list-group-item bg-transparent">High-quality images are required for featured events.</li>
                </ul>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
