<?php
session_start();
$settings = require(__DIR__ . "/../settings.php");
require(__DIR__ . "/../database.php");
require(__DIR__ . "/../autoload.php");

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$db = get_db();
$setting_class = get_setting_class($db);
$role_class = get_role_class($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN TRỊ VIÊN | CHAT GPT</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>

    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        .main-body {
            padding: 15px;
        }

        .nav-link {
            color: #4a5568;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*="col-"] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .setting-block {
            margin-bottom: 20px;
        }

        .setting h4 {
            margin: 10px 0;
        }

        .meta-row {
            margin-bottom: 10px;
        }

        .meta-row input {
            width: 200px;
            margin-right: 10px;
        }

        .form-required {
            color: red;
        }
    </style>
</head>



<body>
    <div class="container-fluid">
        <div class="row gutters-sm">
            <div class="col-md-3 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column nav-pills nav-gap-y-1">
                            <a href="#role" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>Vai trò
                            </a>
                            <a href="#custom_menu" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>Custom Menu
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg></a>
                            </li>
                            <li class="nav-item">
                                <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                    </svg></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="role">
                            <h6>QUẢN LÝ VAI TRÒ</h6>
                            <hr>
                            <!-- Danh sách các vai trò -->
                            <div class="mb-4">
                                <ul class="list-group">
                                    <?php
                                    $roles = $role_class->get_roles();

                                    foreach ($roles as $role) :
                                        // Lấy danh sách email của từng vai trò từ cơ sở dữ liệu
                                        $role_id = $role['id'];
                                        $emails = $role_class->get_emails_by_role($role_id); // Giả sử bạn đã có phương thức này trong lớp $role_class
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center" data-role-id="<?= $role_id ?>">
                                            <div>
                                                <strong><?= $role['name'] ?></strong>
                                                <ul>
                                                    <?php foreach ($emails as $email) : ?>
                                                        <li><?= $email['email'] ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <button class="btn btn-sm btn-success btn-add-email" data-toggle="modal" data-target="#addUserToRoleModal" data-role-id="<?= $role_id ?>" data-role="<?= $role['name'] ?>">Thêm Email</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>


                        </div>
                        <div class="tab-pane" id="custom_menu">
                            <?php
                            $roles = $role_class->get_roles();
                            foreach ($roles as $role) :
                                $settings = $setting_class->get_settings_by_role($role['id']);
                                if (empty($settings)) {
                                    continue;
                                }
                            ?>
                                <h6><?php echo $role['name'] ?></h6>
                                <hr>
                                <?php
                                foreach ($settings as $setting):
                                    $setting['meta'] = $setting_class->get_meta($setting['id']);
                                    $setting['role_name'] = $role_class->get_name($setting['role_id']);
                                ?>
                                    <div class="setting-block setting-<?php echo $setting['id'] ?>">
                                        <div class="setting px-3">
                                            <div class="row">
                                                <div class="col-9">
                                                    <span class="title-setting"><?php echo $setting['title']; ?> </span>
                                                </div>
                                                <div class="col-3 text-end">
                                                    <button type="button" class="btn btn-sm edit-setting-btn" data-id="<?php echo $setting['id'] ?>"><u>Chỉnh sửa</u></button> |
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm mr-3 text-danger"
                                                        style="height: 35px;"
                                                        onclick="confirmDelete(<?php echo $setting['id'] ?>)">
                                                        <u>Xóa</u>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach;
                            endforeach; ?>
                            <div>
                                <button type="submit" class="btn btn-sm btn-outline-primary save-button" data-toggle="modal" data-target="#createSettingModal">Thêm mới</button>
                                <?php require "create_setting_modal.php" ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require "edit_setting_modal.php" ?>
    <?php require "add_email_modal.php" ?>

    <script>
        var settingId;

        $('body').on('click', '.btn-add-email', function() {
            const role = $(this).attr('data-role');
            const role_id = $(this).attr('data-role-id');
            $('#addUserToRoleModal #role').val(role);
            $('#addUserToRoleModal #role_id').val(role_id);
        });

        function confirmDelete(setting_id) {
            if (confirm("Bạn có chắc chắn muốn xóa không?")) {
                fetch('delete_setting.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `setting_id=${setting_id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Xóa thành công!");
                            $(`.setting-${setting_id}`).remove()
                        } else {
                            alert("Không thể xóa: " + (data.message || "Lỗi không xác định"));
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi trong quá trình xóa:", error);
                        alert("Đã xảy ra lỗi trong quá trình xóa.");
                    });
            } else {
                console.log("Người dùng đã hủy xóa.");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Add new meta input when the "Add Meta" button is clicked
            const addMetaButtons = document.querySelectorAll('.add-meta');

            addMetaButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const settingId = this.getAttribute('data-setting-id');
                    const metaRow = document.createElement('div');
                    metaRow.classList.add('meta-row');

                    const newMetaInput = `
                    <input type="text" name="meta[${settingId}][new][key]" placeholder="Setting Key">
                    <input type="text" name="meta[${settingId}][new][value]" placeholder="Value">
                    <button type="button" class="remove-meta">-</button>
                `;
                    metaRow.innerHTML = newMetaInput;

                    // Append new meta row to the setting meta fields
                    const metaFields = document.querySelector(`.meta-fields[data-setting-id="${settingId}"]`);
                    metaFields.appendChild(metaRow);

                    // Add functionality to remove meta row
                    const removeButton = metaRow.querySelector('.remove-meta');
                    removeButton.addEventListener('click', function() {
                        metaRow.remove();
                    });
                });
            });
        });

        $(document).on('click', '.edit-setting-btn', function() {
            settingId = $(this).data('id');
            $.ajax({
                url: 'get_setting.php',
                type: 'GET',
                data: {
                    setting_id: settingId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editSettingId').val(response.data.id);
                        $('#editTitle').val(response.data.title);
                        $('#editRole').val(response.data.role_id);
                        $('#editType').val(response.data.type);
                        $('#editContent1').val(response.data.content1);
                        $('#editContent2').val(response.data.content2);

                        $('#editSettingModal').modal('show');
                    } else {
                        alert('Không thể tải dữ liệu setting!');
                    }
                },
                error: function() {
                    alert('Lỗi khi lấy dữ liệu setting!');
                }
            });
        });

        function updateSetting() {
            // Lấy giá trị từ các input trong modal
            var title = $('#editTitle').val(); // Tiêu đề của setting
            var roleId = $('#editRole').val(); // Vai trò của setting
            var type = $('#editType').val(); // Loại (user/system)
            var content1 = $('#editContent1').val(); // Content 1
            var content2 = $('#editContent2').val(); // Content 2

            // Kiểm tra dữ liệu hợp lệ (có thể mở rộng kiểm tra)
            if (!title || !roleId || !content1 || !content2) {
                alert("Vui lòng điền đầy đủ thông tin.");
                return;
            }

            // Tạo đối tượng dữ liệu để gửi đến server
            var data = {
                setting_id: settingId,
                title: title,
                role_id: roleId,
                type: type,
                content1: content1,
                content2: content2
            };

            // Gửi dữ liệu qua AJAX đến server
            $.ajax({
                url: 'update_setting.php', // URL của file xử lý cập nhật
                type: 'POST',
                data: data,
                success: function(response) {
                    // Xử lý kết quả trả về từ server
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Nếu cập nhật thành công, đóng modal và thông báo thành công
                        $('#editSettingModal').modal('hide');
                        alert("Cập nhật thành công.");
                        location.reload(); // Tải lại trang (hoặc cập nhật giao diện)
                    } else {
                        // Nếu có lỗi, thông báo lỗi
                        alert(result.message || "Cập nhật không thành công.");
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu có
                    alert("Có lỗi xảy ra: " + error);
                }
            });
        }

        $('body').on('submit', '#addUserToRoleForm', function(e) {
            e.preventDefault();

            const role_id = $('#addUserToRoleForm #role_id').val();
            const email = $('#addUserToRoleForm #email').val();

            if (role_id === "" || email === "") {
                alert("Vui lòng nhập đầy đủ thông tin!");
                return;
            }

            // Gửi dữ liệu qua Ajax
            $.ajax({
                url: 'add_email.php',
                method: 'POST',
                data: {
                    role_id: role_id,
                    email: email
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
        });
    </script>

</body>

</html>