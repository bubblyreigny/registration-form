<?php

class DatabaseConnection 
{

    /**
     * @var string
     */
    private string $host_name = "localhost";
    
    /**
     * @var string
     */
    private string $user = "reignroot";
    
    /**
     * @var string
     */
    private string $password = "password";
    
    /**
     * @var string
     */
    private string $database_name = "simple_registration_form";
    
    /**
     * @var [type]
     */
    public $connection;

    public function __construct()
    {
        $dsn = "mysql:host=".$this->host_name.";dbname=".$this->database_name;

        try {
            $this->connection = new PDO($dsn, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get all users. 
     * 
     * @return array
     */
    public function all(): array
    {
        try {
            $data = array();
            $sql = "SELECT * FROM users";
            $statement =  $this->connection->prepare($sql);
            $statement->execute();
    
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $value) {
                $data[] = $value;
            }
    
            return $data;
        } catch (\Exception $e) {
            echo json_encode(array('message' => $e));
        }
    }

    public function create(
        string $full_name = null,
        string $email_address = null ,
        string $mobile_number = null,
        string $birthdate = null,
        int $age = null,
        string $gender = null,
    ) {
        try {
            $sql = 'INSERT INTO users(full_name, birthdate, mobile_number, email_address, gender, age) VALUES(:full_name, :birthdate, :mobile_number, :email_address, :gender, :age)';
            $statement = $this->connection->prepare($sql);
            $statement->execute([ 
                'full_name' => $full_name,
                'email_address' => $email_address,
                'mobile_number' => $mobile_number,
                'birthdate' => $birthdate,
                'age' => $age,
                'gender' => $gender
            ]);
    
            return;

        } catch (\Exception $e) {
            echo json_encode(array('message' => $e));
        }
    }   
}

if (isset($_POST)) {
    $errors = [];
    $full_name = $_POST['full_name'];
    $email_address = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $birthdate = date("Y-m-d H:i:s", $_POST['birthdate']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // if (empty($full_name) || $full_name = '') {
    //     $errors['full_name'] = [ 'message' => 'full name is required'];
    // };

    // if (empty($email_address) || $email_address = '') {
    //     $errors['email_address'] = [ 'message' => 'email address is required'];
    // };

    // if (empty($mobile_number) || $mobile_number = '') {
    //     $errors['mobile_number'] = [ 'message' => 'mobile number is required'];
    // };

    // if (empty($age) || $age = '') {
    //     $errors['age'] = [ 'message' => 'age is required'];
    // };

    // if (empty($gender) || $gender = '') {
    //     $errors['gender'] = [ 'message' => 'gender is required'];
    // };

    // function detect_errors($errors) {
    //     if (count($errors) > 0) {
    //         throw new Exception("Given data was invalid");
    //     }
    // }

    // try {
    //     detect_errors($errors);
    // } catch (Exception $e) {
    //     echo json_encode($errors);
    // }

}


try {
    $database = new DatabaseConnection();
    $database->create($full_name, $email_address, $mobile_number, $birthdate, $age, $gender);

    echo json_encode(array('message' => 'success', 'status' => 200));
} catch (\Exception $e) {

}
