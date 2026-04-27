<?php
class TheaterController {

    private $db;
    private $input;

    public function __construct($input) {

        session_start();

        require_once "config.php";
        $this->db = $db;

        $this->input = $input;
    }

    public function run() {
        $command = "welcome";

        if (isset($this->input["command"]) && (
            $this->input["command"] == "login"
            || $this->input["command"] == "signup"
            || $this->input["command"] == "create_user"
            || $this->input["command"] == "addshow"
            || $this->input["command"] == "createshow"
            || $this->input["command"] == "showlist"
            || $this->input["command"] == "selectgroup"
            || $this->input["command"] == "showpage"
            || $this->input["command"] == "actorpage"
            || $this->input["command"] == "crewpage"
            || $this->input["command"] == "directorpage"
            || isset($_SESSION["username"])
        )) {
            $command = $this->input["command"];
        }

        if (isset($_GET["search"])) {
            $command = "search";
        }

        
        switch($command) {
            case "login":
                $this->login();
                break;
            // case "logout":
            //     $this->logout();
            //     break;
            // case "homepage":
            //     $this->showHomepage();
            //     break;
            // case "profile":
            //     $this->showProfile();
            //     break;
            // case "search":
            //     $this->search();
            //     break;
            case "actorpage":
                $this->showActorPage();
                break;

            case "crewpage":
                $this->showCrewPage();
                break;

            case "directorpage":
                $this->showDirectorPage();
                break;
            case "addshow":
                $this->showAddShow();
                break;
            case "showpage":
                $this->showShowPage();
                break;
            case "signup":
                $this->showSignUp();
                break;
            case "create_user":
                $this->createUser();
                return;
            case "selectgroup":
                $this->addRole();
                break;
            case "createshow":
                $this->addShow();
                break;
            case "showlist":
                $this->showList();
                break;
            // case "review":
            //     $this->leaveReview();
            //     break;
            // case "showpagereviewed":
            //     $this->showShowPage();
            //     break;
            default:
                $this->showWelcome();
                break;
        }
    }

    public function showWelcome($message="") {
        include "login.php";
    }

    public function showSignUp($message="") {
        include "signup.php";
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
        include "addshow.php";
    }

    public function showShowPage() {
        $show_id = $_GET["show_id"];

        // Get show info
        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get users who joined this show
        $stmt = $this->db->prepare("
            SELECT users.username, user_shows.perms
            FROM user_shows
            JOIN users ON user_shows.user_id = users.user_id
            WHERE user_shows.show_id = ?
        ");
        $stmt->execute([$show_id]);
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get directors
        $stmt = $this->db->prepare("
            SELECT users.username, user_shows.perms
            FROM user_shows
            JOIN users ON user_shows.user_id = users.user_id
            WHERE user_shows.show_id = ? AND user_shows.perms = 'director'
        ");
        $stmt->execute([$show_id]);
        $directors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get rehearsal schedule
        $stmt = $this->db->prepare("
            SELECT *
            FROM events
            WHERE show_id = ?
            ORDER BY event_date, event_time
        ");
        $stmt->execute([$show_id]);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "showpage.php";
    }

    public function addShow() {
        $stmt = $this->db->prepare("
            INSERT INTO shows 
            (title, screen_writer, setting_description, theme)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST["title"],
            $_POST["screen_writer"],
            $_POST["setting_description"],
            $_POST["theme"]
        ]);

        header("Location: index.php?command=showlist");
        exit();
    }

    public function showList() {
        $stmt = $this->db->query("SELECT * FROM shows");
        $shows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "showlist.php";
    }

    public function addRole() {
        if (!isset($_SESSION["username"])) {
            header("Location: index.php?command=welcome");
            exit();
        }

        $role = $_POST["role"] ?? null;
        $show_id = $_POST["show_id"] ?? null;

        $allowed_roles = ["actor", "crew", "director"];

        if (!$role || !$show_id || !in_array($role, $allowed_roles)) {
            die("Invalid role or show selected.");
        }

        // Get current user id
        $stmt = $this->db->prepare("
            SELECT user_id 
            FROM users 
            WHERE username = ?
        ");
        $stmt->execute([$_SESSION["username"]]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("User not found.");
        }

        $user_id = $user["user_id"];

        // Check if user is already in this show
        $stmt = $this->db->prepare("
            SELECT perms 
            FROM user_shows 
            WHERE user_id = ? AND show_id = ?
        ");
        $stmt->execute([$user_id, $show_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $existing_role = htmlspecialchars($existing["perms"]);
            $safe_show_id = urlencode($show_id);

            echo "<script>
                alert('You are already in this show as {$existing_role}');
                window.location.href = 'index.php?command=showpage&show_id={$safe_show_id}';
            </script>";
            exit();
        }

        // Add user to this show with their selected role
        $stmt = $this->db->prepare("
            INSERT INTO user_shows (user_id, show_id, perms)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$user_id, $show_id, $role]);

        $_SESSION["perms"] = $role;
        $_SESSION["show_id"] = $show_id;

        $safe_show_id = urlencode($show_id);

        if ($role === "actor") {
            header("Location: index.php?command=actorpage&show_id={$safe_show_id}");
        } elseif ($role === "crew") {
            header("Location: index.php?command=crewpage&show_id={$safe_show_id}");
        } elseif ($role === "director") {
            header("Location: index.php?command=directorpage&show_id={$safe_show_id}");
        }

        exit();
    }

    public function showActorPage() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "show_actor_landing_page.php";
    }

    public function showCrewPage() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "show_crew_landing_page.php";
    }

    public function showDirectorPage() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "show_director_landing_page.php";
    }

    public function login() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_POST["username"]]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            $this->showWelcome("<div class='alert alert-warning' style='margin-top: 2%'> Account does not exist! </div>");
            return;
        } else {
            $hashed_password = $results[0]["password_hash"];
            $correct = password_verify($_POST["password"], $hashed_password);

            if ($correct) {
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["user_role"] = $results[0]["user_role"];

                header("Location: ?command=showlist");
                exit();
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
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_POST["username"]]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {

            $this->showSignUp("<div class='alert alert-danger' style='margin-top: 2%'> User already exists! </div>");
            return;
        } else {

            $password_valid = $this->checkPassword($_POST["password"]);

            if ($password_valid) {
                $stmt = $this->db->prepare("
                INSERT INTO users (username, password_hash, user_role)
                VALUES (?, ?, ?)
            ");

            $stmt->execute([
                $_POST["username"],
                password_hash($_POST["password"], PASSWORD_DEFAULT),
                "actor"  // default role for now
            ]);

                header("Location: ?command=showlist");
                exit();
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

        $pattern = "/[a-zA-z0-9]*/"; 
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

    public function getEventsForShow() {
        $events = $this->db->query("select * from events where show_id=$1", $_SESSION["show_id"]);

        return $events;
    }

    public function getUsersForShow() {
        $users = $this->db->query("select username, user_role from user_shows natural join users where show_id=$1", $_SESSION["show_id"]);

        return $users;
    }

    public function getCharactersForShow() {
        $characters = $this->db->query("select * from characters where show_id=$1", $_SESSION["show_id"]);

        return $characters;
    }

    public function getActorRoleForShow() {
        $actorRoles = $this->db->query("select * from users natural join actors natural join characters where show_id=$1", $_SESSION["show_id"]);
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
