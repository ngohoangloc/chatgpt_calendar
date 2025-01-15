<?php
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

$db = get_db();
$setting_class = get_setting_class($db);

// Lấy dữ liệu từ POST
$title = $_POST['title'] ?? null;
$role_id = $_POST['role_id'] ?? null; // Giá trị mặc định là 'user'
$type = $_POST['type'] ?? 'user'; // Giá trị mặc định là 'user'
$content1 = $_POST['content1'] ?? null;
$content2 = $_POST['content2'] ?? null;

// Kiểm tra dữ liệu bắt buộc
if (!$title || !$content1 || !$content2) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Tạo bản ghi trong bảng `settings`
$setting_id = $setting_class->insert([
    'title' => $title,
    'role_id' => $role_id
]);

if (!$setting_id) {
    echo json_encode(['success' => false, 'message' => 'Failed to create setting.']);
    exit;
}

$meta_data = [
    ['setting_id' => $setting_id, 'setting_key' => $type, 'value' => $content1],
    ['setting_id' => $setting_id, 'setting_key' => 'user', 'value' => $content2],
];

foreach ($meta_data as $meta) {
    $setting_class->insert_meta($meta);
}

echo json_encode(['success' => true, 'message' => 'Setting created successfully!', 'setting_id' => $setting_id]);
