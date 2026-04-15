<?php
/**
 * event.php
 * Displays detailed information about a single event
 */
require_once 'db.php';
include 'header.php';

$id = $_GET['id'] ?? 0;

try {
    // Fetch event details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    if (!$event) {
        echo "<div class='container'><div class='alert alert-danger'>Event not found.</div></div>";
        include 'footer.php';
        exit;
    }

    // Fetch related events (same category, excluding current)
    $relatedStmt = $pdo->prepare("SELECT * FROM events WHERE category = ? AND id != ? LIMIT 3");
    $relatedStmt->execute([$event['category'], $id]);
    $relatedEvents = $relatedStmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="events.php">Events</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($event['title']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Event Main Content -->
        <div class="col-lg-8">
            <img src="<?php echo $event['image'] ? 'assets/img/'.$event['image'] : 'https://via.placeholder.com/800x450?text=Event+Image'; ?>" 
                 class="img-fluid rounded shadow-sm mb-4 w-100" alt="<?php echo htmlspecialchars($event['title']); ?>">
            
            <h1 class="mb-3"><?php echo htmlspecialchars($event['title']); ?></h1>
            
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge bg-primary fs-6"><?php echo htmlspecialchars($event['category']); ?></span>
                <span class="badge bg-light text-dark border fs-6"><i class="bi bi-calendar"></i> <?php echo date('F d, Y - H:i', strtotime($event['event_date'])); ?></span>
                <span class="badge bg-light text-dark border fs-6"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($event['location']); ?></span>
            </div>

            <div class="event-description fs-5 lh-base mb-5">
                <?php echo nl2br(htmlspecialchars($event['description'])); ?>
            </div>

            <div class="d-flex gap-3 mb-5">
                <button class="btn btn-success" onclick="alert('Added to calendar!')">
                    <i class="bi bi-calendar-plus"></i> Add to Calendar
                </button>
                <button class="btn btn-outline-secondary" onclick="alert('Share link copied!')">
                    <i class="bi bi-share"></i> Share
                </button>
            </div>
        </div>

        <!-- Sidebar / Related Events -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Event Details</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Organizer:</strong> SVU Activities</li>
                        <li class="mb-2"><strong>Capacity:</strong> Open</li>
                        <li><strong>Status:</strong> Upcoming</li>
                    </ul>
                </div>
            </div>

            <h5 class="mb-3">Related Events</h5>
            <?php if (empty($relatedEvents)): ?>
                <p class="text-muted small">No related events found.</p>
            <?php else: ?>
                <?php foreach ($relatedEvents as $rel): ?>
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="<?php echo $rel['image'] ? 'assets/img/'.$rel['image'] : 'https://via.placeholder.com/150x150?text=Event'; ?>" 
                                     class="img-fluid rounded-start h-100 w-100" style="object-fit: cover;" alt="...">
                            </div>
                            <div class="col-8">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 text-truncate"><a href="event.php?id=<?php echo $rel['id']; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($rel['title']); ?></a></h6>
                                    <p class="card-text small text-muted mb-0"><?php echo date('M d', strtotime($rel['event_date'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
