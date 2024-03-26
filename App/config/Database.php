<?php

namespace Thesis\config;

use PDO;
use Thesis\controllers\Login;

/**
 * Summary of Database
 */
class Database
{
    /**
     * Summary of instance
     * @var 
     */
    private static $instance;
    /**
     * Summary of connection
     * @var 
     */
    private $connection; // Declare the $connection property
    /**
     * Summary of statement
     * @var 
     */
    private $statement;
    /**
     * Summary of GetInstance
     * @return Database
     */
    public static function GetInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->connection = new PDO("mysql:host=localhost:3307;dbname=school", "admin", "saboor123");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Summary of GetConnection
     * @return PDO
     */
    public function GetConnection()
    {
        return $this->connection;
    }

    /**
     * Summary of query
     * @param mixed $sql
     * @param mixed $params
     * @return array
     */
    public function query($sql, $params = [])
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public function insert($table, $data)
    {
        $sql = "INSERT INTO $table SET ";
        $placeholders = [];

        foreach ($data as $key => $value) {
            $placeholders[] = "$key = :$key";
        }

        $sql .= implode(", ", $placeholders);

        $statement = $this->connection->prepare($sql);

        // Bind values to named placeholders
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    // ... other methods ..
    public function update($table, $data, $where)
    {
        $sql = "UPDATE $table SET ";
        $placeholders = array();
        foreach ($data as $key => $value) {
            $placeholders[] = "$key = :$key";
        }
        $sql .= implode(", ", $placeholders);
        $sql .= " WHERE $where";

        $statement = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->rowCount(); // Return the number of affected rows
    }

    /**
     * Summary of delete
     * @param mixed $table
     * @param mixed $where
     * @return void
     */
    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
    /**
     * Summary of GetUserInformation
     * @param mixed $tableName
     * @return array
     */
    public function GetUserInformation($tableName, $id)
    {
        $query = "SELECT * FROM $tableName WHERE user_id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function adminUsers($table, $roles)
    {
        $query = "SELECT * FROM $table WHERE roles = :roles";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':roles', $roles, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }



    // select data based on user roles
    /**
     * Summary of users
     * @param mixed $tableName
     * @param mixed $roles
     * @return array
     */
    public function allByUser($tableName, $roles = null)
    {
        $query = "SELECT * FROM $tableName";
        if ($roles !== null) {
            $query .= " WHERE roles = :roles"; // load based on user roles
        }
        // Get the user ID from the login class
        $login = new Login($this->connection);
        $user_id = $login->getUserId();
        // Bind the user ID parameter
        $query .= " WHERE id != :user_id"; // dont load the user itself data
        $statement = $this->connection->prepare($query);
        // Bind the role ID parameter if it is provided
        if ($roles !== null) {
            $statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        }
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function users($tableName, $roles = null)
    {
        $query = "SELECT * FROM $tableName";
        $conditions = array();

        if ($roles !== null) {
            $conditions[] = "roles = :roles";
        }

        // Get the user ID from the login class
        $login = new Login($this->connection);
        $user_id = $login->getUserId();

        // Add condition to exclude the current user's ID
        $conditions[] = "id != :user_id";

        // Combine conditions into a single WHERE clause
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $statement = $this->connection->prepare($query);

        // Bind parameters
        if ($roles !== null) {
            $statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        }
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of GetUsersByRoleAndUserId
     * @param mixed $tableName
     * @param mixed $roles
     * @param mixed $user_id
     * @return array
     */
    public function GetUsersByRoleAndUserId($tableName, $roles, $user_id)
    {
        $query = "SELECT * FROM $tableName WHERE roles = :roles AND id = :user_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Summary of GetPaginatedUsers
     * @param mixed $tableName
     * @param mixed $page
     * @param mixed $perPage
     * @return array
     */
    public function GetPaginatedUsers($tableName, $page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        $query = "SELECT * FROM $tableName LIMIT :offset, :perPage";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of GetTotalUserCount
     * @param mixed $tableName
     * @return mixed
     */
    public function GetTotalUserCount($tableName)
    {
        $query = "SELECT COUNT(*) as total FROM $tableName";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }
    /**
     * Summary of EmailExists
     * @param mixed $email
     * @return bool
     */
    public function EmailExists($email)
    {
        $query = "SELECT * FROM school.users WHERE email = :email";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch();

        if ($user) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Summary of getById
     * @param mixed $tableName
     * @param mixed $id
     * @return mixed
     */
    public function getById($tableName, $id)
    {
        $query = "SELECT * FROM $tableName WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user;
    }


    /**
     * Summary of getUserId
     * @param mixed $tableName
     * @param mixed $idColumn
     * @param mixed $id
     * @return mixed
     */
    public function getUserId($tableName, $idColumn, $id)
    {
        $query = "SELECT * FROM $tableName WHERE $idColumn = :id LIMIT 1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function rowCount($query, $params = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->rowCount();
    }

    public function getUserCountByRole($role)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE roles = :role";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':role', $role, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }
    /**
     * Summary of disconnect
     * @return void
     */
    public function disconnect()
    {
        $this->connection = null;
    }
}
