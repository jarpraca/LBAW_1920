<<<<<<< HEAD
DROP TABLE IF Exists "animal_photo";
DROP TABLE IF Exists "profile_photo";
DROP TABLE IF Exists "image";
DROP TABLE IF Exists "auction_finished";
DROP TABLE IF Exists "auction_cancelled";
DROP TABLE IF Exists "auction_ongoing";
DROP TABLE IF Exists "auction_status";
DROP TABLE IF Exists "features";
DROP TABLE IF Exists "watchlists";
DROP TABLE IF Exists "report_denied";
DROP TABLE IF Exists "report_approved";
DROP TABLE IF Exists "report_pending";
DROP TABLE IF Exists "report_status";
DROP TABLE IF Exists "reports";
DROP TABLE IF Exists "accepts";
DROP TABLE IF Exists "ships";
DROP TABLE IF Exists "blocks";
DROP TABLE IF Exists "notification";
DROP TABLE IF Exists "bids";
DROP TABLE IF Exists "auction";
DROP TABLE IF Exists "shipping_method";
DROP TABLE IF Exists "payment_method";
DROP TABLE IF Exists "category";
DROP TABLE IF Exists "development_stage";
DROP TABLE IF Exists "main_color";
DROP TABLE IF Exists "skill";
DROP TABLE IF Exists "seller";
DROP TABLE IF Exists "buyer";
DROP TABLE IF Exists "admin";
DROP TABLE IF Exists "user";

DROP TYPE IF Exists "category_name";
DROP TYPE IF Exists "dev_stage";
DROP TYPE IF Exists "color";
DROP TYPE IF Exists "skill_name";
DROP TYPE IF Exists "payment";
DROP TYPE IF Exists "shipping";
DROP TYPE IF Exists "rating";
=======
DROP TABLE watchlists;
DROP TABLE ships;
DROP TABLE seller;
DROP TABLE report_pending;
DROP TABLE report_denied;
DROP TABLE report_approved;
DROP TABLE profile_photo;
DROP TABLE features;
DROP TABLE buyer;
DROP TABLE auction_ongoing;
DROP TABLE auction_finished;
DROP TABLE auction_cancelled;
DROP TABLE animal_photo;
DROP TABLE "admin";
DROP TABLE accepts;
DROP TABLE "user";
DROP TABLE skill;
DROP TABLE shipping_method;
DROP TABLE reports;
DROP TABLE report_status;
DROP TABLE payment_method;
DROP TABLE "notification";
DROP TABLE main_color;
DROP TABLE "image";
DROP TABLE blocks;
DROP TABLE bids;
DROP TABLE auction;
DROP TABLE auction_status;
DROP TABLE development_stage;
DROP TABLE category;

DROP TYPE skill_name;
DROP TYPE category_name;
DROP TYPE shipping;
DROP TYPE rating;
DROP TYPE payment;
DROP TYPE dev_stage;
DROP TYPE color;
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe


-- Types
 
<<<<<<< HEAD
CREATE TYPE "rating" AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE "shipping" AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE "payment" AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE "skill_name" AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE "color" AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE "dev_stage" AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE "category_name" AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');
=======
CREATE TYPE rating AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE shipping AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE payment AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE skill_name AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE color AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE dev_stage AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE category_name AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');

>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe

-- Tables

CREATE TABLE "user"
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    email text NOT NULL,
<<<<<<< HEAD
    "hashed_password" text NOT NULL,
    CONSTRAINT "email_uk" UNIQUE (email)
=======
    hashed_password text NOT NULL,
    CONSTRAINT "emailUK" UNIQUE (email)
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
);

