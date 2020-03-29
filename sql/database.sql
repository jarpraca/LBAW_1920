-- Drop old schema

DROP TABLE IF Exists watchlists;
DROP TABLE IF Exists ships;
DROP TABLE IF Exists profile_photo;
DROP TABLE IF Exists features;
DROP TABLE IF Exists animal_photo;
DROP TABLE IF Exists accepts;
DROP TABLE IF Exists skill;
DROP TABLE IF Exists report_status;
DROP TABLE IF Exists reports;
DROP TABLE IF Exists "notification";
DROP TABLE IF Exists bids;
DROP TABLE IF Exists auction_status;
DROP TABLE IF Exists auction;
DROP TABLE IF Exists main_color;
DROP TABLE IF Exists "image";
DROP TABLE IF Exists blocks;
DROP TABLE IF Exists development_stage;
DROP TABLE IF Exists category;
DROP TABLE IF Exists shipping_method;
DROP TABLE IF Exists payment_method;
DROP TABLE IF Exists "admin";
DROP TABLE IF Exists seller;
DROP TABLE IF Exists buyer;
DROP TABLE IF Exists "user";

DROP TYPE IF Exists skill_name;
DROP TYPE IF Exists category_name;
DROP TYPE IF Exists shipping;
DROP TYPE IF Exists rating;
DROP TYPE IF Exists payment;
DROP TYPE IF Exists dev_stage;
DROP TYPE IF Exists color;
DROP TYPE IF EXISTS report_status_name;
DROP TYPE IF EXISTS auction_status_name;

-- Types
 
CREATE TYPE rating AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE shipping AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE payment AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE skill_name AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE color AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE dev_stage AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE category_name AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');
CREATE TYPE report_status_name as ENUM('Pending', 'Approved', 'Denied');
CREATE TYPE auction_status_name as ENUM('Ongoing', 'Cancelled','Finished');

-- Tables

CREATE TABLE "user"
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    email text NOT NULL UNIQUE,
    hashed_password text NOT NULL
);

