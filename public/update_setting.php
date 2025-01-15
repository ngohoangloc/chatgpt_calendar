<?php
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

$db = get_db();
$setting_class = get_setting_class($db);

$setting_id = $_POST['setting_id'] ?? null;
$title = $_POST['title'] ?? null;
$role_id = $_POST['role_id'] ?? null;
$type = $_POST['type'] ?? null;
$content1 = $_POST['content1'] ?? null;
$content2 = $_POST['content2'] ?? null;

if (!$setting_id || !$title || !$type || !$content1 || !$content2) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$update = $setting_class->update($setting_id, [
    'title' => $title,
    'role_id' => $role_id
]);

if ($update) {
    $setting_class->update_meta($setting_id, $type, $content1);
    $setting_class->update_meta($setting_id, 'user', $content2);

    echo json_encode(['success' => true, 'message' => 'Setting updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update setting.']);
}
