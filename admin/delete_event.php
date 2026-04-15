<?php
/**
 * admin/delete_event.php
 * Removes an event record and its associated image
 */
session_start();
require_once '../db.php';

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        // Get image name before deleting record
        $stmt = $pdo->prepare("SELECT image FROM events WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch();

        if ($event) {
            // Delete image file
            if ($event['image'] && file_exists('../assets/img/' . $event['image'])) {
                unlink('../assets/img/' . $event['image']);
            }

            // Delete record
            $delStmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $delStmt->execute([$id]);
        }
        
        header("Location: dashboard.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        die("Error deleting event: " . $e->getMessage());
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
