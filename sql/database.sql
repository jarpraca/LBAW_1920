-- Drop old schema

DROP TABLE IF Exists watchlists;
DROP TABLE IF Exists ships;
DROP TABLE IF Exists seller;
DROP TABLE IF Exists report_pending;
DROP TABLE IF Exists report_denied;
DROP TABLE IF Exists report_approved;
DROP TABLE IF Exists profile_photo;
DROP TABLE IF Exists features;
DROP TABLE IF Exists buyer;
DROP TABLE IF Exists auction_ongoing;
DROP TABLE IF Exists auction_finished;
DROP TABLE IF Exists auction_cancelled;
DROP TABLE IF Exists animal_photo;
DROP TABLE IF Exists "admin";
DROP TABLE IF Exists accepts;
DROP TABLE IF Exists "user";
DROP TABLE IF Exists skill;
DROP TABLE IF Exists shipping_method;
DROP TABLE IF Exists reports;
DROP TABLE IF Exists report_status;
DROP TABLE IF Exists payment_method;
DROP TABLE IF Exists "notification";
DROP TABLE IF Exists main_color;
DROP TABLE IF Exists "image";
DROP TABLE IF Exists blocks;
DROP TABLE IF Exists bids;
DROP TABLE IF Exists auction;
DROP TABLE IF Exists auction_status;
DROP TABLE IF Exists development_stage;
DROP TABLE IF Exists category;

DROP TYPE IF Exists skill_name;
DROP TYPE IF Exists category_name;
DROP TYPE IF Exists shipping;
DROP TYPE IF Exists rating;
DROP TYPE IF Exists payment;
DROP TYPE IF Exists dev_stage;
DROP TYPE IF Exists color;


-- Types
 
CREATE TYPE rating AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE shipping AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE payment AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE skill_name AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE color AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE dev_stage AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE category_name AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');


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
    name skill_name NOT NULL
);

CREATE TABLE main_color
(
    id SERIAL PRIMARY KEY,
    name color NOT NULL
);

CREATE TABLE development_stage
(
    id SERIAL PRIMARY KEY,
    name dev_stage NOT NULL
);

CREATE TABLE category
(
    id SERIAL PRIMARY KEY,
    name category_name NOT NULL
);

CREATE TABLE payment_method
(
    id SERIAL PRIMARY KEY,
    name payment NOT NULL
);

