<?php
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

$db = get_db();
$setting_class = get_setting_class($db);

if (! isset($_POST['setting_id'])) {
    die("ERROR: No chat_id provided");
}

$setting_id = $_POST['setting_id'];

$setting = $setting_class->find($setting_id, $db);

if ($setting) {
    $setting->delete();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
