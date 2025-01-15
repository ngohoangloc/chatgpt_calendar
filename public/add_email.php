<?php
require( __DIR__ . "/../database.php" );
require( __DIR__ . "/../autoload.php" );

$db = get_db();
$user_class = get_user_class($db);

// Lấy dữ liệu từ form
$email = isset($_POST['email']) ? $_POST['email'] : '';
$role_id = isset($_POST['role_id']) ? $_POST['role_id'] : '';

// Kiểm tra dữ liệu hợp lệ
if (empty($email) || empty($role_id)) {
    echo json_encode(["status" => "error", "message" => "Email và vai trò không được để trống."]);
    exit;
}

// Kiểm tra xem email có tồn tại trong bảng user hay không
$query = "SELECT id FROM users WHERE email = :email";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Nếu email chưa tồn tại, tạo mới người dùng
    $query = "INSERT INTO users (email) VALUES (:email)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        // Lấy ID của user mới tạo
        $user_id = $db->lastInsertId();

        if ($role_id) {
            // Cập nhật role_id cho user
            $query = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Email đã được thêm và vai trò đã được cập nhật."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật vai trò cho user."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Vai trò không hợp lệ."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi tạo người dùng mới."]);
    }
} else {
    // Nếu email đã tồn tại, chỉ cập nhật lại role_id
    $user_id = $user['id'];
    
    if ($role_id) {
        // Cập nhật role_id cho user
        $query = "UPDATE users SET role_id = :role_id WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Vai trò đã được cập nhật cho người dùng."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật vai trò cho user."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Vai trò không hợp lệ."]);
    }
}

?>