CREATE TABLE "admin"
(
<<<<<<< HEAD
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "buyer"
=======
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE buyer
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
(
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

<<<<<<< HEAD
CREATE TABLE "seller"
=======
CREATE TABLE seller
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
(
    id integer NOT NULL PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    rating integer NOT NULL,
    CONSTRAINT "rating_ck" CHECK (rating >= 1 AND rating <= 5)
);

<<<<<<< HEAD
CREATE TABLE "skill"
(
    id SERIAL PRIMARY KEY,
    name "skill_name" NOT NULL
);

CREATE TABLE "main_color"
(
    id SERIAL PRIMARY KEY,
    name "color" NOT NULL
);

CREATE TABLE "development_stage"
(
    id SERIAL PRIMARY KEY,
    name "dev_stage" NOT NULL
);

CREATE TABLE "category"
(
    id SERIAL PRIMARY KEY,
    name "category_name" NOT NULL
);

CREATE TABLE "payment_method"
(
    id SERIAL PRIMARY KEY,
    name "payment" NOT NULL
);

CREATE TABLE "shipping_method"
(
    id SERIAL PRIMARY KEY,
    name "shipping" NOT NULL
);

CREATE TABLE "auction"
=======
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
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    description text NOT NULL,
<<<<<<< HEAD
    "species_name" text NOT NULL,
    age integer NOT NULL,
    "starting_price" integer NOT NULL,
    "buyout_price" integer,
    "ending_date" date NOT NULL,
    "rating_seller" "rating",
    "id_category" integer NOT NULL REFERENCES "category" (id) ON UPDATE CASCADE,
    "id_main_color" integer NOT NULL REFERENCES "main_color" (id) ON UPDATE CASCADE,
    "iddev_stage" integer NOT NULL REFERENCES "development_stage" (id) ON UPDATE CASCADE,
    "id_payment_method" integer REFERENCES "payment_method" (id) ON UPDATE CASCADE,
    "id_shipping_method" integer REFERENCES "shipping_method" (id) ON UPDATE CASCADE,
    "id_seller" integer NOT NULL REFERENCES "seller" (id) ON UPDATE CASCADE,
    "id_winner" integer REFERENCES "buyer" (id) ON UPDATE CASCADE,
    CONSTRAINT "ending_date_ck" CHECK ("ending_date" > 'now'::text::date),
    CONSTRAINT "buyout_price_ck" CHECK ("buyout_price" > "starting_price")
);

CREATE TABLE "bids"
=======
    species_name text NOT NULL,
    age integer NOT NULL,
    starting_price integer NOT NULL,
    buyout_price integer,
    ending_date date NOT NULL,
    rating_seller "Rating",
    id_category integer NOT NULL REFERENCES category (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_main_color integer NOT NULL REFERENCES main_color (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_dev_stage integer NOT NULL REFERENCES development_stage (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_payment_method integer REFERENCES payment_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_shipping_method integer REFERENCES shipping_method (id) ON UPDATE CASCADE ON DELETE RESTRICT,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ,
    id_winner integer REFERENCES buyer (id) ON UPDATE CASCADE ,
    CONSTRAINT "ending_dateCK" CHECK (ending_date > 'now'::text::date),
    CONSTRAINT "buyout_priceCK" CHECK (buyout_price > starting_price)
);

CREATE TABLE bids
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
(
    id SERIAL PRIMARY KEY,
    value integer NOT NULL,
    maximum integer,
<<<<<<< HEAD
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE,
    "id_buyer" integer REFERENCES "buyer" (id) ON UPDATE CASCADE,
    CONSTRAINT "maximum_ck" CHECK ("maximum" >= value)
=======
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer REFERENCES buyer (id) ON UPDATE CASCADE,
    CONSTRAINT "maximumCK" CHECK (maximum >= value)
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
);

CREATE TABLE "notification"
(
    id SERIAL PRIMARY KEY,
    "message" text NOT NULL,
    "type" text NOT NULL,
    "read" boolean DEFAULT FALSE,
<<<<<<< HEAD
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE,
    "id_buyer" integer REFERENCES "buyer" (id) ON UPDATE CASCADE
);

CREATE TABLE "blocks"
(
    id SERIAL PRIMARY KEY,
    "end_date" date,
    "id_admin" integer NOT NULL REFERENCES "admin" (id) ON UPDATE CASCADE,
    "id_seller" integer NOT NULL REFERENCES "seller" (id) ON UPDATE CASCADE,
    CONSTRAINT "end_date_ck" CHECK ("end_date" > 'now'::text::date)
);

CREATE TABLE "ships"
(
    id SERIAL PRIMARY KEY,
    "id_seller" integer NOT NULL REFERENCES "seller" (id) ON UPDATE CASCADE,
    "id_shipping_method" integer NOT NULL REFERENCES "shipping_method" (id) ON UPDATE CASCADE
);

CREATE TABLE "accepts"
(
    id SERIAL PRIMARY KEY,
    "id_seller" integer NOT NULL REFERENCES "seller" (id) ON UPDATE CASCADE,
    "id_payment_method" integer NOT NULL REFERENCES "payment_method" (id) ON UPDATE CASCADE
);

CREATE TABLE "reports"
(
    id SERIAL PRIMARY KEY,
    "date" date NOT NULL DEFAULT 'now'::text::date,
    "id_buyer" integer NOT NULL REFERENCES "buyer" (id) ON UPDATE CASCADE,
    "id_seller" integer NOT NULL REFERENCES "seller" (id) ON UPDATE CASCADE
);

CREATE TABLE "report_status"
(
    id SERIAL PRIMARY KEY,
    "id_reports" integer NOT NULL REFERENCES "reports" (id) ON UPDATE CASCADE
);

CREATE TABLE "report_pending"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "report_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "report_approved"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "report_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "report_denied"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "report_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "watchlists"
(
    id SERIAL PRIMARY KEY,
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE,
    "id_buyer" integer NOT NULL REFERENCES "buyer" (id) ON UPDATE CASCADE
);

CREATE TABLE "features"
(
    id SERIAL PRIMARY KEY,
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE,
    "id_skill" integer NOT NULL REFERENCES "skill" (id) ON UPDATE CASCADE
);

CREATE TABLE "auction_status"
(
    id SERIAL PRIMARY KEY,
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE
);

CREATE TABLE "auction_ongoing"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "auction_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "auction_cancelled"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "auction_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "auction_finished"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "auction_status" (id) ON UPDATE CASCADE ON DELETE CASCADE
=======
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer REFERENCES buyer (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE blocks
(
    id SERIAL PRIMARY KEY,
    end_date date,
    id_admin integer NOT NULL REFERENCES "admin" (id) ON UPDATE CASCADE,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "end_dateCK" CHECK (end_date > 'now'::text::date)
);

CREATE TABLE ships
(
    id SERIAL PRIMARY KEY,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_shipping_method integer NOT NULL REFERENCES shipping_method (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE accepts
(
    id SERIAL PRIMARY KEY,
    id_seller integer NOT NULL REFERENCES seller (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_payment_method integer NOT NULL REFERENCES payment_method (id) ON UPDATE CASCADE ON DELETE CASCADE
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
    id SERIAL PRIMARY KEY,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_buyer integer NOT NULL REFERENCES buyer (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE features
(
    id SERIAL PRIMARY KEY,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE,
    id_skill integer NOT NULL REFERENCES skill (id) ON UPDATE CASCADE ON DELETE CASCADE
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
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
);

CREATE TABLE "image"
(
    id SERIAL PRIMARY KEY,
    url text NOT NULL
);

<<<<<<< HEAD
CREATE TABLE "profile_photo"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    "id_user" integer NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE
);

CREATE TABLE "animal_photo"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    "id_auction" integer NOT NULL REFERENCES "auction" (id) ON UPDATE CASCADE
=======
CREATE TABLE profile_photo
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE,
    id_user integer NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE animal_photo
(
    id integer NOT NULL PRIMARY KEY REFERENCES "image" (id) ON UPDATE CASCADE ,
    id_auction integer NOT NULL REFERENCES auction (id) ON UPDATE CASCADE ON DELETE CASCADE
>>>>>>> 5f3ba5c2d69c8e420fcd71d12343819f5b9489fe
);