<?php

class UserService {
    protected $_email;
    protected $_password;
    
    protected $_user;
    
    public function __construct($email, $password) {
        $this->_email = $email;
        $this->_password = $password;
    }
    
    public function login() {
        $user = $this->CheckCredentials();
        if ($user) {
            $this->_user = $user;
            //$_SESSION['user_id'] = $user['id'];
            return $user;
        }
    }
    
    public function CheckCredentials() {
        $dbh = connect_db();
        $sql = "SELECT * FROM customer WHERE UPPER(email) = UPPER('" . $this->_email . "') LIMIT 1";
        
        $query = $dbh->prepare($sql);
        $query->execute();
        
        // Check to see if user exists
        if ($query->rowCount() == 1) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            //$submitted_pass = sha1($user['salt'] . $this->_password);
            $submitted_pass = $this->_password;
            if ($submitted_pass == $user['password']) {
                return $user;
            } 
        }
        
        return false;
    }
    
    public function getUser() {
        return $this->_user;
    }
}

?>