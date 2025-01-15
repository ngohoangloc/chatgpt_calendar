<?php
class SQLRole implements RoleInterface
{
    protected string $id;
    protected string $name;

    public function __construct(protected PDO $db) {}

    public function get_roles() :array
    {
        $query = "SELECT * FROM roles";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find( int $role_id  ) :self|null
    {
        $query = "SELECT * FROM roles WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            // Gán giá trị cho các thuộc tính trong class
            $this->id = $result['id'];
            $this->name = $result['name']; // Giả sử `setting_key` là title
            return $this;
        }
        return null;
    }

    public function get_name($id) {
        $query = "SELECT * FROM roles WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['name'];
        }
        return null;
    }

}