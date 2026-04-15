<?php
/**
 * index.php
 * Landing page displaying featured and recent events
 */
require_once 'db.php';
include 'header.php';

// Fetch featured events (latest 3 for slider)
try {
    $featuredStmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 3");
    $featuredEvents = $featuredStmt->fetchAll();

    // Fetch latest events for the grid
    $recentStmt = $pdo->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 6");
    $recentEvents = $recentStmt->fetchAll();
} catch (PDOException $e) {
    $featuredEvents = [];
    $recentEvents = [];
}
?>

<div class="container">
    <!-- Hero Slider -->
    <section id="hero-slider" class="mb-5">
        <div id="eventCarousel" class="carousel slide shadow" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                <?php if (empty($featuredEvents)): ?>
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/1200x400?text=Welcome+to+SVU+Events" class="d-block w-100" alt="Default">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>Discover University Events</h5>
                            <p>Stay updated with the latest workshops, seminars, and activities.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($featuredEvents as $index => $event): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo $event['image'] ? 'assets/img/'.$event['image'] : 'https://via.placeholder.com/1200x400?text='.urlencode($event['title']); ?>" 
                                 class="d-block w-100" style="height: 400px; object-fit: cover;" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p><?php echo date('M d, Y', strtotime($event['event_date'])); ?> | <?php echo htmlspecialchars($event['location']); ?></p>
                                <a href="event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Quick Categories -->
    <section class="mb-5">
        <h3 class="mb-4">Quick Categories</h3>
        <div class="row g-3 text-center">
            <?php 
            $categories = ['Academic', 'Cultural', 'Sports', 'Workshops', 'Social'];
            foreach ($categories as $cat): 
            ?>
            <div class="col-6 col-md-2">
                <a href="events.php?category=<?php echo $cat; ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm category-card py-3">
                        <div class="card-body">
                            <h6 class="mb-0"><?php echo $cat; ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Recent Events Grid -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Recent Events</h3>
            <a href="events.php" class="btn btn-outline-primary">View All</a>
        </div>
        <div class="row g-4">
            <?php if (empty($recentEvents)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No events found. Stay tuned for updates!</p>
                </div>
            <?php else: ?>
                <?php foreach ($recentEvents as $event): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?php echo $event['image'] ? 'assets/img/'.$event['image'] : 'https://via.placeholder.com/600x400?text=No+Image'; ?>" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <div class="card-body">
                                <span class="badge bg-secondary mb-2"><?php echo htmlspecialchars($event['category']); ?></span>
                                <h5 class="card-title text-truncate"><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p class="card-text small text-muted">
                                    <i class="bi bi-calendar-event"></i> <?php echo date('M d, Y', strtotime($event['event_date'])); ?><br>
                                    <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($event['location']); ?>
                                </p>
                                <p class="card-text text-truncate"><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <a href="event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary w-100">Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
