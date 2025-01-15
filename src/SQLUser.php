<?php
class SQLUser implements UserInterface
{
    protected int $id;
    protected string $email;
    protected string $name;
    protected int $role_id;
    protected PDO $db;

    // Constructor khởi tạo đối tượng với PDO instance
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Lấy danh sách tất cả người dùng
     * @return array Danh sách người dùng
     */
    public function get_users(): array
    {
        $query = "SELECT * FROM users"; // Câu lệnh SQL lấy tất cả người dùng
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng danh sách người dùng
    }

    /**
     * Tìm người dùng theo user_id
     * @param string $user_id ID của người dùng cần tìm
     * @return self|null Trả về đối tượng SQLSetting nếu tìm thấy, ngược lại trả về null
     */
    public function find(string $user_id): self|null
    {
        $query = "SELECT * FROM users WHERE id = :user_id"; // Câu lệnh SQL để tìm người dùng
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Gán giá trị cho đối tượng
            $this->id = $result['id'];
            $this->email = $result['email'];
            $this->name = $result['name'];
            $this->role_id = $result['role_id'];

            return $this; // Trả về chính đối tượng nếu tìm thấy
        }

        return null; // Nếu không tìm thấy người dùng
    }

    /**
     * Lưu người dùng mới hoặc cập nhật thông tin người dùng
     * @return string Trả về ID người dùng đã được lưu (hoặc cập nhật)
     */
    public function save(): string
    {
        if ($this->id) {
            // Cập nhật người dùng nếu đã có ID
            $query = "UPDATE users SET email = :email, name = :name, role_id = :role_id WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        } else {
            // Thêm mới người dùng nếu không có ID
            $query = "INSERT INTO users (email, name, role_id) VALUES (:email, :name, :role_id)";
            $stmt = $this->db->prepare($query);
        }

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':role_id', $this->role_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->id ?: $this->db->lastInsertId(); // Trả về ID của người dùng vừa thêm hoặc cập nhật
        } else {
            throw new Exception("Lỗi khi lưu người dùng.");
        }
    }

    /**
     * Xóa người dùng khỏi cơ sở dữ liệu
     */
    public function delete(): void
    {
        if ($this->id) {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi xóa người dùng.");
            }
        } else {
            throw new Exception("Không tìm thấy người dùng để xóa.");
        }
    }
}
