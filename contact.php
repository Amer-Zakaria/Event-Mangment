<?php
/**
 * contact.php
 * Contact form with JavaScript validation and Bootstrap alerts
 */
include 'header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Get in Touch</h2>
                    <p class="text-center text-muted mb-5">Have a question or want to suggest an event? Send us a message.</p>

                    <!-- Alert Container for JS feedback -->
                    <div id="alert-container"></div>

                    <form id="contactForm" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required>
                                <div class="invalid-feedback">Please specify a subject.</div>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                                <div class="invalid-feedback">Message cannot be empty.</div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-2">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-envelope fs-2 text-primary"></i>
                        <h5 class="mt-2">Email</h5>
                        <p class="text-muted">t_balkhatib@svuonline.org</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-geo-alt fs-2 text-primary"></i>
                        <h5 class="mt-2">Location</h5>
                        <p class="text-muted">SVU Headquarters, Damascus</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="bi bi-share fs-2 text-primary"></i>
                        <h5 class="mt-2">Social</h5>
                        <p class="text-muted">@SVU_University</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
