<?php
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

$db = get_db();

// Kiểm tra nếu có setting_id trong POST request
if (isset($_POST['setting_id'])) {
    $settingId = $_POST['setting_id'];

    try {
        // Truy vấn thông tin setting
        $query = "SELECT * FROM settings WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $settingId, PDO::PARAM_INT);
        $stmt->execute();
        $setting = $stmt->fetch(PDO::FETCH_ASSOC);

        // Truy vấn meta
        $query_meta = "SELECT * FROM setting_meta WHERE setting_id = :setting_id";
        $stmt_meta = $db->prepare($query_meta);
        $stmt_meta->bindParam(':setting_id', $settingId, PDO::PARAM_INT);
        $stmt_meta->execute();
        $meta = $stmt_meta->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra và trả về dữ liệu
        if ($setting) {
            if ($meta) {
                echo json_encode(['setting' => $setting, 'meta' => $meta]);
            } else {
                echo json_encode(['setting' => $setting, 'meta' => null]); // Nếu không có meta, trả về null
            }
        } else {
            echo json_encode(['error' => 'Không tìm thấy setting']);
        }
    } catch (Exception $e) {
        // Xử lý lỗi nếu có
        echo json_encode(['error' => 'Lỗi trong quá trình xử lý: ' . $e->getMessage()]);
    }
}
