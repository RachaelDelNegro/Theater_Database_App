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
            || $this->input["command"] == "logout"
            || $this->input["command"] == "props"
            || $this->input["command"] == "addprop"
            || $this->input["command"] == "costumes"
            || $this->input["command"] == "sets"
            || $this->input["command"] == "addset"
            || $this->input["command"] == "addcostume"
            || $this->input["command"] == "characters"
            || $this->input["command"] == "castlist"
            || $this->input["command"] == "rehearsal"
            || $this->input["command"] == "crewlist"
            || $this->input["command"] == "assigncrewtask"
            || $this->input["command"] == "deletecrewtask"
            || isset($_SESSION["username"])
        )) {
            $command = $this->input["command"];
        }

        // if (isset($_GET["search"])) {
        //     $command = "search";
        // }

        
        switch($command) {
            case "login":
                $this->login();
                break;

            case "logout":
                $this->logout();
                break;

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

            case "props":
                $this->showProps();
                break;

            case "addprop":
                $this->addProp();
                break;

            case "costumes":
                $this->showCostumes();
                break;

            case "sets":
                $this->showSets();
                break;
            
            case "addset":
                $this->addSet();
                break;

            case "addcostume":
                $this->addcostume();
                break;

            case "characters":
                $this->showCharacters();
                break;

            case "castlist":
                $this->showCastList();
                break;

            case "rehearsal":
                $this->showRehearsal();
                break;

            case "crewlist":
                $this->showCrewList();
                break;

            case "assigncrewtask":
                $this->assignCrewTask();
                break;

            case "deletecrewtask":
                $this->deleteCrewTask();
                break;

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


    public function showAddShow($message="") {
        include "addshow.php";
    }

    public function showShowPage() {
        $show_id = $_GET["show_id"];

        // Get show info
        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        //Get user perms
        $stmt = $this->db->prepare("SELECT perms FROM user_shows WHERE show_id = ? AND user_id = ?");
        $stmt->execute([$show_id, $_SESSION["userid"]]);
        $perm = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_array($perm)) {
            $_SESSION['perms'] = $perm['perms'];
        } else {
            $_SESSION['perms'] = "none";
        }

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
            $stmt = $this->db->prepare("
            INSERT INTO crew_members (user_id)
            VALUES (?)
            ");
            $stmt->execute([$user_id]);
            header("Location: index.php?command=crewpage&show_id={$safe_show_id}");
        } elseif ($role === "director") {
            $stmt = $this->db->prepare("
            INSERT INTO directors (user_id, show_id)
            VALUES (?, ?)
            ");
            $stmt->execute([$user_id, $show_id]);
            header("Location: index.php?command=directorpage&show_id={$safe_show_id}");
        }

        exit();
    }

    public function showProps() {
        $show_id = $_GET["show_id"];
        $search = $_GET["search"] ?? "";

        if ($search) {
            $stmt = $this->db->prepare("
                SELECT * FROM props
                WHERE show_id = ? AND item_name LIKE ?
                ORDER BY prop_id
            ");
            $stmt->execute([$show_id, "%" . $search . "%"]);
        } else {
            $stmt = $this->db->prepare("
                SELECT * FROM props
                WHERE show_id = ?
                ORDER BY prop_id
            ");
            $stmt->execute([$show_id]);
        }

        $props = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "props.php";
    }

    public function addProp() {
        $show_id = $_POST["show_id"];
        $item_name = $_POST["item_name"];

        $stmt = $this->db->prepare("
            INSERT INTO props (show_id, item_name)
            VALUES (?, ?)
        ");
        $stmt->execute([$show_id, $item_name]);

        header("Location: index.php?command=props&show_id=" . urlencode($show_id));
        exit();
    }

    public function showSets() {
        $show_id = $_GET["show_id"];
        $search = $_GET["search"] ?? "";

        if ($search) {
            $stmt = $this->db->prepare("
                SELECT * FROM sets
                WHERE show_id = ? 
                AND (set_item_name LIKE ? OR material LIKE ?)
                ORDER BY set_id
            ");
            $stmt->execute([$show_id, "%" . $search . "%", "%" . $search . "%"]);
        } else {
            $stmt = $this->db->prepare("
                SELECT * FROM sets
                WHERE show_id = ?
                ORDER BY set_id
            ");
            $stmt->execute([$show_id]);
        }

        $sets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "sets.php";
    }

    public function addSet() {
        $show_id = $_POST["show_id"];
        $set_item_name = $_POST["set_item_name"];
        $material = $_POST["material"] ?? "";

        $stmt = $this->db->prepare("
            INSERT INTO sets (show_id, set_item_name, material)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$show_id, $set_item_name, $material]);

        header("Location: index.php?command=sets&show_id=" . urlencode($show_id));
        exit();
    }

    public function showCostumes() {
        $show_id = $_GET["show_id"];
        $search = $_GET["search"] ?? "";

        if ($search) {
            $stmt = $this->db->prepare("
                SELECT * FROM costumes
                WHERE show_id = ?
                AND (
                    costume_name LIKE ?
                    OR clothing_color LIKE ?
                    OR size LIKE ?
                )
                ORDER BY costume_id
            ");
            $like = "%" . $search . "%";
            $stmt->execute([$show_id, $like, $like, $like]);
        } else {
            $stmt = $this->db->prepare("
                SELECT * FROM costumes
                WHERE show_id = ?
                ORDER BY costume_id
            ");
            $stmt->execute([$show_id]);
        }

        $costumes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        include "costumes.php";
    }

    public function addCostume() {
        $show_id = $_POST["show_id"];
        $costume_name = $_POST["costume_name"];
        $clothing_color = $_POST["clothing_color"] ?? "";
        $character_id = $_POST["character_id"] ?: null;
        $size = $_POST["size"] ?? "";

        $stmt = $this->db->prepare("
            INSERT INTO costumes 
            (show_id, costume_name, clothing_color, character_id, size)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $show_id,
            $costume_name,
            $clothing_color,
            $character_id,
            $size
        ]);

        header("Location: index.php?command=costumes&show_id=" . urlencode($show_id));
        exit();
    }

    public function showActorPage() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        $characters = $this->getCharactersForShow($show_id);
        $castList = $this->getCastList($show_id);

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
                $_SESSION["userid"] = $results[0]["user_id"];
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

    public function getPropsForShow($showid) {
        $stmt = $this->db->prepare("SELECT * FROM props WHERE show_id = ?");

        $stmt->execute([$showid]);
        $props = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $props;
    }

    public function getSetsForShow($showid) {
        $stmt = $this->db->prepare("SELECT * FROM sets WHERE show_id = ?");
        $stmt->execute([$showid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCostumesForShow($showid) {
        $stmt = $this->db->prepare("SELECT * FROM costumes WHERE show_id = ?");
        $stmt->execute([$showid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCastList($showid) {
        $stmt = $this->db->prepare("
            SELECT 
                users.user_id,
                users.username,
                characters.character_id,
                characters.character_name,
                characters.main_side
            FROM actors
            JOIN users 
                ON actors.user_id = users.user_id
            JOIN characters 
                ON actors.character_id = characters.character_id
            WHERE characters.show_id = ?
            ORDER BY characters.character_name
        ");

        $stmt->execute([$showid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCharactersForShow($showid) {
        $stmt = $this->db->prepare("SELECT * FROM characters WHERE show_id = ?");

        $stmt->execute([$showid]);
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $characters;
    }

    public function getRehearsalScheduleForIndividual($showid) {
        $stmt = $this->db->prepare("
            SELECT *
            FROM events NATURAL JOIN event_calls
            WHERE show_id = ? AND user_id = ?
            ORDER BY event_date, event_time
        ");
        $stmt->execute([$showid, $_SESSION["userid"]]);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $events;
    }

    public function showCharacters() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        $characters = $this->getCharactersForShow($show_id);

        include "characters.php";
    }

    public function showCastList() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        $castList = $this->getCastList($show_id);

        include "castlist.php";
    }

    public function showCrewList() {
        $show_id = $_GET["show_id"];

        $stmt = $this->db->prepare("SELECT * FROM shows WHERE show_id = ?");
        $stmt->execute([$show_id]);
        $show = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT 
                users.user_id,
                users.username,
                crew_tasks.task
            FROM crew_members
            JOIN users 
                ON crew_members.user_id = users.user_id
            LEFT JOIN crew_tasks 
                ON crew_members.user_id = crew_tasks.user_id
            JOIN user_shows
                ON users.user_id = user_shows.user_id
            WHERE user_shows.show_id = ?
            AND user_shows.perms = 'crew'
            ORDER BY users.username, crew_tasks.task
        ");
        $stmt->execute([$show_id]);
        $crewList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "crewlist.php";
    }

    public function assignCrewTask() {
        $show_id = $_POST["show_id"];
        $user_id = $_POST["user_id"];
        $task = $_POST["task"];

        $stmt = $this->db->prepare("
            INSERT INTO crew_tasks (user_id, task)
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE task = VALUES(task)
        ");

        $stmt->execute([$user_id, $task]);

        header("Location: index.php?command=crewlist&show_id=" . urlencode($show_id));
        exit();
    }

    public function deleteCrewTask() {
        $show_id = $_POST["show_id"];
        $user_id = $_POST["user_id"];

        $stmt = $this->db->prepare("
            DELETE FROM crew_tasks 
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);

        header("Location: index.php?command=crewlist&show_id=" . urlencode($show_id));
        exit();
    }


}