CREATE TABLE "admin"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE buyer
(
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE seller
(
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    rating integer NOT NULL CHECK (rating >= 1 AND rating <= 5)
);

CREATE TABLE skill
(
    id SERIAL PRIMARY KEY,
    TYPE skill_name NOT NULL
);

CREATE TABLE main_color
(
    id SERIAL PRIMARY KEY,
    TYPE color NOT NULL
);

CREATE TABLE development_stage
(
    id SERIAL PRIMARY KEY,
    TYPE dev_stage NOT NULL
);

CREATE TABLE category
(
    id SERIAL PRIMARY KEY,
    TYPE category_name NOT NULL
);

CREATE TABLE payment_method
(
    id SERIAL PRIMARY KEY,
    TYPE payment NOT NULL
);

CREATE TABLE shipping_method
(
    id SERIAL PRIMARY KEY,
    TYPE shipping NOT NULL
);

CREATE TABLE auction
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    description text NOT NULL,
    species_name text NOT NULL,
    age integer NOT NULL,
    starting_price integer NOT NULL,
    buyout_price integer,
    current_price integer,
    ending_date date NOT NULL CHECK (ending_date > 'now'::text::date),
    TYPE rating,
    id_category integer NOT NULL REFERENCES category (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_main_color integer NOT NULL REFERENCES main_color (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_dev_stage integer NOT NULL REFERENCES development_stage (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_payment_method integer REFERENCES payment_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_shipping_method integer REFERENCES shipping_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ,
    id_winner integer REFERENCES buyer (id) ON UPDATE CASCADE ,
    CONSTRAINT "buyout_price_ck" CHECK (buyout_price > starting_price),
    CONSTRAINT "current_price_ck" CHECK (current_price >= starting_price)

);

CREATE TABLE bids
(
    id SERIAL PRIMARY KEY,
    value integer NOT NULL,
    maximum integer,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer REFERENCES buyer (id) ON UPDATE CASCADE,
    CONSTRAINT "maximum_ck" CHECK (maximum >= value)
);

CREATE TABLE "notification"
(
    id SERIAL PRIMARY KEY,
    "message" text NOT NULL,
    "read" boolean DEFAULT FALSE,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer REFERENCES buyer (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE blocks
(
    id SERIAL PRIMARY KEY,
    end_date date NOT NULL CHECK (end_date > 'now'::text::date),
    id_admin integer NOT NULL REFERENCES "admin" (id) ON UPDATE CASCADE,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE ships
(
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_shipping_method integer NOT NULL REFERENCES shipping_method (id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY Key(id_seller, id_shipping_method)
);

CREATE TABLE accepts
(
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_payment_method integer NOT NULL REFERENCES payment_method (id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY Key(id_seller, id_payment_method)
);

CREATE TABLE reports
(
    id SERIAL PRIMARY KEY,
    "date" date NOT NULL DEFAULT 'now'::text::date,
    id_buyer integer NOT NULL REFERENCES buyer (id) ON UPDATE CASCADE,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE report_status
(
    id SERIAL PRIMARY KEY,
    id_reports integer NOT NULL REFERENCES reports (id) ON UPDATE CASCADE ON DELETE CASCADE,
    TYPE report_status_name NOT NULL
);

CREATE TABLE watchlists
(
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer NOT NULL REFERENCES buyer (id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY Key(id_auction, id_buyer)
);

CREATE TABLE features
(
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_skill integer NOT NULL REFERENCES skill (id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY Key(id_auction, id_skill)
);

CREATE TABLE auction_status
(
    id SERIAL PRIMARY KEY,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    TYPE auction_status_name NOT NULL
);

CREATE TABLE "image"
(
    id SERIAL PRIMARY KEY,
    url text NOT NULL
);

CREATE TABLE profile_photo
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE,
    id_user integer NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE animal_photo
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE ,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Populate the database

INSERT INTO "user" (name,email,hashed_password) VALUES 
    ('Dante Copeland','scelerisque@maurisut.com','FXU64FUN0IB'),
    ('Kevin Sandoval','lectus.Nullam.suscipit@senectuset.net','OJU69NCH6XM'),
    ('Nolan Y. Morgan','arcu@auctorodioa.net','PZN13XLL1XF'),
    ('Dean Galloway','ipsum.sodales.purus@Cras.com','JRD25APR5CM'),
    ('Anthony N. Wilcox','varius.ultrices.mauris@orciDonec.ca','SOZ93UJO8CZ'),
    ('Derek Stone','semper.cursus.Integer@feugiat.org','RHK73GWY1DV'),
    ('Octavius Wall','non.bibendum@massalobortis.edu','KPK52BSN6UK'),
    ('Paki J. Sutton','Morbi.metus.Vivamus@velitjusto.com','MJK94CQP2WW'),
    ('September I. Wagner','porttitor.vulputate.posuere@blandit.co.uk','QDI49NAO1MU'),
    ('Nathaniel V. Berry','ipsum.primis.in@eratnequenon.org','RKO45HVO4TR'),
    ('Zahir R. Blevins','nibh.dolor.nonummy@eratnonummyultricies.com','QNY68JNT1CX'),
    ('Kamal N. Cortez','nec@faucibus.co.uk','NVV84EYY8DF'),
    ('Daria X. Warren','justo.sit@sociis.ca','OTR96MXC1NE'),
    ('Natalie K. Petty','amet.diam.eu@indolor.ca','UJC45JTC5XY'),
    ('Armand H. Frye','interdum.ligula.eu@maurissapien.co.uk','DUD29LEI0IT'),
    ('Norman Q. Morrison','vitae@Aeneaneuismod.org','YHD15XGY3UH'),
    ('Lawrence Dominguez','non.luctus.sit@augueac.org','GDQ82BCE1KV'),
    ('Tanya Rios','lectus.justo@estMauris.co.uk','JRJ47SWH3JE'),
    ('Macaulay Haney','in.molestie.tortor@diamlorem.com','UAA83MYF7YN'),
    ('Harrison I. Mcclain','commodo.hendrerit@Donecestmauris.ca','RKD57XCG5OA'),
    ('Brenden C. Lawrence','molestie.dapibus.ligula@montes.edu','CYU23THB5HL'),
    ('Kiona Nielsen','nec.quam.Curabitur@dapibusid.edu','CEV17PXG6IY'),
    ('Anika Alston','purus@scelerisquesed.co.uk','KYX29KUX2RU'),
    ('Shelly T. Hoover','auctor@eget.com','RHF54MDD1QE'),
    ('Phillip D. Woodard','eu@elementum.com','FTP14TRR3BZ'),
    ('Hanna Mccarty','luctus.et.ultrices@euaccumsan.net','YCN15UXT6TG'),
    ('Gage D. Powell','Aliquam.rutrum@tristiquepharetraQuisque.edu','QPV68CSX9LF'),
    ('Chester S. Willis','enim.nec.tempus@ipsumnuncid.com','VUU96HNF8EY'),
    ('Salvador O. Good','dui.quis@Phasellusornare.edu','HZW18IYP5CB'),
    ('Ainsley K. Castillo','feugiat@augueeu.co.uk','WNT68SOM0OA'),
    ('Sloane A. Richards','Nullam@volutpatnuncsit.co.uk','ZIP74AWK7IN'),
    ('Cally T. Rodriguez','ipsum@acfacilisis.ca','TBC40TDP6GJ'),
    ('Aline L. Bryant','nunc.est.mollis@egetlacus.net','YZV68ZJX8SW'),
    ('Katelyn Booth','dui@eget.ca','FVY06FFU4VU'),
    ('Wylie N. Osborn','amet.dapibus@magnaNamligula.com','QYI93BYJ2JN'),
    ('Rosalyn W. Tyson','sit@in.net','QCR48BUR3LZ'),
    ('Destiny T. Dean','Curabitur.massa.Vestibulum@ac.ca','CQO12BQJ8OS'),
    ('Brenden J. Patton','amet.faucibus.ut@enim.edu','XUG61VTA6EQ'),
    ('Edan Franks','justo@interdumligulaeu.co.uk','CKC15IVI8AQ'),
    ('Jasmine Cummings','facilisis@Sedcongue.org','RNS54ARC2RO'),
    ('Angela Austin','nec@musProinvel.com','UTW02MDS3QZ'),
    ('Dale E. Briggs','aliquet.sem@elitpellentesque.com','FBF97WMJ2JL'),
    ('Ishmael G. Reid','molestie.tortor.nibh@Sed.edu','RSB44PRF4QO'),
    ('Georgia G. King','massa.lobortis.ultrices@lectuspedeet.net','IBN55PXL3WJ'),
    ('Jack W. Poole','magna.Sed.eu@leoin.ca','KBK26TPU5AY'),
    ('Christen Cochran','varius@suscipitest.co.uk','LAL72OBH9SE'),
    ('Moses Hart','Donec@dis.edu','IVA23UZD1JT'),
    ('Rooney P. Harrington','nisl.Maecenas@ornare.ca','QBC48HRJ4IG'),
    ('Chaim O. Parrish','mus@lectusCumsociis.net','ILK34IXW0MZ'),
    ('Lacy X. Wiley','Duis.dignissim@ipsumcursusvestibulum.edu','SJZ34DSG7UY');

INSERT INTO "admin" (id) VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10);

INSERT INTO buyer (id) VALUES 
    (11),(12),(13),(14),(15),(16),(17),(18),(19),(20),
    (21),(22),(23),(24),(25),(26),(27),(28),(29),(30);

INSERT INTO "seller" (id,rating) VALUES 
    (31,2),
    (32,5),
    (33,5),
    (34,5),
    (35,1),
    (36,4),
    (37,1),
    (38,3),
    (39,4),
    (40,3),
    (41,1),
    (42,2),
    (43,3),
    (44,4),
    (45,1),
    (46,1),
    (47,5),
    (48,2),
    (49,4),
    (50,3);


INSERT INTO skill (TYPE) VALUES 
    ('Climbs'),
    ('Jumps'),
    ('Talks'),
    ('Skates'),
    ('Olfaction'),
    ('Moonlight Navigation'),
    ('Echolocation'),
    ('Acrobatics');

INSERT INTO main_color (TYPE) VALUES 
    ('Blue'),
    ('Brown'),
    ('Black'),
    ('Yellow'),
    ('Green'),
    ('Red'),
    ('White');
    
INSERT INTO development_stage (TYPE) VALUES 
    ('Baby'),
    ('Child'),
    ('Teen'),
    ('Adult'),
    ('Elderly');

INSERT INTO category (TYPE) VALUES 
    ('Mammals'),
    ('Insects'),
    ('Reptiles'),
    ('Fishes'),
    ('Birds'),
    ('Amphibians');

INSERT INTO payment_method (TYPE) VALUES 
    ('Debit Card'),
    ('PayPal');

INSERT INTO shipping_method (TYPE) VALUES 
    ('Standard Mail'),
    ('Express Mail'),
    ('Urgent Mail');

INSERT INTO auction (name,description,species_name,age,starting_price,buyout_price,current_price,ending_date,TYPE,id_category,id_main_color,id_dev_stage,id_payment_method,id_shipping_method,id_seller,id_winner) VALUES 
    ('Brett','vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem','Jorden',6,599,13892,2998,'2021-04-12','4',1,4,1,1,2,42,24),
    ('Michael','odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla','Kylan',14,103,7313,2257,'2021-11-30','2',6,2,4,1,1,43,18),
    ('Cleo','non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate','Sylvester',11,704,8681,6657,'2021-01-01','4',2,7,2,1,3,42,11),
    ('Ross','tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque.','Linus',6,111,9113,4449,'2021-07-19','1',6,5,2,2,3,35,19),
    ('Clementine','sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat','Sydnee',11,71,7457,1475,'2021-12-15','1',2,1,5,1,2,41,20),
    ('Elliott','porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum','Joy',1,898,11728,1376,'2021-03-06','2',2,3,3,2,2,32,19),
    ('Buffy','montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac','Ashton',3,892,11497,5372,'2021-08-14','4',4,5,4,2,3,34,20),
    ('Kennedy','metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada','Logan',15,549,14170,3679,'2021-07-21','5',1,3,4,2,1,34,30),
    ('Leah','felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit','Freya',1,946,14533,3089,'2021-10-03','5',6,6,3,1,1,44,20),
    ('Cruz','nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi','Alec',1,293,13098,2780,'2021-11-24','3',6,2,1,2,1,49,11),
    ('Gay','sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam','Laith',8,963,7624,5545,'2021-09-12','4',1,5,2,2,1,31,20),
    ('Keith','Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet,','Maxwell',7,508,13764,3711,'2021-01-12','2',5,1,4,2,3,35,16),
    ('Rhoda','tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget','Otto',14,591,9651,2187,'2021-03-25','5',6,1,2,2,2,42,30),
    ('Troy','ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante','Nichole',10,956,9538,4886,'2021-06-23','5',1,4,5,2,2,48,28),
    ('Thaddeus','quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum.','Steel',5,232,8737,1528,'2021-07-06','2',2,1,3,1,1,34,16),
    ('Lenore','ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus','Yolanda',2,229,11475,4017,'2021-08-12','4',5,5,5,2,3,41,16),
    ('Faith','suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin','Gary',3,107,11486,2201,'2021-05-08','5',4,6,2,2,3,43,27),
    ('Sean','aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer','Quynn',5,138,10108,1442,'2021-06-29','2',3,5,3,2,1,48,15),
    ('Martin','sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies','Kimberly',14,309,14801,4709,'2021-08-20','3',2,4,2,2,1,33,27),
    ('Carl','sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat.','Courtney',3,728,13671,5554,'2021-09-19','4',3,2,3,1,3,46,25),
    ('Jelani','non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum','Gannon',7,494,14401,5747,'2021-07-13','4',3,6,5,2,1,33,12),
    ('Garth','pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et,','Kyle',3,513,13391,3031,'2021-10-06','4',6,1,4,1,3,46,26),
    ('Raja','ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi','Lani',6,565,12840,1515,'2021-12-20','5',3,4,1,2,2,50,15),
    ('Emmanuel','sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis','Kato',8,151,8110,1761,'2021-12-19','4',2,3,4,2,3,37,22),
    ('Demetria','magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis','Erich',4,122,11762,6346,'2021-05-15','3',2,4,5,1,2,41,24),
    ('Alexandra','Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum','Hanna',4,387,8698,6773,'2021-01-06','2',5,7,2,2,2,49,25),
    ('Faith','Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum','Henry',14,56,8878,3568,'2021-12-14','2',5,3,4,1,2,39,30),
    ('Willa','Donec tincidunt. Donec vitae erat vel pede blandit congue. In','Elmo',5,621,7317,2290,'2021-10-24','4',2,7,1,1,3,44,12),
    ('Stewart','amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl','Geoffrey',4,592,7582,5397,'2021-03-01','3',6,2,4,1,2,47,27),
    ('Deacon','feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum','Clio',12,135,12396,5688,'2021-06-21','4',5,2,5,2,3,50,30),
    ('Melissa','commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit','Phillip',5,206,14538,6959,'2021-12-08','3',3,7,3,2,3,40,11),
    ('Patrick','ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa','Arsenio',2,697,8201,5348,'2021-02-12','3',6,6,3,2,2,49,24),
    ('Jakeem','felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo.','Keelie',2,890,7622,6616,'2021-09-13','5',6,1,2,1,2,48,24),
    ('Gareth','consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc','Chandler',14,675,13898,3348,'2021-08-23','4',3,1,3,2,2,42,19),
    ('Baxter','Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat','Anne',4,877,10301,3249,'2021-02-09','5',6,4,1,1,3,44,25),
    ('Amelia','Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa.','Gavin',9,317,14259,6220,'2021-02-28','2',2,2,4,1,3,38,22),
    ('Beck','ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est','Renee',11,289,7274,1080,'2021-08-05','2',6,3,2,2,1,40,29),
    ('Hedwig','velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc','Emi',11,889,14626,6131,'2021-03-21','5',3,4,2,2,3,38,30),
    ('Hadley','orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna','Cassidy',5,39,10736,3187,'2021-07-29','5',3,7,2,1,2,40,18),
    ('Kevin','nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet.','Ariana',7,944,9565,2329,'2021-02-02','5',6,1,3,2,1,41,13),
    ('Larissa','egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio','Elvis',9,411,8574,5671,'2021-11-11','2',3,4,2,1,3,38,15),
    ('Dolan','at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed','Clayton',6,193,9809,6147,'2021-12-24','3',3,6,5,2,3,40,28),
    ('Jackson','Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis','Nevada',12,552,9422,6180,'2021-02-20','1',2,4,5,1,3,37,24),
    ('Guy','pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra','Jordan',14,722,9702,3991,'2021-01-17','3',1,4,1,1,1,33,21),
    ('Adam','In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla','Paul',6,52,13816,3005,'2021-09-14','1',2,3,5,1,2,35,15),
    ('Hanna','gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet','Hector',3,97,11498,1673,'2021-01-23','5',4,7,5,2,2,40,25),
    ('Aphrodite','montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula','Dominic',7,362,8974,1452,'2021-08-10','5',1,4,1,1,3,35,18),
    ('Mara','cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros','Pandora',11,721,8897,4852,'2021-09-04','4',4,6,4,2,2,43,12),
    ('Erica','magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula','Dorothy',2,32,9578,2737,'2021-10-21','2',4,5,4,1,2,40,23),
    ('Ginger','felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing','Cruz',9,93,14455,2111,'2021-04-05','1',1,3,5,1,3,34,29);

INSERT INTO bids (value,maximum,id_auction,id_buyer) VALUES 
    (7311,14859,25,16),
    (10766,13942,39,21),
    (12730,14247,8,30),
    (10555,13511,42,30),
    (10503,13858,45,26),
    (10552,14557,18,23),
    (8814,13451,5,29),
    (12749,13956,26,20),
    (12413,14310,23,27),
    (9247,14547,37,26),
    (8702,13413,30,17),
    (12322,14255,30,27),
    (11984,13740,26,27),
    (12025,14983,48,29),
    (12075,14760,27,26),
    (9292,13591,28,30),
    (12660,13005,20,17),
    (10619,14074,47,15),
    (11581,14778,43,21),
    (12977,14986,21,13),
    (12133,13770,47,18),
    (11203,13170,29,17),
    (7109,13191,45,30),
    (11636,14923,40,12),
    (11113,13145,48,12),
    (9788,14332,29,28),
    (7200,13782,31,13),
    (10828,13444,39,14),
    (11731,14747,36,17),
    (9553,13193,43,27),
    (11295,13044,10,12),
    (10323,14433,3,28),
    (9417,14064,38,27),
    (12163,13453,48,19),
    (10902,13809,46,22),
    (8826,14883,1,25),
    (12788,14289,47,29),
    (11306,14867,11,27),
    (12034,14483,14,15),
    (9477,13911,23,28),
    (11462,14566,2,27),
    (7167,14730,4,20),
    (8681,14283,20,30),
    (8653,13159,5,11),
    (12412,14460,46,20),
    (12824,14990,13,12),
    (12030,14777,15,21),
    (12341,14872,16,24),
    (7931,14694,43,23),
    (10383,14684,23,24);

INSERT INTO "notification" ("message","read",id_auction,id_buyer) VALUES 
    ('mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec','0',49,14),
    ('vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur','1',44,12),
    ('Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum','0',15,18),
    ('erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt','0',27,18),
    ('a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna.','0',9,23),
    ('eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales','0',46,11),
    ('faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci','0',47,29),
    ('convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum','1',25,12),
    ('neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu.','1',13,18),
    ('dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes,','1',37,27),
    ('in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc','1',35,12),
    ('erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu','0',2,29),
    ('mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie.','0',33,11),
    ('non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus.','1',16,11),
    ('auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin','0',45,19),
    ('rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi','0',2,22),
    ('tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa','1',16,19),
    ('felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus','0',47,30),
    ('porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis','0',28,15),
    ('orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus','0',1,14),
    ('sem egestas blandit. Nam nulla magna, malesuada vel, convallis in,','0',19,23),
    ('nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem','0',47,14),
    ('aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis','0',8,23),
    ('orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In','1',38,15),
    ('nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit','1',20,21),
    ('mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum','1',37,30),
    ('ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu','0',9,13),
    ('magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non','0',12,30),
    ('Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus','0',11,27),
    ('ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate,','1',41,29),
    ('Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque','1',29,18),
    ('purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut','0',6,21),
    ('in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit','0',43,29),
    ('Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec','1',24,14),
    ('metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam.','1',12,20),
    ('vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris','0',11,30),
    ('ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor','0',2,26),
    ('velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin','1',23,23),
    ('diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus','0',15,26),
    ('arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis','0',43,21),
    ('Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus','1',35,11),
    ('turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis','0',48,22),
    ('turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna,','1',28,16),
    ('elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique','0',25,24),
    ('dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus','1',21,29),
    ('vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris','0',16,19),
    ('et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec','0',43,16),
    ('malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas','0',12,16),
    ('amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing,','1',43,15),
    ('lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris','1',18,24);

INSERT INTO blocks (end_date,id_admin,id_seller) VALUES 
    ('2020-08-27',3,41),
    ('2020-10-14',5,44),
    ('2020-05-02',1,38),
    ('2020-10-02',2,32),
    ('2020-08-26',4,38),
    ('2020-05-12',5,44),
    ('2020-04-29',2,35),
    ('2020-08-10',6,39),
    ('2020-12-15',6,50),
    ('2020-10-21',1,32),
    ('2021-01-21',7,50),
    ('2020-04-22',6,31),
    ('2020-07-27',2,44),
    ('2020-11-24',4,46),
    ('2020-05-11',9,49),
    ('2020-05-28',7,36),
    ('2020-10-20',1,47),
    ('2020-07-07',4,34),
    ('2020-08-05',5,43),
    ('2020-06-25',9,31),
    ('2020-09-03',4,37),
    ('2020-11-12',9,43),
    ('2020-08-03',8,42),
    ('2020-07-18',4,44),
    ('2020-06-04',6,35),
    ('2021-01-11',9,41),
    ('2020-10-28',7,38),
    ('2020-11-10',10,45),
    ('2020-05-19',1,43),
    ('2021-01-27',6,41),
    ('2020-06-11',2,43),
    ('2020-11-18',5,36),
    ('2021-01-12',2,36),
    ('2020-10-08',3,50),
    ('2020-10-26',7,47),
    ('2020-04-24',4,39),
    ('2020-06-24',7,31),
    ('2020-07-29',4,42),
    ('2021-01-19',8,32),
    ('2020-10-19',3,40),
    ('2020-11-13',5,32),
    ('2020-10-08',10,48),
    ('2020-10-20',8,31),
    ('2020-12-06',3,43),
    ('2020-12-28',5,31),
    ('2020-10-13',2,34),
    ('2021-01-02',8,32),
    ('2020-07-16',9,39),
    ('2020-05-30',10,47),
    ('2020-12-01',8,44);

INSERT INTO "ships" (id_seller,id_shipping_method) VALUES 
    (48,2),
    (40,1),
    (43,1),
    (47,1),
    (49,1),
    (31,2),
    (42,3),
    (44,2),
    (41,1),
    (39,1),
    (35,2),
    (33,3),
    (45,1),
    (34,3),
    (37,2),
    (38,3),
    (36,2),
    (32,2),
    (46,1),
    (50,3);

INSERT INTO accepts (id_seller,id_payment_method) VALUES 
    (48,1),
    (40,2),
    (43,2),
    (47,1),
    (49,1),
    (31,1),
    (42,1),
    (44,1),
    (41,2),
    (39,1),
    (35,2),
    (33,1),
    (45,1),
    (34,1),
    (37,1),
    (38,2),
    (36,2),
    (32,2),
    (46,1),
    (50,1);

INSERT INTO reports ("date",id_buyer,id_seller) VALUES 
    ('2020-03-29',22,33),
    ('2020-03-29',14,40),
    ('2020-03-28',21,50),
    ('2020-03-28',26,34),
    ('2020-03-28',25,45),
    ('2020-03-29',19,43),
    ('2020-03-29',12,31),
    ('2020-03-29',16,39),
    ('2020-03-28',12,40),
    ('2020-03-29',24,43),
    ('2020-03-28',13,43),
    ('2020-03-29',22,41),
    ('2020-03-28',16,44),
    ('2020-03-29',12,45),
    ('2020-03-28',29,41),
    ('2020-03-28',12,46),
    ('2020-03-29',23,48),
    ('2020-03-29',22,43),
    ('2020-03-28',11,44),
    ('2020-03-29',24,47);

INSERT INTO report_status (id_reports,TYPE) VALUES 
    (1,'Denied'),
    (2,'Approved'),
    (3,'Pending'),
    (4,'Pending'),
    (5,'Denied'),
    (6,'Denied'),
    (7,'Pending'),
    (8,'Denied'),
    (9,'Pending'),
    (10,'Approved'),
    (11,'Pending'),
    (12,'Pending'),
    (13,'Approved'),
    (14,'Pending'),
    (15,'Denied'),
    (16,'Denied'),
    (17,'Denied'),
    (18,'Approved'),
    (19,'Pending'),
    (20,'Denied');

INSERT INTO "image" (url) VALUES 
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    ('../images/profile/udfohgoid '),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik'),
    (' ../images/auction/ergjroik');

INSERT INTO profile_photo (id,id_user) VALUES 
    (1,6),
    (2,4),
    (3,49),
    (4,13),
    (5,22),
    (6,45),
    (7,29),
    (8,46),
    (9,5),
    (10,35),
    (11,47),
    (12,16),
    (13,11),
    (14,15),
    (15,1),
    (16,49),
    (17,19),
    (18,14),
    (19,27),
    (20,17);

INSERT INTO "animal_photo" (id,id_auction) VALUES 
    (1,4),
    (2,38),
    (3,9),
    (4,45),
    (5,46),
    (6,35),
    (7,24),
    (8,49),
    (9,39),
    (10,47),
    (11,34),
    (12,6),
    (13,41),
    (14,17),
    (15,3),
    (16,25),
    (17,27),
    (18,48),
    (19,31),
    (20,30);
