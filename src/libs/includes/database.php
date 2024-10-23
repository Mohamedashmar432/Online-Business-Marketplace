<?php
require_once 'config.php';

class Database
{
    private static $conn = null;
    
  
    /**
     * Get a database connection. Initializes connection if not already done.
     *
     * @return mysqli
     * @throws Exception if connection fails
     */
    public static function getConnection()
    {
        // If the connection is already established, return it.
        if (self::$conn !== null) {
            return self::$conn;
        }

        // Lazy load configuration settings only once
        $servername = config::get_config('database.servername');
        $username = config::get_config('database.username');
        $password = config::get_config('database.password');
        $dbname = config::get_config('database.dbname');
       


        // Create a new database connection
        $connection = new mysqli($servername, $username, $password, $dbname);

        // Check if connection is successful
        if ($connection->connect_error) {
            throw new Exception("Database connection failed: " . $connection->connect_error);
        }

        // Assign the connection to the static variable and return it
        self::$conn = $connection;
        return self::$conn;
    }

    /**
     * Gracefully close the database connection
     */
    public static function closeConnection()
    {
        if (self::$conn !== null) {
            self::$conn->close();
            self::$conn = null;
        }
    }
}
