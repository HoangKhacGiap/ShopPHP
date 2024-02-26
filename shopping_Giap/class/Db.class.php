<?php
require_once('config/config.php');

class Db
{
	private $_numRow;
	private $dbh = null;


	
	public function __construct()
	{
		//============================ gán chuỗi kết nối ======================
		$driver = "mysql:host=" . HOST . "; dbname=" . DB_NAME;
		//============================ thử kết nối ============================
		try {
			$this->dbh = new PDO($driver, DB_USER, DB_PASS);
			$this->dbh->query("set names 'utf8' ");
		} catch (PDOException $e) {
			echo 'có lỗi xảy ra';
			exit();
		}
	}

	public function __destruct()
	{
		$this->dbh = null;
	}
	//============================ lấy số dồng suất ra từ database
	public function getRowCount()
	{
		return $this->_numRow;
	}
	//============================ truy vấn dữ liệu 
	private function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		$stm = $this->dbh->prepare($sql);
		if (!$stm->execute($arr)) {
			echo "Sql lỗi.";
			exit();
		}
		$this->_numRow = $stm->rowCount();
		return $stm->fetchAll($mode);
	}

	public function select($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		return $this->query($sql, $arr, $mode);
	}

	public function insert($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		$this->query($sql, $arr, $mode);

		return $this->getRowCount();
	}

	public function update($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		$this->query($sql, $arr, $mode);
		return $this->getRowCount();
	}

	public function delete($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		$this->query($sql, $arr, $mode);
		return $this->getRowCount();
	}

	
	public function getNewIDInsert()
	{
		return $this->dbh->lastInsertId();
	}
}
