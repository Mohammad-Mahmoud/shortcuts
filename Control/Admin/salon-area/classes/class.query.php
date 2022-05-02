<?php

class query {
	
	public $result = array();
	
	public $langs;
	 
	static $num;
		
	public static function insert($table,$ar=array()) {
		
		$z = implode("','"  , $ar);
		
		$z = str_pad($z,strlen($z)+1,"'",STR_PAD_LEFT);
		
		$z = $z."'";
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$q = "insert into ".$table." values(".$z.")";
		$result = $mysqli->query($q);
		
		if(!$result) {
			echo $mysqli->error;
		}
	
	}
	
	
	public static function delete($table,$field,$op,$val,$ad='') {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$q = "delete from ".$table." where ".$field." ".$op." ".$val." ".$ad;
		$res = $mysqli->query($q);
		
		if(!$res) {
			echo $mysqli->error;
		}	
		
	}
	
	public function fetchAssoc($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$this->result = $mysqli->query($q);
		
		return $this->result;
		
	}

	
	
	public function __construct() {
		
		$this->langs = $this->fetchAssoc('select * from lang');
		
		
		
	}
	
	public static function update($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
			
		$result = $mysqli->query($q);
		
		if(!$result) {
			echo $mysqli->error;
		}	
	}
	
	
	public static function numRows($q) {
		
		$db = new Database();
		$mysqli = $db->getConnection();
		
		$result = $mysqli->query($q);	
		
		if(!$result) {
			echo $mysqli->error;
		} else {
			self::$num = $result->num_rows;
			return self::$num;
		}
	}
	
	public static function generateSN() { 

		$str = array();
		for($i = 0; $i < 12; $i++){
      		if($letter_OR_number = rand(0,1)){ 
         		$str[] = chr(rand(65, 90));
      		} else { 
				$str[] = rand(0,9);
      		}
		}

		return implode('',$str);
	}

	public function extractArrayFromQuery($table, $col, $con=1) {
		$array = array();

		$q = new self;

		$query = "select $col from $table where $con";
		
		$result = $q->fetchAssoc($query);
		
		while($row = $result->fetch_array()) {
			
				$array[] = $row[$col];
			
		}

		return $array;
	}

    public static function returnSingleValue($table, $col, $con)
    {
        $query = new self;
        $q = $query->fetchAssoc("select $col from $table where $con");
        $c = $q->fetch_assoc();
        $result = $c[$col];

        return $result;
    }
    public function extract2DArrayFromQuery($table, $cols=[], $con = 1)
    {
        //$array = [];
        $val_ar = [];

        $q = new self;

        $query = "select * from $table where $con";

        $result = $q->fetchAssoc($query);

        $n = self::numRows($query);

        if ($n > 0) {
            while ($row = $result->fetch_assoc()) {

                foreach($cols as $key => $val)
                    $val_ar[$val] = $row[$val];

                    //$array[] = $val_ar;
            }
        }

        return $val_ar;
    }
	
}



?>