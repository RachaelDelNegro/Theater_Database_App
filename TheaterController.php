<?php
class TheaterController {

    private $db;

    public function __construct($input) {

        session_start();

        $this->db = new Database();

        $this->input = $input;
    }

    public function run() {
        $command = "welcome";

        if (isset($this->input["command"]) && (
            $this->input["command"] == "login"
             || $this->input["command"] == "signup"
             || $this->input["command"] == "create_user"
             || (isset($_SESSION["username"])))) {
                $command = $this->input["command"];
            }

        if (isset($_GET["search"])) {
            $command = "search";
        }

        
        switch($command) {
            case "login":
                $this->login();
                break;
            case "logout":
                $this->logout();
                break;
            case "homepage":
                $this->showHomepage();
                break;
            case "profile":
                $this->showProfile();
                break;
            case "search":
                $this->search();
                break;
            case "addshow":
                $this->showAddShow();
                break;
            case "showpage":
                $this->getShowInfo();
                break;
            case "signup":
                $this->showSignUp();
                break;
            case "create_user":
                $this->createUser();
                return;
            case "deleteuser":
                $this->deleteUser();
                break;
            case "createshow":
                $this->addShow();
                break;
            case "review":
                $this->leaveReview();
                break;
            case "showpagereviewed":
                $this->showShowPage();
                break;
            default:
                $this->showWelcome();
                break;
        }
    }

    public function showWelcome($message="") {
        include "insert file name here";
    }

    public function showSignUp($message="") {
        include "/students/jvg2hc/students/jvg2hc//private/project/templates/signup.php";
    }

    public function showHomepage() {
        $shows = $this->db->query("select * from project_shows");

        $array_string = $this->displayShows($shows);

        include "/students/jvg2hc/students/jvg2hc//private/project/templates/homepage.php";
    }

    public function showSearch($array_string_search) {
        $array_string = $array_string_search;

        include "/students/jvg2hc/students/jvg2hc//private/project/templates/homepage.php";
    }

    public function showProfile() {
        $username = $_SESSION["username"];

        $reviews = $this->db->query("select * from project_reviews where username = $1", $username);

        $array_string = $this->displayReviewsProfilePage($reviews);

        include "/students/jvg2hc/students/jvg2hc//private/project/templates/profile.php";
    }

    public function showAddShow($message="") {

        include "/students/jvg2hc/students/jvg2hc//private/project/templates/addshow.php";
    }

    public function showShowPage() {
        $name = $_SESSION["name"];
        $description = $_SESSION["description"];
        $thumbnail = $_SESSION["thumbnail"];

        $reviews = $this->db->query("select * from project_reviews where showname = $1", $name);

        $rating = $this->getAvgRating($reviews);

        $array_string = $this->displayReviewsShowPage($reviews);

        include "/students/jvg2hc/students/jvg2hc//private/project/templates/show.php";
    }

    public function login() {
        $results = $this->db->query("select * from users where username = $1;", $_POST["username"]);

        if (empty($results)) {
            $this->showWelcome("<div class='alert alert-warning' style='margin-top: 2%'> Account does not exist! </div>");
            return;
        } else {
            $hashed_password = $results[0]["password"];
            $correct = password_verify($_POST["password"], $hashed_password);

            if ($correct) {
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["user_role"] = $_POST["user_role"];

                header("Location: ?command=homepage");
                return;
            } else {
                $this->showWelcome("<div class='alert alert-danger' style='margin-top: 2%'> Incorrect Password </div>");
                return;
            }
        }
    }

    public function logout() {
        session_destroy();

        session_start();

        header("Location: ?command=welcome");
        return;
    }


    public function createUser() {
        $results = $this->db->query("select * from users where username = $1;", $_POST["usernameCreate"]);

        if (!empty($results)) {

            $this->showSignUp("<div class='alert alert-danger' style='margin-top: 2%'> User already exists! </div>");
            return;
        } else {

            $password_valid = $this->checkPassword($_POST["passwordCreate"]);

            if ($password_valid) {
                $result = $this->db->query("insert into users (username, password, user_role)
                values ($1, $2, $3);",
                $_POST["usernameCreate"], password_hash($_POST["passwordCreate"], PASSWORD_DEFAULT), $_POST["userRoleCreate"]);

                $this->showWelcome("<div class='alert alert-success' style='margin-top: 2%'> User created successfully! </div>");
                return;
            } else {

                $this->showSignUp("<div class='alert alert-danger' style='margin-top: 2%'> Password must be between 5 and 16 characters, 
                and contain at least one special character (!@#$%&) </div>");
                return;
            }
        }
    }

    public function checkPassword($password) {
        if (strlen($password) < 5 || strlen($password) > 16) {
            return false;
        }

        $pattern = "/[a-zA-z0-9!@#$%]*[!$%&@#]+[a-zA-z0-9!@#$%]*/"; 
        return preg_match($pattern, $password);
    }

    public function deleteUser() {

        $results = $this->db->query("delete from users where username=$1", $_SESSION["username"]);

        $this->logout();
    }

    public function getShows() {
        $shows = $this->db->query("select * from shows");

        return $shows;
    }

    public function getPropsForShow() {
        $props = $this->db->query("select * from props where show_id=$1", $_SESSION["show_id"]);

        return $props;
    }

    public function getSetsForShow() {
        $sets = $this->db->query("select * from sets where show_id=$1", $_SESSION["show_id"]);

        return $sets;
    }

    public function getCostumesForShow() {
        $costumes = $this->db->query("select * from costumes where show_id=$1", $_SESSION["show_id"]);

        return $costumes;
    }

    


    public function search() {
        if (empty($_GET["search"])) {
            $this->showHomepage();
            return;
        } else {
            $search_key = htmlspecialchars($_GET["search"]);
            $result = $this->db->query("select * from project_shows where lower(name) like lower($1)", "%" . $search_key . "%");
    
            $array_string = $this->displayShows($result);
    
            $this->showSearch($array_string);
        }

    }


    public function displayShows($shows) {
        $array_string = "";
        foreach ($shows as $show) {
            $array_string = $array_string . "<div class='card col-3' id='" . $show["showid"] . "'>
                    <form method='post' action='?command=showpage'>
                        <input type='hidden' name='showid' value='" . $show["showid"] . "'>
                        <button type='submit' method='post'>
                            <img class='card-img-top' src='" . $show["thumbnail"] . "' alt='" . $show["name"] . " Poster' style='width: 100%;'>
                        </button>
                    </form>
                    <div class='card-body' id='" . $show["showid"] . "s'>
                      <h3 class='card-title'>" . $show["name"] ."</h3>
                      <p class='card-text'>" . $show["network"] . "</p>
                    </div>
                </div> \n";
        }

        return $array_string;
    }
}