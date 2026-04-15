<?php
/**
 * admin/edit_event.php
 * Form to update an existing event record
 */
session_start();
require_once '../db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$error = '';

// Fetch existing data
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    if (!$event) {
        header("Location: dashboard.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = $_POST['category'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    
    // Image update handling
    $image_name = $event['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_image_name = time() . '_' . uniqid() . '.' . $ext;
        $target = '../assets/img/' . $new_image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Delete old image if it exists
            if ($image_name && file_exists('../assets/img/' . $image_name)) {
                unlink('../assets/img/' . $image_name);
            }
            $image_name = $new_image_name;
        } else {
            $error = "Failed to upload new image.";
        }
    }

    if (!$error) {
        if ($title && $description && $category && $location && $event_date) {
            try {
                $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, category = ?, location = ?, event_date = ?, image = ? WHERE id = ?");
                $stmt->execute([$title, $description, $category, $location, $event_date, $image_name, $id]);
                
                header("Location: dashboard.php?msg=updated");
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
    <title>Edit Event - SVU Admin</title>
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
                    <h2 class="mb-4">Edit Event</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="edit_event.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title*</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category*</label>
                                <select name="category" id="category" class="form-select" required>
                                    <?php 
                                    $cats = ['Academic', 'Cultural', 'Sports', 'Workshops', 'Social'];
                                    foreach ($cats as $cat) {
                                        $selected = ($event['category'] === $cat) ? 'selected' : '';
                                        echo "<option value=\"$cat\" $selected>$cat</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="event_date" class="form-label">Event Date & Time*</label>
                                <input type="datetime-local" name="event_date" id="event_date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($event['event_date'])); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location*</label>
                            <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description*</label>
                            <textarea name="description" id="description" rows="5" class="form-control" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Event Image (Leave empty to keep current)</label>
                            <?php if ($event['image']): ?>
                                <div class="mb-2">
                                    <small class="text-muted">Current: <?php echo $event['image']; ?></small>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
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
