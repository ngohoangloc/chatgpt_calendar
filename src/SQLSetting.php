<?php
class SQLSetting implements SettingInterface
{
    protected string $id;
    protected string $title;
    protected string $role_id;

    public function __construct(protected PDO $db) {}

    /**
     * Lấy tất cả các cài đặt
     * @return array<self>
     */
    public function get_settings(): array
    {
        $query = "SELECT * FROM settings ORDER BY role_id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm kiếm một cài đặt cụ thể theo setting_id
     * @param int $id
     * @return self|null
     */
    public function find(int $id)
    {
        $query = "SELECT * FROM settings WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id = $result['id'];
            $this->title = $result['title']; // Giả sử `setting_key` là title
            $this->role_id = $result['role_id']; // Giả sử `value` là role_id
            return $result;
        }
        return null;
    }

    /**
     * Lấy thông tin meta cho một setting
     * @return array<SettingMeta>
     */
    public function get_meta($id): array
    {
        $query = "SELECT * FROM setting_meta WHERE setting_id = :setting_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':setting_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm một setting_meta mới
     * @param SettingMeta $meta
     * @return bool
     */
    public function add_meta(SettingMeta $meta): bool
    {
        $query = "INSERT INTO setting_meta (setting_id, setting_key, value) VALUES (:setting_id, :setting_key, :value)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':setting_id', $meta->setting_id, PDO::PARAM_INT);
        $stmt->bindParam(':setting_key', $meta->setting_key, PDO::PARAM_STR);
        $stmt->bindParam(':value', $meta->value, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Set giá trị cho setting_id
     * @param int $setting
     */
    public function set_id(int $setting): void
    {
        $this->setting_id = $setting;
    }

    /**
     * Set giá trị cho title
     * @param string $title
     */
    public function set_title(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Set giá trị cho role_id
     * @param int $role_id
     */
    public function set_role(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * Get giá trị của setting_id
     * @return string
     */
    public function get_id(): string
    {
        return $this->setting_id;
    }

    /**
     * Get giá trị của title
     * @return string
     */
    public function get_title(): string
    {
        return $this->title;
    }

    /**
     * Get giá trị của role_id
     * @return string
     */
    public function get_role(): string
    {
        return $this->role_id;
    }

    /**
     * Lưu cài đặt vào cơ sở dữ liệu
     * @return string
     */
    public function save(): string
    {
        $query = "INSERT INTO setting_meta (setting_id, setting_key, value) VALUES (:setting_id, :setting_key, :value)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':setting_id', $this->setting_id, PDO::PARAM_INT);
        $stmt->bindParam(':setting_key', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':value', $this->role_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "Cài đặt đã được lưu thành công";
        }
        return "Có lỗi xảy ra khi lưu cài đặt";
    }

    /**
     * Xóa cài đặt từ cơ sở dữ liệu
     */
    public function delete(): void
    {
        $query = "DELETE FROM setting_meta WHERE setting_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->execute()) {
            $query = "DELETE FROM settings WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function get_settings_by_role($role_id)
    {
        $query = "SELECT * FROM settings WHERE role_id = :role_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Hàm insert: Thêm một bản ghi mới vào bảng settings
     * @param array $data Dữ liệu để thêm vào bảng settings
     * @return int|false Trả về ID của bản ghi vừa thêm hoặc false nếu lỗi
     */
    public function insert($data)
    {
        $query = "INSERT INTO settings (title, role_id) VALUES (:title, :role_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':role_id', $data['role_id']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Trả về ID của bản ghi vừa thêm
        }
        return false; // Lỗi khi thêm bản ghi
    }

    /**
     * Hàm insert_meta: Thêm một bản ghi meta vào bảng setting_meta
     * @param array $data Dữ liệu để thêm vào bảng setting_meta
     * @return bool Trả về true nếu thêm thành công, ngược lại trả về false
     */
    public function insert_meta($data)
    {
        $query = "INSERT INTO setting_meta (setting_id, setting_key, value) VALUES (:setting_id, :setting_key, :value)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':setting_id', $data['setting_id']);
        $stmt->bindParam(':setting_key', $data['setting_key']);
        $stmt->bindParam(':value', $data['value']);

        return $stmt->execute(); // Trả về true nếu thêm thành công
    }

    /**
     * Hàm update: Cập nhật một bản ghi trong bảng settings
     * @param int $id ID của bản ghi cần cập nhật
     * @param array $data Dữ liệu để cập nhật vào bảng settings
     * @return bool Trả về true nếu cập nhật thành công, ngược lại trả về false
     */
    public function update($id, $data)
    {
        $query = "UPDATE settings SET title = :title, role_id = :role_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':role_id', $data['role_id']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }

    /**
     * Hàm update_meta: Cập nhật một bản ghi meta trong bảng setting_meta
     * @param int $setting_id ID của bản ghi setting
     * @param array $data Dữ liệu meta để cập nhật
     * @return bool Trả về true nếu cập nhật thành công, ngược lại trả về false
     */
    public function update_meta($setting_id, $setting_key, $value)
    {
        $query = "UPDATE setting_meta SET value = :value WHERE setting_id = :setting_id AND setting_key = :setting_key";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':setting_id', $setting_id);
        $stmt->bindParam(':setting_key', $setting_key);
        $stmt->bindParam(':value', $value);

        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
}
