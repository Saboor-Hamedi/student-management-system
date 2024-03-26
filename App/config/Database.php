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
     * Summary of this->statement
     * @var 
     */
    public $statement;
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
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute($params);
        // return $this->statement->fetchAll();
        $this->statement->execute($params);
        return $this->statement;
    }
  
    public function fetch($sql, $params = [])
    {
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute($params);
        return $this->statement->fetch();
        $this->statement->execute($params);
        return $this->statement;
    }
    public function fetchAll($sql, $params = [])
    {
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute($params);
        return $this->statement->fetchAll();
        $this->statement->execute($params);
        return $this->statement;
    }

    


    public function insert($table, $data)
    {
        $sql = "INSERT INTO $table SET ";
        $placeholders = [];

        foreach ($data as $key => $value) {
            $placeholders[] = "$key = :$key";
        }

        $sql .= implode(", ", $placeholders);

        $this->statement = $this->connection->prepare($sql);

        // Bind values to named placeholders
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }

        return $this->statement->execute();
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

        $this->statement = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }
        $this->statement->execute();

        return $this->statement->rowCount(); // Return the number of affected rows
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
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute();
    }
    /**
     * Summary of GetUserInformation
     * @param mixed $tableName
     * @return array
     */
    public function GetUserInformation($tableName, $id)
    {
        $query = "SELECT * FROM $tableName WHERE user_id = :id";
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindValue(':id', $id, PDO::PARAM_INT);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function adminUsers($table, $roles)
    {
        $query = "SELECT * FROM $table WHERE roles = :roles";
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindValue(':roles', $roles, PDO::PARAM_INT);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
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
        $this->statement = $this->connection->prepare($query);
        // Bind the role ID parameter if it is provided
        if ($roles !== null) {
            $this->statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        }
        $this->statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
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

        $this->statement = $this->connection->prepare($query);

        // Bind parameters
        if ($roles !== null) {
            $this->statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        }
        $this->statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $this->statement->execute();

        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
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
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindParam(':roles', $roles, PDO::PARAM_INT);
        $this->statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $this->statement->execute();

        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
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
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $this->statement->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $this->statement->execute();

        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of GetTotalUserCount
     * @param mixed $tableName
     * @return mixed
     */
    public function GetTotalUserCount($tableName)
    {
        $query = "SELECT COUNT(*) as total FROM $tableName";
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute();
        $result = $this->statement->fetch(PDO::FETCH_ASSOC);

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
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindParam(':email', $email);
        $this->statement->execute();
        $user = $this->statement->fetch();

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
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        $user = $this->statement->fetch(PDO::FETCH_ASSOC);
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
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindParam(':id', $id);
        $this->statement->execute();
        $row = $this->statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function rowCount($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this->statement->rowCount();
    }

    public function getUserCountByRole($role)
    {
        $query = "SELECT COUNT(*) AS count FROM users WHERE roles = :role";
        $this->statement = $this->connection->prepare($query);
        $this->statement->bindParam(':role', $role, PDO::PARAM_INT);
        $this->statement->execute();
        $result = $this->statement->fetch(PDO::FETCH_ASSOC);

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
