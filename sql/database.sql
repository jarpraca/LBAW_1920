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
    id_reports integer NOT NULL REFERENCES reports (id) ON UPDATE CASCADE ON DELETE CASCADE,
    TYPE report_status_name NOT NULL
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