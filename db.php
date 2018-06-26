<?php
class db
{
    public $host = "localhost";
    public $root = "root";
    public $password = "123456";
    public $dbname = "messageboard";

    public function Query($sql,$type=1)
    {
        $db = new mysqli($this->host,$this->root,$this->password,$this->dbname);
        $r = $db->query($sql);
        $db ->close();
        if($type == "1")
        {
        	$result = $r->fetch_all();

            return $result;
        }
        else
        {
            return $r;
        }
    }

    public function Insert($sql){

    	$conn = new mysqli($this->host,$this->root,$this->password,$this->dbname);

    	if ($conn->connect_error) {
		    die("连接失败: " . $conn->connect_error);
		} 

		$boolean = $conn->query($sql);

		$conn->close();

    	if ($boolean === TRUE) {
    		return  true;
		} else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
    		return false;
		}

    }

}



?>