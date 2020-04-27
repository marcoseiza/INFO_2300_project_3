BEGIN TRANSACTION;


CREATE TABLE `boards` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `name`	TEXT NOT NULL,
  `color`	TEXT NOT NULL
);

CREATE TABLE `pins` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `board_id` INTEGER NOT NULL,
  `image_id` INTEGER NOT NULL,
  `name`	TEXT NOT NULL,
  `link`	TEXT NOT NULL,
  `description`	TEXT,
  `date` TEXT
);

CREATE TABLE `tags` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `pin_id` INTEGER NOT NULL,
  `name`	TEXT NOT NULL,
  `color` TEXT NOT NULL
);

CREATE TABLE `images` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `src`	TEXT NOT NULL,
  `description`	TEXT NOT NULL
);


INSERT INTO 'boards' ('name', 'color') VALUES ('Test_board', 'blue');
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (1, 1, 'Test_pin', 'https://www.pcmag.com/news/how-to-create-a-website','This is a test', 'April 22, 2020');
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (1, 1, 'Test_pin', 'https://www.pcmag.com/news/how-to-create-a-website','This is a test', 'April 23, 2020');
INSERT INTO 'images' ('src', 'description') VALUES ('uploads/images/1.jpg', 'Test_img');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (1, 'test_tag', 'rgba(255,0,0,0.5)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (1, 'test_tag2', 'rgba(255,0,0,0.5)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (2, 'test_tag3', 'rgba(255,0,0,0.5)');

COMMIT;
