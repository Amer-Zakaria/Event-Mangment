<?php
/**
 * admin/dashboard.php
 * Main administration panel to list and manage events
 */
session_start();
require_once '../db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
    $events = $stmt->fetchAll();
} catch (PDOException $e) {
    $events = [];
    $error = "Failed to fetch events: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SVU Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <div class="navbar-nav ms-auto">
            <span class="nav-item nav-link text-light me-3">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Events</h2>
        <a href="add_event.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Event</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            $msgs = [
                'added' => 'Event added successfully.',
                'updated' => 'Event updated successfully.',
                'deleted' => 'Event deleted successfully.'
            ];
            echo $msgs[$_GET['msg']] ?? 'Action completed.';
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($events)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No events found. Click "Add New Event" to start.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td class="ps-3 fw-bold"><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($event['category']); ?></span></td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($event['event_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="../event.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-secondary" target="_blank" title="View"><i class="bi bi-eye"></i></a>
                                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this event?')" title="Delete"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="../index.php" class="text-decoration-none">&larr; Back to Public Website</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
