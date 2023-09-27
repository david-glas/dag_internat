<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    $_SESSION["user"] = ["account" => "webuser"];
}

class Conn
{
    var $conn;
    public function __construct()
    {
        try {
            $servername = "mysql.glasdavid.com";
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

    function GetAllUsers()
    {
        try {
            $query = "select user_id, firstname, lastname, svnr, `name` `role` from user inner join role using(role_id)";
            $stmt = $this->makeStatement($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
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
            }
        }
        return "webuser";
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

    static function GetFoodByMeal($mealId, $dbCon)
    {
        try {
            $query = "select * 
                        from food f, food_meal fm
                        where fm.meal_id = ?
                          and fm.food_id = f.food_id";
            $arr = array($mealId);
            $stmt = $dbCon->makeStatement($query, $arr);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }

    }

    static function GetAllFoodByMeal($dbCon)
    {
        try {
            $query = "select * 
                        from food f, food_meal fm
                        where fm.food_id = f.food_id
                        order by meal_id asc";
            $stmt = $dbCon->makeStatement($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }

    }
    function GetFoodByTod($timeOfDay)
    {
        try {
            $query = "select food_id, `name`, trim(group_concat(' ', `type`)) menu_name " .
                "from food " .
                "inner join food_meal using(food_id) " .
                "inner join meal using(meal_id) " .
                "inner join time_of_day using(tod_id) " .
                "where tod_id = ? " .
                "group by food_id " .
                "order by food_id";
            $arr = array($timeOfDay);
            $stmt = $this->makeStatement($query, $arr);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
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
            $this->AddMenuDay($date);
        }

        $query = "update menu set food_id = ?
                    where meal_id = ?
                      and day = ?";
        $stmt = $this->makeStatement($query, array($foodId, $mealId, $date));
    }

    function AddMenuDay($date)
    {
        $day = date('Y-m-d', $date);
        $query = "insert into menu (meal_id, day)
                    values (?, ?)";
        for ($i = 1; $i <= 7; $i++) {
            $stmt = $this->makeStatement($query, array($i, $day));
        }
    }

    function AddFoodToMenu($foodId, $menuId)
    {
        $query = "update menu set food_id = ?
                    where menu_id = ?";
        $stmt = $this->makeStatement($query, array($foodId, $menuId));

        $query = "select * from food where food_id = ?";
        $stmt = $this->makeStatement($query, array($foodId));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    static function GetMenuByDate($date)
    {

        $Menu = new Menu();
        $query = "select * 
                    from menu_v
                    where day = ?
                    order by meal_id";
        $stmt = $Menu->makeStatement($query, array(date('Y-m-d', $date)));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) {
            return null;
        }
        foreach ($result as $food) {
            switch ($food["meal_id"]) {
                case "1":
                    $Menu->Breakfast = $food;
                    break;
                case "2":
                    $Menu->Starter = $food;
                    break;
                case "3":
                    $Menu->FirstMainMeal = $food;
                    break;
                case "4":
                    $Menu->SecondMainMeal = $food;
                    break;
                case "5":
                    $Menu->Dessert = $food;
                    break;
                case "6":
                    $Menu->FirstDinner = $food;
                    break;
                case "7":
                    $Menu->SecondDinner = $food;
                    break;
                default:
                    break;
            }
        }
        return $Menu;
    }

    function GetMenuByDateAndUser($date, $userId)
    {

        $query = "select * 
                    from menu_v mv left join user_menu um using (menu_id)
                    where day = ?
                      and (user_id = ?
                           or user_id is null)
                    order by meal_id";
        $stmt = $this->makeStatement($query, array(date('Y-m-d', $date), $userId));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) {
            $this->Breakfast = null;
            return $this;
        }
        foreach ($result as $food) {
            switch ($food["meal_id"]) {
                case "1":
                    $this->Breakfast = $food;
                    break;
                case "2":
                    $this->Starter = $food;
                    break;
                case "3":
                    $this->FirstMainMeal = $food;
                    break;
                case "4":
                    $this->SecondMainMeal = $food;
                    break;
                case "5":
                    $this->Dessert = $food;
                    break;
                case "6":
                    $this->FirstDinner = $food;
                    break;
                case "7":
                    $this->SecondDinner = $food;
                    break;
                default:
                    break;
            }
        }
        return $this;
    }
    function GetMenuByDateAdmin($date)
    {

        $query = "select * 
                    from menu_v mv left join user_menu um using (menu_id)
                    where day = ?
                    order by meal_id";
        $stmt = $this->makeStatement($query, array(date('Y-m-d', $date)));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) {
            $this->Breakfast = null;
            return $this;
        }
        foreach ($result as $food) {
            switch ($food["meal_id"]) {
                case "1":
                    $this->Breakfast = $food;
                    break;
                case "2":
                    $this->Starter = $food;
                    break;
                case "3":
                    $this->FirstMainMeal = $food;
                    break;
                case "4":
                    $this->SecondMainMeal = $food;
                    break;
                case "5":
                    $this->Dessert = $food;
                    break;
                case "6":
                    $this->FirstDinner = $food;
                    break;
                case "7":
                    $this->SecondDinner = $food;
                    break;
                default:
                    break;
            }
        }
        return $this;
    }

    function AddUserToMenu($menuId, $userId)
    {

        $query = "insert into user_menu
                    values (?, ?);";
        $stmt = $this->makeStatement($query, array($menuId, $userId));
    }

    function RemoveUserFromMenu($menuId, $userId)
    {
        $query = "delete from user_menu
                    where menu_id = ? and user_id = ?";
        $stmt = $this->makeStatement($query, array($menuId, $userId));
    }
}