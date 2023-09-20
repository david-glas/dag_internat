<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])){
    $_SESSION["user"] = "webuser";
}

class Conn
{
  var $conn;
    public function __construct()
    {
        try {
            $servername = "glasdavid.com";
            $username ="root";
            $password = "georgadnandavid";
            $schema = "dag";

            $this->conn = new PDO('mysql:host=' . $servername . ';dbname=' . $schema . ';charset=utf8', $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch(Exception $e) 
        {
          echo 'Fehler - ' . $e->getCode(). ': ' . $e->getMessage() . '<br>';
        }
    }

    public function makeStatement($query, $arrayValues = null)
    {
      try
      {
        $stmt = $this->conn->prepare($query); 
        $stmt->execute($arrayValues);
        return $stmt;
      }
      catch(Exception $e) 
      {
        echo 'Fehler - ' . $e->getCode(). ': ' . $e->getMessage() . '<br>';
      }
    }
}

class User extends Conn
{

    function AddUser($svnr, $firstname, $lastname, $password, $roleId){
        try
        {
            $query = "insert into user(svnr, firstname, lastname, pw, role_id) values (?, ?, ?, ?, ?)";
            $arr = array($svnr, $firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $roleId);
            $stmt = $this->makeStatement($query, $arr);
            
            echo 'User inserted';
        }
        catch(Exception $e) 
        {
          echo 'Fehler - ' . $e->getCode(). ': ' . $e->getMessage() . '<br>';
        }
    }

    function UpdateUser($svnr, $firstname, $lastname, $password, $roleId){
        try
        {
            $query = "insert into user(svnr, firstname, lastname, pw, role_id) values (?, ?, ?, ?, ?)";
            $arr = array($svnr, $firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $roleId);
            $stmt = $this->makeStatement($query, $arr);
            
            echo 'Updated inserted';
        }
        catch(Exception $e) 
        {
          echo 'Fehler - ' . $e->getCode(). ': ' . $e->getMessage() . '<br>';
        }
    }

    function CheckLogin($svnr, $password){

        $query = "select * from user where svnr = ?";
        $stmt = $this->makeStatement($query, array($svnr));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        /* If there is a result, check if the password matches using password_verify(). */
        if (is_array($result))
        {
          if (password_verify($password, $result['pw']))
          {
            /* The password is correct. */
            $login = TRUE;
            echo 'yes';
          }
          else
          {
            echo 'no';
          }
        }
    } 
}

/* Template */
class DbCon
{
    public $connection = null;

    public function __construct()
    {
        try {
            $servername = "localhost";
            $username = $_SESSION["user"];
            $password = "";
            $dbname = "streaming";
            $this->connection = new mysqli($servername, $username, $password, $dbname);

            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

class UserOld extends DbCon
{
    function CheckLogin($user, $password){
        $sql = "select * from user where name ='$user' and password = '$password'";
        $result = $this->connection->query($sql);
        if ($result->num_rows == 1){
            return mysqli_fetch_assoc($result)["name"];
        }
        return "invalid";
    } 

}

class Kategorien extends DbCon
{

    function GetAllCategories()
    {

        $sql = "select * from kategorien";
        return $this->connection->query($sql);

    }

    function GetCategoryById($id)
    {
        $sql = 'SELECT * FROM Kategorien where id =' . $id . ';';

        return mysqli_fetch_assoc($this->connection->query($sql));
    }
}

class Filme extends DbCon
{

    function GetAllMovies()
    {

        $sql = "SELECT * FROM filme order by id desc limit 9";

        return $this->connection->query($sql);;
    }

    function GetMovieById($id)
    {

        $sql = 'SELECT * FROM filme where id =' . $id . ';';

        return mysqli_fetch_assoc($this->connection->query($sql));
    }

    function GetMoviesByNameAndCategory($moviename, $category, $amount)
    {

        $sql = 'select * from (
				                select f.* from filme f join kategorien k on f.kategorie_id = k.id where upper(f.title) like upper("%' . $moviename . '%") and k.title like ("%' . $category . '%")
                                union
                                 select f.* from filme f join kategorien k on f.kategorie_id = k.id where k.title like ("%' . $category . '%")
                                union
                                select * from filme as T1
	                             ) as T3 
                    limit ' . $amount;

        $this->SearchLog($sql);
        return $this->connection->query($sql);;
    }

    function SearchLog($query)
    {
        $sql = 'INSERT INTO search_logs (user_id, msg) VALUES ((SELECT user_id from USER WHERE name = "' . $_SESSION["user"] . '"), "' . addslashes($query) . '");';
        $this->connection->query($sql);
    }

    function AddMovie($moviename, $category, $anbieter, $kurztext, $langtext, $bild_url)
    {

        $sql = 'insert into filme (title, kategorie_id, kurztext, langtext, bild_url) values 
                ("' . $moviename . '", (Select id from kategorien where title = "' . $category . '"),"' . $kurztext . '" , "' . $langtext . '", "' . $bild_url . '");';
        $this->connection->query($sql);

        $film_id = $this->connection->insert_id;
        foreach ($anbieter as $firma)
        {
            $sql = 'insert into anbieter_filme(film_id, anbieter_id) values ("' . $film_id . '" * 1, (select id from anbieter where title = "' . $firma . '"));';
            $this->connection->query($sql);
        }
        return $film_id;
    }

    function UpdateMovie($movieid, $moviename, $category, $anbieter, $kurztext, $langtext, $bild_url)
    {
        $sql = 'update filme set title = "' . $moviename . '", kurztext = "' . $kurztext . '", langtext = "' . $langtext . '",
	        bild_url = "' . $bild_url . '", kategorie_id = (select id from kategorien where title = "' . $category . '") 
	        where id = "' . $movieid . '" * 1;';
        $this->connection->query($sql);

        $sql = 'delete from anbieter_filme where film_id = "' . $movieid . '";';
        $this->connection->query($sql);


        foreach ($anbieter as $firma)
        {
            $sql = 'insert into anbieter_filme(film_id, anbieter_id) values ("' . $movieid . '" * 1, (select id from anbieter where title = "' . $firma . '"));';
            $this->connection->query($sql);
        }
        return $movieid;
    }

    function GetAnbieterByMovieId($id)
    {

        $sql = 'SELECT anbieter_id FROM anbieter_filme where film_id ="' . $id . '"*1;';

        $anbieter = array();

        $result = $this->connection->query($sql);
        while($row = $result->fetch_assoc() ){
            $anbieter[] = $row["anbieter_id"];
        }
        return $anbieter;
    }
}

class Anbieter extends DbCon
{

    function GetAll()
    {

        $sql = "SELECT * FROM anbieter";

        return $this->connection->query($sql);;
    }
}

?>

