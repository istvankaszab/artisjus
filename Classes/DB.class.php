<?

class DB
{
    private $db_host = 'localhost';
    private $db_name = 'artisjus';
    private $db_user = 'root';
    private $db_pass = '';
    private $connection;


    public function __construct() {
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die(mysql_error());
    }

    public function disconnect() {
        if($this->connection->close) return true;
            else return false;
    }

    private function tableExists($table) {
        $tablesInDb = $this->connection->query("SHOW TABLES FROM " . $this->db_name . " LIKE '" . $table . "'");
        if($tablesInDb) {
            $num_rows_query = $tablesInDb->num_rows;
            if($num_rows_query == 1) return true; 
            else return false;
        }
    }
    

    public function select() {
        
    }
    public function insert() {

    }
    public function delete() {

    }



    public function update($table,$rows,$where) {
        if($this->tableExists($table)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
        
            $update = "UPDATE ".$table." SET ";
            $keys = array_keys($rows); 
            for($i = 0; $i < count($rows); $i++) {
                if(is_string($rows[$keys[$i]]) and $rows[$keys[$i]] != "true" and $rows[$keys[$i]] != "false") {
                    $update .= $keys[$i]."='".$rows[$keys[$i]]."'";
                }
                else {
                    $update .= $keys[$i]."=".$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($rows)-1) {
                    $update .= ", "; 
                }
            }

          $condition = " WHERE ";
          $c_keys = array_keys($where); 
            for($i = 0; $i < count($where); $i++) {
                if(is_string($where[$c_keys[$i]])) {
                    $condition .= $c_keys[$i]."='".$where[$c_keys[$i]]."'";
                }
                else {
                    $condition .= $c_keys[$i]."=".$where[$c_keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($where)-1) {
                    $condition .= " AND "; 
                }
            }

            $update .= $condition;
            echo $update;
            $query = $this->connection->query($update);
            if($query) {
                return true; 
            }
            else {
                return false; 
            }
        }
        else {
            return false; 
        }
    }



}

?>