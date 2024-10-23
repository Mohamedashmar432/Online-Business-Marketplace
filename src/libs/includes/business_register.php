<?php

include_once __DIR__ ."./../traits/sql_gettersetter_trait.php";
class business
{
    public $table;
    public $id;
    public $conn;
    use SQLGetterSetter;
    /**
     * business register function to databae.
     *
     * @param $name $name [explicite description]
     * @param $type $type [explicite description]
     * @param $industry $industry [explicite description]
     * @param $description $description [explicite description]
     * @param $profit $profit [explicite description]
     * @param $age $age [explicite description]
     * @param $price $price [explicite description]
     * @param $location $location [explicite description]
     * @param $file $file [explicite description]
     *
     * @return void
     */
    public static function sell_business($name, $type, $industry, $description, $profit, $age, $price, $location, $file): bool
    {
        // Ensure user session is available and valid
        if (!isset($_SESSION['first_name'], $_SESSION['last_name'])) {
            return false; // or handle as needed
        }

        $user = new auth($_SESSION['first_name']);
        $conn = database::getConnection();
        $author = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        $bid = 0;

        // Prepare the SQL statement to prevent SQL injection
        $sql = "INSERT INTO `business` (
                    `uid`, 
                    `business_author`, 
                    `business_name`, 
                    `business_type`, 
                    `business_industry`, 
                    `description`, 
                    `net_profit`, 
                    `business_age`, 
                    `deal_price`, 
                    `location`, 
                    `business_file`, 
                    `bid`,
                    `uploaded_time`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);
        $time=session::getCurrentTime();
        if (!$stmt) {
            // Log the error, but do not expose sensitive information to the user
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        // Bind parameters
        $stmt->bind_param(
            "issssssssssss", // Types: i=integer, s=string
            $user->id,
            $author,
            $name,
            $type,
            $industry,
            $description,
            $profit,
            $age,
            $price,
            $location,
            $file,
            $bid,
            $time
            
            // Default value for bid
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Successfully inserted
            return true;
        } else {
            // Log the error for debugging
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
    }

    /**
     * Method for contact us .
     *
     * @param $number $number [explicite description]
     * @param $language $language [explicite description]
     *
     * @return bool
     */
    public static function contact_us($number, $language): bool
    {
        // Ensure user session is available and valid
        if (!isset($_SESSION['first_name'], $_SESSION['last_name'])) {
            error_log("User session not set.");
            return false; // or handle as needed
        }

        $user = new auth($_SESSION['first_name']);
        if (!isset($user->id)) {
            error_log("User ID is not set.");
            return false; // Handle missing user ID
        }

        $conn = database::getConnection();
        $author = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

        $sql = "INSERT INTO `contact` (`uid`, `name`, `phone`, `language`) VALUES (?, ?, ?, ?)";

        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                return false;
            }

            // Bind parameters
            $stmt->bind_param(
                "isss", // i = integer, s = string
                $user->id,
                $author,
                $number, // Ensure phone numbers are treated as strings
                $language
            );

            // Execute the statement
            if ($stmt->execute()) {
                return true; // Successful execution
            } else {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            // Log the error and handle exception
            error_log("Error executing query: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Method  for getAllBusiness
     *
     * @return void
     */
    public static function getAllBusiness(): array
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `business` ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);

        if ($result && $result->num_rows > 0) {
            // Fetch all rows as an associative array
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Return an empty array if no results or an error occurs
        return [];
    }
    public static function getOneBusiness($id): array
    {
        // Get a connection to the database
        $db = Database::getConnection();
        
        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM `business` WHERE `id` = ?";
        
        // Prepare the statement
        $stmt = $db->prepare($sql);
        
        if ($stmt) {
            // Bind the parameter (i = integer type for id)
            $stmt->bind_param("i", $id);
    
            // Execute the query
            $stmt->execute();
    
            // Get the result of the query
            $result = $stmt->get_result();
    
            if ($result && $result->num_rows > 0) {
                // Fetch all rows as an associative array
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    
        // Return an empty array if no results or an error occurs
        return [];
    }
    


    /**
     * Method countAlldeal
     *
     * @return array
     */
    public static function countAlldeal(): array
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) as count FROM `business` ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        return iterator_to_array($result);
    }

    /**
     * Method __construct
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'business';
    }
}
