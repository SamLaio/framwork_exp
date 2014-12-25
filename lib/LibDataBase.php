<?php
class LibDataBase {
	public $dbtype, $dbhost,$dbuser,$dbpass,$dbname,$table;
	public $count = 0;
	public $install = false;

	//共用function
	function __construct() {
		$this->dbtype = DbType;
		if ($this->dbtype == 'mysql') {
			if($this->CheckDataBaseLink(DbHost,3306)){
				$this->dbhost = DbHost;
				$this->dbuser = DbUser;
				$this->dbpass = DbPw;
				$this->dbname = DbName;
			}/*else{
				$this->dbhost = BDbHost;
				$this->dbuser = BDbUser;
				$this->dbpass = BDbPw;
				$this->dbname = BDbName;
			}*/
		}
		if ($this->dbtype == 'sqlite') {
			$this->dbname = DbName;
		}
	}

	public function Link() {
		/*test link add by Sam 20140805*/
		$link = false;
		if ($this->dbtype == 'mysql'){
			$link = new PDO(
					"mysql:host=$this->dbhost;dbname=$this->dbname",
					$this->dbuser,
					$this->dbpass,
					array(
						PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
					)
			);
		}
		if ($this->dbtype == 'sqlite') {
			$link = new PDO("sqlite:" . $this->dbname);
			if (!$link) die ($error);
		}
		/*test link add by Sam 20140805*/
		if($link)
			return $link;
		else{
			echo 'DB link is false.';
			exit;
		}
	}

	//測試連線
	private function CheckDataBaseLink($host, $port) {
		$ch_ini_display = (ini_get('display_errors') == 1);
		if ($ch_ini_display) //判斷ini的display errors的設定
			ini_set('display_errors', 0); //設定連線錯誤時不要display errors
		$x = fsockopen(gethostbyname($host), $port, $errno, $errstr, 1);
		if ($ch_ini_display)
			ini_set('display_errors', 1); //將ini的display error設定改回來
		if (!$x)//測試連線
			return false;
		else {
			fclose($x);
			return true;
		}
	}
	//共用function end
	//語法組合
	public function Select($table, $field, $req = false, $other = false) {
		$table = $this->comb(',',$table);
		$field = $this->comb(',', $field);
		$req = ($req)?'where ' . $req:'';
		$or_by = '';
		$limit = '';
		if($other){
			$or_by = (isset($other['order_by']))?" order by " . $this->comb(',',$other['order_by']):'';
			$limit = (isset($other['limit']))?" limit " . $other['limit']:'';
		}
		$sql = "select $field from $table $req $or_by $limit;";
		return $sql;
	}

	public function In($table, $arr) {
		$field = '(' . $this->comb(',',array_keys($arr)). ')';
		$value = "(" . $this->comb(',',$this->ValAddTip(array_values($arr))) . ')';

		$sql = "insert into $table $field values $value;";
		return $sql;
	}

	public function Del($table, $req = '') {
		//DELETE FROM [TABLE NAME] WHERE 條件;
		$table = $this->comb(',',$table);
		if ($req != '')
			$req = 'where ' . $req;
		$sql = "DELETE FROM $table $req;";
		return $sql;
	}

	public function Up($table, $arr, $req = '') {
		//UPDATE [TABLE NAME] SET [欄名1]=值1, [欄名2]=值2, …… WHERE 條件;
		foreach($arr as $key => $value){
			$toV[] = "`$key`='$value'";
		}
		$value = $this->comb(",",$toV);
		$req = ($req != '')?' where ' . $req:'';
		$sql = "update $table set $value$req;";
		return $sql;
	}
	//語法組合 end
	//sql執行
	public function Query($sql = flase) {
		if($sql){
			$link = $this->Link();
			$link->query($sql);
			$link = null;
		}
	}

	public function Fetch($sql) {
		$link = $this->Link();
		$this->count = 0;
		$query = $link->query($sql);
		$this->count = count($query);
		$query = $query->fetchAll();
		$link = null;
		return $this->ValDecode(query);
	}

	public function Assoc($sql, $field = false, $req = false, $other = false) {
		if($field){
			$sql = $this->Select($sql,$field, $req, $other);
		}
		$link = $this->Link();
		$re = $link->query($sql);
		$re->setFetchMode(PDO::FETCH_ASSOC);
		$re = $re->fetchAll();
		$this->count = count($re);
		$link = null;
		return $this->ValDecode($re);
	}
	//sql執行

	/*共用函式*/
	public function ValAddTip($arr,$tip="'"){
		if(!is_array($arr))
			return $tip.$arr.$tip;
		foreach($arr as $key =>$value){
			$arr[$key] = "$tip$value$tip";
		}
		return $arr;
	}
	protected function comb($sub2,$arr) {
		$re = false;
		if (is_array($arr)) {
			$re = implode($sub2,array_values($arr));
		} else {
			$re = $arr;
		}
		return $re;
	}

	protected function combTip($arr) {
		foreach($arr as $key => $value){
			$arr[$key] = '('.implode(',',$this->ValAddTip($value)).')';
		}
		return implode(',',$arr);
	}

	public function ValDecode($arr){
		if(is_array($arr)){
			foreach($arr as $key2 => $value2)
				$arr[$key2] = $this->ValDecode($value2);
		}else{
			$arr = str_replace(array('@&4', '@&3', '@&2', '@&1', '@&5'), array(">", "<", '"', "'", "&"), stripslashes($arr));
		}
		return $arr;
	}

	public function Json2Array($json) {
		$ret = array();
		foreach($json as $key => $val){
			$ret[$key] =  (is_object($val) or is_array($val))?$this->Json2Array($val):$val;
		}
		return $ret;
	}
	/*共用函式*/