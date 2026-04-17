DROP TABLE IF EXISTS event_calls;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS crew_tasks;
DROP TABLE IF EXISTS crew_members;
DROP TABLE IF EXISTS costumes;
DROP TABLE IF EXISTS props;
DROP TABLE IF EXISTS sets;
DROP TABLE IF EXISTS actors;
DROP TABLE IF EXISTS directors;
DROP TABLE IF EXISTS user_shows;
DROP TABLE IF EXISTS characters;
DROP TABLE IF EXISTS shows;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_role ENUM('actor', 'director', 'crew') NOT NULL
);

CREATE TABLE shows (
    show_id INT PRIMARY KEY,
    title VARCHAR(300) NOT NULL,
    screen_writer VARCHAR(100) NOT NULL,
    setting_description VARCHAR(100) NOT NULL,
    theme VARCHAR(100) NOT NULL
);

CREATE TABLE characters (
    character_id INT PRIMARY KEY,
    show_id INT NOT NULL,
    character_name VARCHAR(300) NOT NULL,
    main_side VARCHAR(100) NOT NULL,
    CONSTRAINT fk_characters_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT uq_character_show_name UNIQUE (show_id, character_name)
);

CREATE TABLE user_shows (
    user_id INT NOT NULL,
    show_id INT NOT NULL,
    PRIMARY KEY (user_id, show_id),
    CONSTRAINT fk_user_shows_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_shows_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE directors (
    user_id INT NOT NULL,
    show_id INT NOT NULL,
    PRIMARY KEY (show_id),
    CONSTRAINT fk_directors_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_directors_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE actors (
    user_id INT NOT NULL,
    character_id INT NOT NULL,
    PRIMARY KEY (user_id, character_id),
    CONSTRAINT fk_actors_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_actors_character
        FOREIGN KEY (character_id) REFERENCES characters(character_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE props (
    prop_id INT NOT NULL,
    show_id INT NOT NULL,
    item_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (prop_id),
    CONSTRAINT uq_props_show_item UNIQUE (show_id, item_name),
    CONSTRAINT fk_props_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE sets (
    set_id INT NOT NULL,
    show_id INT NOT NULL,
    set_item_name VARCHAR(50) NOT NULL,
    material VARCHAR(50) NOT NULL,
    PRIMARY KEY (set_id),
    CONSTRAINT uq_sets_show_item UNIQUE (show_id, set_item_name),
    CONSTRAINT fk_sets_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE crew_members (
    user_id INT NOT NULL PRIMARY KEY,
    CONSTRAINT fk_crew_members_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE crew_tasks (
    user_id INT NOT NULL,
    task VARCHAR(100) NOT NULL,
    PRIMARY KEY (user_id, task),
    CONSTRAINT fk_crew_tasks_member
        FOREIGN KEY (user_id) REFERENCES crew_members(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE costumes (
    costume_id INT NOT NULL PRIMARY KEY,
    costume_name VARCHAR(300) NOT NULL,
    clothing_color VARCHAR(100) NOT NULL,
    character_id INT NOT NULL,
    size VARCHAR(100) NOT NULL,
    CONSTRAINT fk_costumes_character
        FOREIGN KEY (character_id) REFERENCES characters(character_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE events (
    event_id INT NOT NULL PRIMARY KEY,
    show_id INT NOT NULL,
    event_title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    CONSTRAINT fk_events_show
        FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE event_calls (
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (event_id, user_id),
    CONSTRAINT fk_event_calls_event
        FOREIGN KEY (event_id) REFERENCES events(event_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_calls_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO shows (show_id, title, screen_writer, setting_description, theme) VALUES
(1, 'Wicked', 'Winnie Holzman', 'The Land of Oz', 'Musical Fantasy');

INSERT INTO users (user_id, username, password_hash, user_role) VALUES
(1, 'idina_menzel', 'hashed_password_demo', 'actor'),
(2, 'user_alpha01', 'hashed_password_demo', 'actor'),
(3, 'director_beta', 'hashed_password_demo', 'director'),
(4, 'crew_gamma22', 'hashed_password_demo', 'crew'),
(5, 'actor_delta', 'hashed_password_demo', 'actor'),
(6, 'dir_echo77', 'hashed_password_demo', 'director'),
(7, 'crew_foxtrot', 'hashed_password_demo', 'crew'),
(8, 'actor_golf', 'hashed_password_demo', 'actor'),
(9, 'director_hotel', 'hashed_password_demo', 'director'),
(10, 'crew_india', 'hashed_password_demo', 'crew'),
(11, 'actor_juliet', 'hashed_password_demo', 'actor'),
(12, 'director_kilo', 'hashed_password_demo', 'director'),
(13, 'crew_lima', 'hashed_password_demo', 'crew'),
(14, 'actor_mike', 'hashed_password_demo', 'actor'),
(15, 'director_november', 'hashed_password_demo', 'director'),
(16, 'crew_oscar', 'hashed_password_demo', 'crew'),
(17, 'actor_papa', 'hashed_password_demo', 'actor'),
(18, 'director_quebec', 'hashed_password_demo', 'director'),
(19, 'crew_romeo', 'hashed_password_demo', 'crew'),
(20, 'actor_sierra', 'hashed_password_demo', 'actor'),
(21, 'director_tango', 'hashed_password_demo', 'director'),
(22, 'actor_uniform01', 'hashed_password_demo', 'actor'),
(23, 'crew_vector02', 'hashed_password_demo', 'crew'),
(24, 'actor_whiskey03', 'hashed_password_demo', 'actor'),
(25, 'crew_xray04', 'hashed_password_demo', 'crew'),
(26, 'actor_yankee05', 'hashed_password_demo', 'actor'),
(27, 'crew_zulu06', 'hashed_password_demo', 'crew'),
(28, 'actor_alpha07', 'hashed_password_demo', 'actor'),
(29, 'crew_bravo08', 'hashed_password_demo', 'crew'),
(30, 'actor_charlie09', 'hashed_password_demo', 'actor'),
(31, 'crew_delta10', 'hashed_password_demo', 'crew'),
(32, 'actor_echo11', 'hashed_password_demo', 'actor'),
(33, 'crew_foxtrot12', 'hashed_password_demo', 'crew'),
(34, 'actor_golf13', 'hashed_password_demo', 'actor'),
(35, 'crew_hotel14', 'hashed_password_demo', 'crew'),
(36, 'actor_india15', 'hashed_password_demo', 'actor'),
(37, 'crew_juliet16', 'hashed_password_demo', 'crew'),
(38, 'actor_kilo17', 'hashed_password_demo', 'actor'),
(39, 'crew_lima18', 'hashed_password_demo', 'crew'),
(40, 'actor_mike19', 'hashed_password_demo', 'actor'),
(41, 'crew_november20', 'hashed_password_demo', 'crew'),
(42, 'actor_oscar21', 'hashed_password_demo', 'actor'),
(43, 'crew_papa22', 'hashed_password_demo', 'crew'),
(44, 'actor_quebec23', 'hashed_password_demo', 'actor'),
(45, 'crew_romeo24', 'hashed_password_demo', 'crew'),
(46, 'actor_sierra25', 'hashed_password_demo', 'actor'),
(47, 'crew_tango26', 'hashed_password_demo', 'crew'),
(48, 'actor_upsilon27', 'hashed_password_demo', 'actor'),
(49, 'crew_phi28', 'hashed_password_demo', 'crew'),
(50, 'actor_chi29', 'hashed_password_demo', 'actor'),
(51, 'crew_psi30', 'hashed_password_demo', 'crew'),
(52, 'actor_ember31', 'hashed_password_demo', 'actor'),
(53, 'crew_forge32', 'hashed_password_demo', 'crew'),
(54, 'actor_glimmer33', 'hashed_password_demo', 'actor'),
(55, 'crew_harbor34', 'hashed_password_demo', 'crew'),
(56, 'actor_ignite35', 'hashed_password_demo', 'actor'),
(57, 'crew_junction36', 'hashed_password_demo', 'crew'),
(58, 'actor_keystone37', 'hashed_password_demo', 'actor'),
(59, 'crew_lantern38', 'hashed_password_demo', 'crew'),
(60, 'actor_mosaic39', 'hashed_password_demo', 'actor'),
(61, 'crew_nexus40', 'hashed_password_demo', 'crew'),
(62, 'actor_orbit41', 'hashed_password_demo', 'actor'),
(63, 'crew_pillar42', 'hashed_password_demo', 'crew'),
(64, 'actor_quartz43', 'hashed_password_demo', 'actor'),
(65, 'crew_ridge44', 'hashed_password_demo', 'crew'),
(66, 'actor_summit45', 'hashed_password_demo', 'actor'),
(67, 'crew_timber46', 'hashed_password_demo', 'crew'),
(68, 'actor_umbra47', 'hashed_password_demo', 'actor'),
(69, 'crew_valley48', 'hashed_password_demo', 'crew'),
(70, 'actor_willow49', 'hashed_password_demo', 'actor'),
(71, 'crew_xenon50', 'hashed_password_demo', 'crew'),
(72, 'actor_yonder51', 'hashed_password_demo', 'actor'),
(73, 'crew_zenith52', 'hashed_password_demo', 'crew'),
(74, 'actor_apex53', 'hashed_password_demo', 'actor'),
(75, 'crew_blaze54', 'hashed_password_demo', 'crew'),
(76, 'actor_cinder55', 'hashed_password_demo', 'actor'),
(77, 'crew_drift56', 'hashed_password_demo', 'crew'),
(78, 'actor_echo57', 'hashed_password_demo', 'actor'),
(79, 'crew_flux58', 'hashed_password_demo', 'crew'),
(80, 'actor_glade59', 'hashed_password_demo', 'actor'),
(81, 'crew_horizon60', 'hashed_password_demo', 'crew');

INSERT INTO user_shows (user_id, show_id)
SELECT user_id, 1 FROM users;

INSERT INTO characters (character_id, show_id, character_name, main_side) VALUES
(46409, 1, 'Elphaba', 'main'),
(29129, 1, 'Glinda', 'main'),
(72656, 1, 'Fiyero', 'side'),
(21657, 1, 'Madame Morrible', 'side'),
(48858, 1, 'Nessarose', 'side'),
(88909, 1, 'Boq', 'side'),
(52170, 1, 'Dr. Dillamond', 'side'),
(34282, 1, 'Elphaba''s Father', 'side'),
(94122, 1, 'Shiz Student #1', 'side'),
(69615, 1, 'Shiz Student #2', 'side'),
(16215, 1, 'Emerald City Citizen #1', 'side'),
(72256, 1, 'Emerald City Citizen #2', 'side');

INSERT INTO actors (user_id, character_id) VALUES
(1, 46409),
(2, 29129),
(5, 29129),
(8, 21657),
(9, 21657),
(11, 46409),
(14, 72656),
(15, 72656),
(17, 48858),
(18, 48858),
(20, 88909),
(22, 88909),
(24, 52170),
(26, 52170),
(28, 34282),
(30, 34282),
(32, 94122),
(34, 94122),
(36, 69615),
(38, 69615),
(40, 16215),
(42, 16215),
(44, 16215),
(46, 16215),
(48, 72256),
(50, 72256),
(52, 72256),
(54, 48858),
(56, 29129),
(58, 52170),
(60, 88909),
(62, 94122),
(64, 34282),
(66, 46409),
(68, 16215),
(70, 16215),
(72, 88909),
(74, 52170),
(76, 21657),
(78, 94122),
(80, 72656);

INSERT INTO directors (user_id, show_id) VALUES
(12, 1);

INSERT INTO crew_members (user_id) VALUES
(4),(7),(10),(13),(16),(19),(23),(25),(27),(29),(31),(33),(35),(37),(39),(41),(43),(45),(47),(49),(51),(53),(55),(57),(59),(61),(63),(65),(67),(69),(71),(73),(75),(77),(79),(81);

INSERT INTO crew_tasks (user_id, task) VALUES
(4, 'scene design'),
(7, 'projection design'),
(10, 'hair and wig design'),
(13, 'scene design'),
(16, 'makeup design'),
(19, 'scene design'),
(23, 'draftsman'),
(25, 'costume design'),
(27, 'costume design'),
(29, 'costume design'),
(31, 'costume design'),
(33, 'costume design'),
(35, 'lighting design'),
(37, 'lighting design'),
(39, 'automated lights'),
(41, 'lighting design'),
(43, 'sound design'),
(45, 'projection design'),
(47, 'projection design'),
(49, 'projection design'),
(51, 'hair and wig design'),
(53, 'special effects'),
(55, 'flying sequences'),
(57, 'special effects'),
(59, 'dance coordinator'),
(61, 'dance coordinator'),
(63, 'fight direction'),
(65, 'music conduction'),
(67, 'music conduction'),
(69, 'concert master'),
(71, 'lighting design'),
(73, 'dance captain'),
(75, 'scene design'),
(77, 'fight direction'),
(79, 'sound design'),
(81, 'sound design');

INSERT INTO props (prop_id, show_id, item_name) VALUES
(1, 1, 'Clock of the Time Dragon'),
(2, 1, 'Dr. Dillamond''s Chalkboard'),
(3, 1, 'Elphaba''s Broom'),
(4, 1, 'Elphaba''s Hat'),
(5, 1, 'Emerald Glasses'),
(6, 1, 'Fiyero''s Letter to Elphaba'),
(7, 1, 'Fiyero''s Rifle'),
(8, 1, 'Glinda''s Wand'),
(9, 1, 'Green Elixir'),
(10, 1, 'Grimmerie'),
(11, 1, 'Magic Slippers'),
(12, 1, 'Nessarose''s Wheelchair'),
(13, 1, 'Witch Hunting Weapon 1'),
(14, 1, 'Witch Hunting Weapon 2'),
(15, 1, 'Witch Hunting Weapon 3');

INSERT INTO sets (set_id, show_id, set_item_name, material) VALUES
(1, 1, 'Shiz University Gate', 'Painted Wood'),
(2, 1, 'Shiz Courtyard Fountain', 'Resin'),
(3, 1, 'Dormitory Interior', 'Wood and Fabric'),
(4, 1, 'Oz Map Backdrop', 'Canvas'),
(5, 1, 'Emerald City Gates', 'Metal and Paint'),
(6, 1, 'Wizard Throne Room', 'Wood and Gold Foil'),
(7, 1, 'Mechanical Dragon Clock', 'Metal'),
(8, 1, 'Time Dragon Platform', 'Steel'),
(9, 1, 'Emerald City Skyline', 'Painted Flats'),
(10, 1, 'Train Platform', 'Wood and Steel'),
(11, 1, 'Forest Scene', 'Foam and Fabric'),
(12, 1, 'Cornfield Backdrop', 'Canvas'),
(13, 1, 'Kiamo Ko Castle Exterior', 'Stone Foam'),
(14, 1, 'Kiamo Ko Interior', 'Wood and Stone'),
(15, 1, 'Flying Harness Rig', 'Steel and Fabric'),
(16, 1, 'Grimmerie Pedestal', 'Wood'),
(17, 1, 'Wizard Machine Console', 'Metal and Lights'),
(18, 1, 'Emerald City Balcony', 'Wood and Paint'),
(19, 1, 'Hot Air Balloon', 'Fabric and Metal'),
(20, 1, 'Underground Tunnel', 'Foam and Wood');

INSERT INTO costumes (costume_id, costume_name, clothing_color, character_id, size) VALUES
(12610, 'Wicked Witch of the East', 'Black', 48858, 'adult small Wm'),
(22222, 'Shiz uniform', 'Dark blue', 48858, 'adult small Wm'),
(22990, 'Shiz Uniform', 'Dark blue', 72656, 'adult medium M'),
(23436, 'Dancing Through Life', 'Red+White', 72656, 'adult medium M'),
(26840, 'Captain of the Guard', 'Green', 72656, 'adult medium M'),
(27011, 'Party Frock', 'Dark blue', 46409, 'adult medium Wm'),
(30053, 'Popular', 'Pink', 29129, 'adult small Wm'),
(41109, 'Shiz uniform', 'Black', 46409, 'adult medium Wm'),
(42900, 'Shiz uniform', 'Light pink', 29129, 'adult small Wm'),
(53445, 'Emerald city', 'Light green', 21657, 'adult medium Wm'),
(62400, 'Shizstris', 'Red', 21657, 'adult medium Wm'),
(66191, 'Dr. Dillamond uniform', 'Orange+Red', 52170, 'adult large M'),
(78709, 'Bubble Dress', 'Pink', 29129, 'adult small Wm'),
(83299, 'Engagement Ballgown', 'White', 29129, 'adult small Wm'),
(89929, 'Servant uniform', 'Light blue', 88909, 'adult small M'),
(97055, 'Thank Goodness', 'Dark Green', 21657, 'adult medium Wm');

INSERT INTO events (event_id, show_id, event_title, event_date, event_time) VALUES
(100, 1, 'Rehearsal', '2026-03-16', '18:00:00'),
(101, 1, 'Full Run', '2026-03-17', '17:00:00'),
(102, 1, 'Rehearsal', '2026-03-18', '18:00:00'),
(103, 1, 'Actor Notes', '2026-03-18', '20:15:00'),
(104, 1, 'Crew Meeting', '2026-03-16', '16:00:00'),
(105, 1, 'Rehearsal', '2026-03-19', '18:00:00'),
(106, 1, 'Rehearsal', '2026-03-20', '18:00:00'),
(107, 1, 'Full Run', '2026-03-21', '17:00:00'),
(108, 1, 'Rehearsal', '2026-03-22', '18:00:00'),
(109, 1, 'Tech Rehearsal', '2026-03-23', '18:30:00'),
(110, 1, 'Dress Rehearsal', '2026-03-24', '19:00:00'),
(111, 1, 'Preview', '2026-03-25', '19:00:00'),
(112, 1, 'Opening Night', '2026-03-26', '20:00:00');

INSERT INTO event_calls (event_id, user_id) VALUES
(101, 12),(101, 13),(101, 14),(101, 15),
(103, 12),(103, 13),
(104, 12),(104, 35),(104, 64),(104, 65),(104, 78),
(105, 12),(105, 13),(105, 19),(105, 35),
(106, 12),(106, 13),(106, 14),(106, 15),
(107, 12),(107, 13),(107, 14),(107, 15),(107, 35),
(108, 12),(108, 13),(108, 19),
(109, 12),(109, 35),(109, 64),(109, 65),(109, 78),
(110, 12),(110, 13),(110, 14),(110, 15),(110, 19),(110, 35),(110, 64),(110, 65),(110, 78),
(111, 12),(111, 13),(111, 14),(111, 15),(111, 19),
(112, 12),(112, 13),(112, 14),(112, 15),(112, 19),(112, 35),(112, 64),(112, 65),(112, 78);

DELIMITER $$
CREATE TRIGGER lowercase_username_before_insert
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    SET NEW.username = LOWER(NEW.username);
END $$
DELIMITER ;
