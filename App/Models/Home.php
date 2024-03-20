<?php

use MVC\Model;

class ModelsHome extends Model
{
    public function getAllUser()
    {
        $result = $this->db->query("SELECT * FROM user");
        return $result;
    }

    public function getUserById($userId)
    {          
        $sql = "SELECT * FROM user WHERE id = :id";
        $result = $this->db->prepare($sql);
        $result->bindParam(':id', $userId, \PDO::PARAM_INT);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertUser($userData)
    {
        $sql = "INSERT INTO user (name, family, age, country, city) VALUES (:name, :family, :age, :country, :city)";
        $result = $this->db->prepare($sql);
        $result->bindParam(':name', $userData['name']);
        $result->bindParam(':family', $userData['family']);
        $result->bindParam(':age', $userData['age'], \PDO::PARAM_INT);
        $result->bindParam(':country', $userData['country']);
        $result->bindParam(':city', $userData['city']);
        $result->execute();
      
    }

    public function updateUser($userId, $userData)
    {
        $sql = "UPDATE user SET name = :name, family = :family, age = :age, country = :country, city = :city WHERE id = :id";
        $result = $this->db->prepare($sql);
        $result->bindParam(':id', $userId, \PDO::PARAM_INT);
        $result->bindParam(':name', $userData['name']);
        $result->bindParam(':family', $userData['family']);
        $result->bindParam(':age', $userData['age'], \PDO::PARAM_INT);
        $result->bindParam(':country', $userData['country']);
        $result->bindParam(':city', $userData['city']);
        return $result->execute();
    }

    public function deleteUser($userId)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $result = $this->db->prepare($sql);
        $result->bindParam(':id', $userId, \PDO::PARAM_INT);
        return $result->execute();
    }
}