CREATE TABLE shipping_method
(
    id SERIAL PRIMARY KEY,
    name shipping NOT NULL
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
    ending_date date NOT NULL CHECK (ending_date > 'now'::text::date),
    rating_seller "Rating",
    id_category integer NOT NULL REFERENCES category (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_main_color integer NOT NULL REFERENCES main_color (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_dev_stage integer NOT NULL REFERENCES development_stage (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_payment_method integer REFERENCES payment_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_shipping_method integer REFERENCES shipping_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ,
    id_winner integer REFERENCES buyer (id) ON UPDATE CASCADE ,
    CONSTRAINT "buyout_price_ck" CHECK (buyout_price > starting_price)
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
    "type" text NOT NULL,
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
    id_reports integer NOT NULL REFERENCES reports (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE report_pending
(
    id integer NOT NULL PRIMARY KEY REFERENCES report_status (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE report_approved
(
    id integer NOT NULL PRIMARY KEY REFERENCES report_status (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE report_denied
(
    id integer NOT NULL PRIMARY KEY REFERENCES report_status (id) ON UPDATE CASCADE ON DELETE CASCADE
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
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE auction_ongoing
(
    id integer NOT NULL PRIMARY KEY REFERENCES auction_status (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE auction_cancelled
(
    id integer NOT NULL PRIMARY KEY REFERENCES auction_status (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE auction_finished
(
    id integer NOT NULL PRIMARY KEY REFERENCES auction_status (id) ON UPDATE CASCADE ON DELETE CASCADE
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

INSERT INTO "user" (id,name,email,hashed_password) VALUES 
    (1,'Dante Copeland','scelerisque@maurisut.com','FXU64FUN0IB'),
    (2,'Kevin Sandoval','lectus.Nullam.suscipit@senectuset.net','OJU69NCH6XM'),
    (3,'Nolan Y. Morgan','arcu@auctorodioa.net','PZN13XLL1XF'),
    (4,'Dean Galloway','ipsum.sodales.purus@Cras.com','JRD25APR5CM'),
    (5,'Anthony N. Wilcox','varius.ultrices.mauris@orciDonec.ca','SOZ93UJO8CZ'),
    (6,'Derek Stone','semper.cursus.Integer@feugiat.org','RHK73GWY1DV'),
    (7,'Octavius Wall','non.bibendum@massalobortis.edu','KPK52BSN6UK'),
    (8,'Paki J. Sutton','Morbi.metus.Vivamus@velitjusto.com','MJK94CQP2WW'),
    (9,'September I. Wagner','porttitor.vulputate.posuere@blandit.co.uk','QDI49NAO1MU'),
    (10,'Nathaniel V. Berry','ipsum.primis.in@eratnequenon.org','RKO45HVO4TR'),
    (11,'Zahir R. Blevins','nibh.dolor.nonummy@eratnonummyultricies.com','QNY68JNT1CX'),
    (12,'Kamal N. Cortez','nec@faucibus.co.uk','NVV84EYY8DF'),
    (13,'Daria X. Warren','justo.sit@sociis.ca','OTR96MXC1NE'),
    (14,'Natalie K. Petty','amet.diam.eu@indolor.ca','UJC45JTC5XY'),
    (15,'Armand H. Frye','interdum.ligula.eu@maurissapien.co.uk','DUD29LEI0IT'),
    (16,'Norman Q. Morrison','vitae@Aeneaneuismod.org','YHD15XGY3UH'),
    (17,'Lawrence Dominguez','non.luctus.sit@augueac.org','GDQ82BCE1KV'),
    (18,'Tanya Rios','lectus.justo@estMauris.co.uk','JRJ47SWH3JE'),
    (19,'Macaulay Haney','in.molestie.tortor@diamlorem.com','UAA83MYF7YN'),
    (20,'Harrison I. Mcclain','commodo.hendrerit@Donecestmauris.ca','RKD57XCG5OA'),
    (21,'Brenden C. Lawrence','molestie.dapibus.ligula@montes.edu','CYU23THB5HL'),
    (22,'Kiona Nielsen','nec.quam.Curabitur@dapibusid.edu','CEV17PXG6IY'),
    (23,'Anika Alston','purus@scelerisquesed.co.uk','KYX29KUX2RU'),
    (24,'Shelly T. Hoover','auctor@eget.com','RHF54MDD1QE'),
    (25,'Phillip D. Woodard','eu@elementum.com','FTP14TRR3BZ'),
    (26,'Hanna Mccarty','luctus.et.ultrices@euaccumsan.net','YCN15UXT6TG'),
    (27,'Gage D. Powell','Aliquam.rutrum@tristiquepharetraQuisque.edu','QPV68CSX9LF'),
    (28,'Chester S. Willis','enim.nec.tempus@ipsumnuncid.com','VUU96HNF8EY'),
    (29,'Salvador O. Good','dui.quis@Phasellusornare.edu','HZW18IYP5CB'),
    (30,'Ainsley K. Castillo','feugiat@augueeu.co.uk','WNT68SOM0OA'),
    (31,'Sloane A. Richards','Nullam@volutpatnuncsit.co.uk','ZIP74AWK7IN'),
    (32,'Cally T. Rodriguez','ipsum@acfacilisis.ca','TBC40TDP6GJ'),
    (33,'Aline L. Bryant','nunc.est.mollis@egetlacus.net','YZV68ZJX8SW'),
    (34,'Katelyn Booth','dui@eget.ca','FVY06FFU4VU'),
    (35,'Wylie N. Osborn','amet.dapibus@magnaNamligula.com','QYI93BYJ2JN'),
    (36,'Rosalyn W. Tyson','sit@in.net','QCR48BUR3LZ'),
    (37,'Destiny T. Dean','Curabitur.massa.Vestibulum@ac.ca','CQO12BQJ8OS'),
    (38,'Brenden J. Patton','amet.faucibus.ut@enim.edu','XUG61VTA6EQ'),
    (39,'Edan Franks','justo@interdumligulaeu.co.uk','CKC15IVI8AQ'),
    (40,'Jasmine Cummings','facilisis@Sedcongue.org','RNS54ARC2RO'),
    (41,'Angela Austin','nec@musProinvel.com','UTW02MDS3QZ'),
    (42,'Dale E. Briggs','aliquet.sem@elitpellentesque.com','FBF97WMJ2JL'),
    (43,'Ishmael G. Reid','molestie.tortor.nibh@Sed.edu','RSB44PRF4QO'),
    (44,'Georgia G. King','massa.lobortis.ultrices@lectuspedeet.net','IBN55PXL3WJ'),
    (45,'Jack W. Poole','magna.Sed.eu@leoin.ca','KBK26TPU5AY'),
    (46,'Christen Cochran','varius@suscipitest.co.uk','LAL72OBH9SE'),
    (47,'Moses Hart','Donec@dis.edu','IVA23UZD1JT'),
    (48,'Rooney P. Harrington','nisl.Maecenas@ornare.ca','QBC48HRJ4IG'),
    (49,'Chaim O. Parrish','mus@lectusCumsociis.net','ILK34IXW0MZ'),
    (50,'Lacy X. Wiley','Duis.dignissim@ipsumcursusvestibulum.edu','SJZ34DSG7UY');

    