<?php
/**
 * events.php
 * Displays all events with search and category filtering
 */
require_once 'db.php';
include 'header.php';

$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Build the query dynamically
$query = "SELECT * FROM events WHERE 1=1";
$params = [];

if ($category) {
    $query .= " AND category = :category";
    $params['category'] = $category;
}

if ($search) {
    $query .= " AND (title LIKE :search OR description LIKE :search)";
    $params['search'] = "%$search%";
}

$query .= " ORDER BY event_date ASC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $events = $stmt->fetchAll();
} catch (PDOException $e) {
    $events = [];
}
?>

<div class="container">
    <div class="row mb-4 align-items-end g-3">
        <div class="col-md-4">
            <h2 class="mb-0">All Events</h2>
        </div>
        <div class="col-md-8">
            <form action="events.php" method="GET" class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search events..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php 
                        $cats = ['Academic', 'Cultural', 'Sports', 'Workshops', 'Social'];
                        foreach ($cats as $cat) {
                            $selected = ($category === $cat) ? 'selected' : '';
                            echo "<option value=\"$cat\" $selected>$cat</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($events)): ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">No events match your criteria.</div>
            </div>
        <?php else: ?>
            <?php foreach ($events as $event): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?php echo $event['image'] ? 'assets/img/'.$event['image'] : 'https://via.placeholder.com/600x400?text=Event'; ?>" 
                             class="card-img-top" style="height: 160px; object-fit: cover;" alt="<?php echo htmlspecialchars($event['title']); ?>">
                        <div class="card-body">
                            <span class="badge bg-info text-dark mb-2"><?php echo htmlspecialchars($event['category']); ?></span>
                            <h6 class="card-title text-truncate"><?php echo htmlspecialchars($event['title']); ?></h6>
                            <p class="card-text small text-muted mb-0">
                                <i class="bi bi-calendar"></i> <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                            </p>
                            <p class="card-text small text-muted">
                                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($event['location']); ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="event.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-primary btn-sm w-100">Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
