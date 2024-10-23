<?php

include_once __DIR__ . "./../traits/sql_gettersetter_trait.php";
class auth
{
    use SQLGetterSetter;
    private $conn;
    public $id;
    public $username;
    public $table;
    public $data;


    public static function signup($fname, $lname, $email, $phone, $pass, $google_id=0)
    {
        $options = [
            'cost' => 9,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn = Database::getConnection();
        $sql = "INSERT INTO `authenticate` (`first_name`, `last_name`, `email`, `phone`, `password`, `google_id`, `status`, `address`, `plan`, `profile`)
                VALUES (?, ?, ?, ?, ?,?, 0, 'insert your address', 'free plan', 'none')";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $fname, $lname, $email, $phone, $pass,$google_id);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e) {

            if ($conn->errno === 1062) { // Duplicate entry error (email already exists)
                return "Email already exists";
            } else {
                // Log the actual error for debugging (optional)
                error_log($e->getMessage()); // Log the actual error message
                return "An error occurred. Please try again later."; // User-friendly message for unexpected errors
            }
        }
    }

    public static function signin($email, $password)
    {

        $query = "SELECT * FROM `authenticate` WHERE `email` = '$email'";
        $conn = database::getConnection();
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                Session::setUserSession($row);
                return $row['first_name'];
            } else {
                throw new Exception('Invalid password');
            }
        } else {
            throw new Exception('User does not exist');
        }
    }
    public function __construct($username)
    {
        //TODO: Write the code to fetch user data from Database for the given username. If username is not present, throw Exception.
        $this->conn = database::getConnection();
        $this->username = $username;
        $this->id = null;
        $this->data = null;
        $this->table = 'authenticate';
        $sql = "SELECT * FROM `authenticate` WHERE `first_name`= '$username' OR `id` = '$username' OR `email` = '$username' LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->data = $row;
            $this->id = $row['id']; //Updating this from database
        } else {
            throw new Exception("Username does't exist");
        }
    }
}
