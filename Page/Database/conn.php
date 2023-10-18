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
            /*
            $servername = "127.0.0.1";
            $username = "root";
            $password = "admin";
            $schema = "dag";
            */
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

    function UpdateUser($user_id, $svnr, $firstname, $lastname, $password, $password_change, $roleId)
    {
        try {
            if ($password_change) {
                $query = "update user 
                            set firstname = ?, 
                                lastName = ?, 
                                pw = ?,
                                role_id = ?,
                                svnr = ?
                            where user_id = ?;";
                $arr = array($firstname, $lastname, password_hash($password, PASSWORD_DEFAULT), $roleId, $svnr, $user_id);
                $stmt = $this->makeStatement($query, $arr);

                return true;
            }
            else {
                $query = "update user 
                            set firstname = ?, 
                                lastName = ?, 
                                role_id = ?,
                                svnr = ?
                            where user_id = ?;";
                $arr = array($firstname, $lastname, $roleId, $svnr, $user_id);
                $stmt = $this->makeStatement($query, $arr);

                return true;
            }
            
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function VerifyUser($user_id, $password, $roleId)
    {
        try {
            $query = "update user set
                            pw = ?,
                            role_id = ?
                        where user_id = ?;";
            $arr = array(password_hash($password, PASSWORD_DEFAULT), $roleId, $user_id);
            $stmt = $this->makeStatement($query, $arr);

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function DeleteUser($user_id)
    {
        try {
            $query = "delete from user_menu where user_id = ?;";
            $arr = array($user_id);
            $stmt = $this->makeStatement($query, $arr);

            $query1 = "delete from user where user_id = ?;";
            $arr1 = array($user_id);
            $stmt = $this->makeStatement($query1, $arr1);

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function GetAllUsers()
    {
        try {
            $query = "select user_id, firstname, lastname, svnr, `name` `role`, role_id from user inner join role using(role_id)";
            $stmt = $this->makeStatement($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
        }
    }

    function CheckLogin($svnr, $password)
    {

        $query = "select u.user_id, u.pw, r.name 
                    from user u left join role r using (role_id)
                    where svnr = ?";
        $stmt = $this->makeStatement($query, array($svnr));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        /* If there is a result, check if the password matches using password_verify(). */
        if (is_array($result)) {
            if (password_verify($password, $result['pw'])) {
                /* The password is correct. */
                if (isset($result["name"]) and $result["name"] != "") {
                    $_SESSION['login_failed'] = 'no';
                    return array(
                        "name" => $result["name"],
                        "userid" => $result["user_id"]
                    );
                }
                else { $_SESSION['login_failed'] = 'yes'; }
            }
        }
        $_SESSION['login_failed'] = 'yes';
        return "webuser";
    }
    function GetUserNameById($userid)
    {

        $query = "select concat(firstname, ' ', lastname) name 
                    from user 
                    where user_id = ?";
        $stmt = $this->makeStatement($query, array($userid));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        /* If there is a result, check if the password matches using password_verify(). */
        if (is_array($result)) {
            return $result["name"];
        }
        return "None";
    }

    function GetUserMenu($userid, $tod, $date)
    {

        $query = "select mv.*, time, user_id from user_menu 
                    join menu_v mv using (menu_id)
                    join meal m using (meal_id)
                    where user_id = ?
                    and m.tod_id = ?
                    and day = ?;";
        $stmt = $this->makeStatement($query, array($userid, $tod, $date));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) != 0) {
            if (is_null($result[0]["time"])) {
                $query = 'update user_menu set time = current_time()
                            where user_id = ?
                            and menu_id in (select menu_id from menu_v
                                                where tod_id = ?
                                                and day = ?);';
                $stmt = $this->makeStatement($query, array($userid, $tod, $date));
            }
        }
        return $result;
    }
    function GetAllRoles()
    {
        try {
            $query = "select role_id, name from role";
            $stmt = $this->makeStatement($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
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
    function UpdateFood($food_id, $food_name, $mealArr)
    {
        try {
            $query = "update food set name = ? where food_id = ?";
            $arr = array($food_name, $food_id);
            $stmt = $this->makeStatement($query, $arr);

            $query1 = "delete from food_meal where food_id = ?;";
            $arr1 = array($food_id);
            $stmt = $this->makeStatement($query1, $arr1);

            foreach ($mealArr as $meal) {
                $query2 = "insert into food_meal(food_id, meal_id) values (?, ?)";
                $arr2 = array($food_id, $meal);
                $stmt = $this->makeStatement($query2, $arr2);
            }

            return true;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
            return false;
        }
    }

    function DeleteFood($food_id)
    {
        try {
            $query = "delete from food_meal where food_id = ?;";
            $arr = array($food_id);
            $stmt = $this->makeStatement($query, $arr);

            $query1 = "delete from food where food_id = ?;";
            $arr1 = array($food_id);
            $stmt = $this->makeStatement($query1, $arr1);

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
            $query =
                "select food_id, `name`, trim(group_concat(' ', `type`)) menu_names, (" .
                " select trim(group_concat(' ', `meal_id`))" .
                " from food_meal" .
                " where food_id = fm.food_id" .
                " group by food_id" .
                " ) as meal_ids" .
                " from food" .
                " inner join food_meal fm using(food_id)" .
                " inner join meal using(meal_id)" .
                " inner join time_of_day using(tod_id)" .
                " where tod_id = ?" .
                " group by food_id" .
                " order by food_id";


            $arr = array($timeOfDay);
            $stmt = $this->makeStatement($query, $arr);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
        }
    }
    function GetAllMeals()
    {
        try {
            $query = "select meal_id, type from meal";
            $stmt = $this->makeStatement($query);
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

    function RemoveUserFromMenuByDelete($menuId)
    {
        $query = "delete from user_menu
                    where menu_id = ?";
        $stmt = $this->makeStatement($query, array($menuId));
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

        $query = "select *, (select user_id from user_menu 
                                where menu_id = mv.menu_id 
                                and user_id = ?) user_id
                        from menu_v mv
                        where day = ?;";
        $stmt = $this->makeStatement($query, array($userId, date('Y-m-d', $date)));
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

        $query = "select mv.*, count(user_id) amount
                    from menu_v mv left join user_menu um using (menu_id)
                    where day = ?
                    group by menu_id
                    order by meal_id;";
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

        $query = "insert into user_menu(menu_id, user_id)
                    values (?, ?);";
        $stmt = $this->makeStatement($query, array($menuId, $userId));
    }

    function RemoveUserFromMenu($menuId, $userId)
    {
        $query = "delete from user_menu
                    where menu_id = ? and user_id = ?";
        $stmt = $this->makeStatement($query, array($menuId, $userId));
    }
    function GetMenuForWeek()
    {
        try {
            $query = "select mv.food_id, mv.name, mv.meal_id, mv.type, date_format(mv.day, '%d.%m.%Y') `day`, mv.day_name, count(user_id) amount
                        from menu_v mv 
                        left join user_menu um using (menu_id)
                        where day between current_date() and current_date()+7
                        group by menu_id
                        order by `day`, meal_id;";

            $stmt = $this->makeStatement($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo 'Fehler - ' . $e->getCode() . ': ' . $e->getMessage() . '<br>';
        }
    }
}