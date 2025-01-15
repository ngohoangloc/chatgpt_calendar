<?php
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

$db = get_db();
$setting_class = get_setting_class($db);

$setting_id = $_GET['setting_id'] ?? null;


if (!$setting_id) {
    echo json_encode(['success' => false, 'message' => 'Setting ID is missing.']);
    exit;
}

$setting = $setting_class->find($setting_id, $db);
$setting_meta = $setting_class->get_meta($setting_id);
if ($setting) {
    echo json_encode([
        'success' => true,
        'data' => [
            'id' => $setting['id'],
            'title' => $setting['title'],
            'role_id' => $setting['role_id'],
            'type' => $setting_meta[0]['setting_key'],
            'content1' => $setting_meta[0]['value'],
            'content2' => $setting_meta[1]['value'],
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Setting not found.']);
}
