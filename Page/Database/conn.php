<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    $_SESSION["user"] = "webuser";
}

class Conn
{
    var $conn;
    public function __construct()
    {
        try {
            $servername = "glasdavid.com";
            $username = "root";
            $password = "georgadnandavid";
            $schema = "dag";

            $this->conn = new PDO('mysql:host=' . $servername . ';dbname=' . $schema . ';charset=utf8', $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
        }
    }

    public function makeStatement($query, $arrayValues = null)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($arrayValues);
            return $stmt;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
        }
    }
}

class User extends Conn
{
    function AddUser($svnr, $firstname, $lastname, $password, $roleId)
    {
        try {
            $query = "insert into user(svnr, firstname, lastname, pw, role_id) values (?, ?, ?, ?, ?)";
            $arr = array($svnr, $firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $roleId);
            $stmt = $this->makeStatement($query, $arr);

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function UpdateUser($svnr, $firstname, $lastname, $password, $roleId)
    {
        try {
            $query = "update user 
                        set firstname = ?, 
                            lastName = ?, 
                            pw = ?,
                            role_id = ?
                        where svnr = ?;";
            $arr = array($firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $roleId, $svnr);
            $stmt = $this->makeStatement($query, $arr);

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function CheckLogin($svnr, $password)
    {

        $query = "select u.pw, r.name 
                    from user u left join role r using (role_id)
                    where svnr = ?";
        $stmt = $this->makeStatement($query, array($svnr));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        /* If there is a result, check if the password matches using password_verify(). */
        if (is_array($result)) {
            if (password_verify($password, $result['pw'])) {
                /* The password is correct. */
                if (isset($result["name"]) and $result["name"] != "") {
                    return $result["name"];
                }
                return "webuser";
            }
        }
    }
}

class Food extends Conn
{

    function AddFood($name, $mealArr)
    {
        $foodId = 0;
        # Insert the food
        try {
            $query = "insert into food(name) values (?)";
            $arr = array($name);
            $stmt = $this->makeStatement($query, $arr);
            $foodId = $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }

        # Insert the food_meal relationship
        try {
            foreach ($mealArr as $mealId) {
                $query = "insert into food_meal(food_id, meal_id) values (?, ?)";
                $arr = array($foodId, $mealId);
                $stmt = $this->makeStatement($query, $arr);
            }

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }
}

class Menu extends Conn
{
    var $Breakfast;
    var $Starter;
    var $FirstMainMeal;
    var $SecondMainMeal;
    var $Dessert;
    var $FirstDinner;
    var $SecondDinner;
    function AddOrUpdMenuEntry($foodId, $mealId, $date)
    {

        $query = "select menu_id 
                    from menu 
                    where meal_id = ?
                      and day = ?";
        $stmt = $this->makeStatement($query, array($mealId, $date));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        /* Check if menu entry exists */
        if (!is_array($result)) {
            $query = "insert into menu (meal_id, day)
                        values (?, ?)";
            for ($i = 1; $i <= 7; $i++) {
                $stmt = $this->makeStatement($query, array($i, $date));
            }
        }

        $query = "update menu set food_id = ?
                    where meal_id = ?
                      and day = ?";
        $stmt = $this->makeStatement($query, array($foodId, $mealId, $date));
    }

    function GetMenuByDate($date)
    {
        $query = "select menu_id 
                    from menu_v
                    where day = ?";
        $stmt = $this->makeStatement($query, array($mealId, $date));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}