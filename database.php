<?php 
class Database{
    private $db_host="localhost";
    private $db_user="root";
    private $db_pass="";
    private $db_name="oops_db";
    
    private $mysqli="";
    private $result=array();
    private $conn=false;

    public function __construct(){
    if (!$this->conn) {
        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if ($this->mysqli->connect_error) {
            // Handle the error, e.g., log it or throw an exception
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }
        $this->conn = true;
    }   
    }
    public function select($table,$rows='*',$join=null,$where=null,$order=null,$limit=null){
        if($this->tableExists($table)){
            $sql="SELECT $rows FROM $table";
            if($join !=null){
                $sql.=" JOIN $join";
            }
            if($where != null){
                $sql.=" WHERE $where";
            }
            if($order != null){
                $sql.=" ORDER BY $order";
            }
            if($limit != null){
                $sql.=" LIMIT 0,$limit";
            }
            echo $sql;
            $query=$this->mysqli->query($sql);
            if($query){
                $this->result=$query->fetch_all(MYSQLI_ASSOC);
                return true;
            }
            else{
                array_push($this->result,$this->mysqli->error);
                return false;
            }
        }else{
            return false;
        }

    }
    public function select_sql($sql){
        $query=$this->mysqli->query($sql);
        if($query){
            $this->result=$query->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        else{
            array_push($this->result,$this->mysqli->error);
            return false;
        }
    }
    public function insert($table,$param=array()){
        if($this->tableExists($table)){
            $tableColumns=implode(',',array_keys($param));
            $tableValues=implode("','",$param);
            $sql="INSERT INTO $table($tableColumns) VALUES('$tableValues')";
           if($this->mysqli->query($sql)){
            array_push($this->result,$this->mysqli->insert_id);
           }else{
            array_push($this->result,$this->mysqli->error);
           }
        }else{
            return false;
        }
    }
    public function update($table,$param,$where=null){
        if($this->tableExists($table)){
            $args=array();
            foreach ($param as $key => $value) {
                $args[]="$key='$value'";
            }
            $sql="UPDATE $table SET ".implode(',',$args);
            if($where != null){
                $sql.=" WHERE $where";
            }
            if($this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->affected_rows);
               }else{
                array_push($this->result,$this->mysqli->error);
               }
        }
    }
    public function delete($table,$where=null){
        if($this->tableExists($table)){
            $sql="DELETE FROM $table";
            if($where != null){
                $sql.=" WHERE $where";
            }
            if($this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->affected_rows);
               }else{
                array_push($this->result,$this->mysqli->error);
               } 
        }
    }
    public function getResult(){
        $val=$this->result;
        $this->result=array();
        return $val;
    }
    private function tableExists($table){
        $sql="SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb=$this->mysqli->query($sql);
        if($tableInDb){
            if($tableInDb->num_rows==1){
                return true;
            }else{
                array_push($this->result,$table."Does Not Exists in This Database");
                return false;
            }
        }
    }
    public function __destruct(){
        if($this->conn){
            if($this->mysqli->close()){
            $this->conn=false;
            }
        }
    }

}
?>