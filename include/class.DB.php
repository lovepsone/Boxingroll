<?
class DB extends PDO
{
	public $error = false;
	public function __construct($dsn, $username='', $password='', $charset, $driver_options=array())
	{
		try
		{
			parent::__construct($dsn, $username, $password, $driver_options);
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
            
			$this->query("SET NAMES ".$charset);
	        }  
	        catch(PDOException $e)
		{  
			echo 'Error connect data base...';
			exit();
		}
	}
    
	public function prepare($sql, $driver_options=array())
	{
		try
		{
			return parent::prepare($sql, $driver_options);
		}  
		catch(PDOException $e)
		{  
			$this->error($e->getMessage());
		}
	}
    
	public function query($sql)
	{
		try
		{
			return parent::query($sql);
		}  
		catch(PDOException $e)
		{  
			$this->error($e->getMessage());
		}
	}
    
	public function exec($sql)
	{
		try
		{
			return parent::exec($sql);
		}  
		catch(PDOException $e)
		{  
			$this->error($e->getMessage());
		}
	}
	public function count($sql, $data)
	{
		$res = $this->prepare($sql);
		$res->execute($data);
        
		return $res->fetch(PDO::FETCH_OBJ);
	}
	public function error($msg)
	{
		if($this->error)
		{
			echo $msg;
		}
		else
		{
			echo 'An error occurred in the database...';
		}
		exit();
	}
}
class DBStatement extends PDOStatement 
{
	protected $DBH;
    
	protected function __construct($DBH)
	{
		$this->DBH = $DBH;
	}
    
	public function execute($data=array())
	{
		try
		{
			return parent::execute($data);
		}  
		catch(PDOException $e)
		{
			$this->DBH->error($e->getMessage());
		}
	}
}
?>