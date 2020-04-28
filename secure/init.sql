BEGIN TRANSACTION;


CREATE TABLE `boards` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `name`	TEXT NOT NULL,
  `color`	TEXT NOT NULL,
  `date` TEXT NOT NULL
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

-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet lorem vel sem dictum mattis. Donec suscipit tortor nec ante.


-- boards
INSERT INTO 'boards' ('name', 'color', 'date') VALUES ('Corporate Websites', '#ffd45e', 'April 27, 2020');
INSERT INTO 'boards' ('name', 'color', 'date') VALUES ('E-Commerce Websites', '#61b5fa', 'April 24, 2020');
INSERT INTO 'boards' ('name', 'color', 'date') VALUES ('Project 3 Inspiration', '#5df0b0', 'April 21, 2020');

-- pins
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (1, 1, 'Wonderful Rendering', 'https://www.pcmag.com/news/how-to-create-a-website','This image has really wonderful editing...Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet lorem vel sem dictum mattis. Donec suscipit tortor nec ante.', 'April 22, 2020');
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (1, 2, 'Nice Color Pallete', 'https://www.thebestdesigns.com/designs/curtain-blind-co','Curtain & Blind has a really nice color pallete. And that little tab menu below the main image is very well integrated into the design...Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet lorem vel sem dictum mattis. Donec suscipit tortor nec ante.', 'April 25, 2020');
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (2, 4, 'Cool Broken Grid Layout', 'https://yelvy.com/', "This website is actually really cool. E commerce websites tend to get really ugly really fast, and Yelby brings a really cool new twist to it. Despite the website being a bit slow due to the giant javascript packages it comes with, it's still a really cool artistic website...Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet lorem vel sem dictum mattis. Donec suscipit tortor nec ante.", 'April 25, 2020');
INSERT INTO 'pins' ('board_id', 'image_id', 'name', 'link', 'description', 'date') VALUES (3, 3, 'Immaculate Website', 'https://github.coecis.cornell.edu/info2300-2020sp/info2300-2020sp-website','I have never seen such an immaculate website. The lines! The seemless navigation! The simple yet effective design! I am in love! There is such a wealth of knowledge in this beautiful website that I maintain my sanity. From the realisations that I forgot to hand in labs, to the wonderfully long readme files that contain all the information for a project you could ever need. I am so in love that I will ask it to marry me...Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet lorem vel sem dictum mattis. Donec suscipit tortor nec ante.', 'April 28, 2020');

-- images
INSERT INTO 'images' ('src', 'description') VALUES ('uploads/images/1.jpg', 'Image for Pin: Wonderful Rendering');
INSERT INTO 'images' ('src', 'description') VALUES ('uploads/images/2.jpg', 'Image for Pin: Nice Color Pallete');
INSERT INTO 'images' ('src', 'description') VALUES ('uploads/images/3.png', 'Image for Pin: Immaculate Website');
INSERT INTO 'images' ('src', 'description') VALUES ('uploads/images/4.png', 'Image for Pin: Cool Broken Grid Layout');

-- tags
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (1, 'wonderful', 'hsl(357,100%,72%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (1, 'rendering', 'hsl(235,100%,65%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (1, 'isometric', 'hsl(124,100%,80%)');

INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (2, 'colors', 'hsl(247,100%,68%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (2, 'pallete', 'hsl(264,100%,70%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (2, 'wonderful', 'hsl(321,100%,78%)');

INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (3, 'grid', 'hsl(85,100%,65%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (3, 'broken', 'hsl(21,100%,69%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (3, 'commerce', 'hsl(25,100%,68%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (3, 'break_the_system', 'hsl(153,100%,78%)');

INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (4, 'immaculate', 'hsl(12,100%,72%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (4, 'perfect', 'hsl(152,100%,71%)');
INSERT INTO 'tags' ('pin_id', 'name', 'color') VALUES (4, 'would_not_change_a_thing', 'hsl(174,100%,69%)');

COMMIT;
