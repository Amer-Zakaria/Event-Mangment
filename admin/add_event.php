<?php
/**
 * admin/add_event.php
 * Form to create a new event record
 */
session_start();
require_once '../db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = $_POST['category'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    
    // Simple image upload handling
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_' . uniqid() . '.' . $ext;
        $target = '../assets/img/' . $image_name;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_name = ''; // Reset if upload fails
            $error = "Failed to upload image.";
        }
    }

    if (!$error) {
        if ($title && $description && $category && $location && $event_date) {
            try {
                $stmt = $pdo->prepare("INSERT INTO events (title, description, category, location, event_date, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $description, $category, $location, $event_date, $image_name]);
                
                header("Location: dashboard.php?msg=added");
                exit;
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Please fill in all required fields.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - SVU Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="mb-4">Add New Event</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="add_event.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title*</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category*</label>
                                <select name="category" id="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="Academic">Academic</option>
                                    <option value="Cultural">Cultural</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Workshops">Workshops</option>
                                    <option value="Social">Social</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="event_date" class="form-label">Event Date & Time*</label>
                                <input type="datetime-local" name="event_date" id="event_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location*</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="e.g., Main Auditorium" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description*</label>
                            <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Event Image (Optional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <div class="form-text">Recommended size: 1200x400 for slider or 800x600 for cards.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Create Event</button>
                            <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
