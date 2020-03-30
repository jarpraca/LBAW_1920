DROP TABLE IF EXISTS watchlists;
DROP TABLE IF EXISTS ships;
DROP TABLE IF EXISTS profile_photo;
DROP TABLE IF EXISTS features;
DROP TABLE IF EXISTS animal_photo;
DROP TABLE IF EXISTS accepts;
DROP TABLE IF EXISTS skill;
DROP TABLE IF EXISTS report_status;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS "notification";
DROP TABLE IF EXISTS bids;
DROP TABLE IF EXISTS auction_status;
DROP TABLE IF EXISTS auction;
DROP TABLE IF EXISTS main_color;
DROP TABLE IF EXISTS "image";
DROP TABLE IF EXISTS blocks;
DROP TABLE IF EXISTS development_stage;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS shipping_method;
DROP TABLE IF EXISTS payment_method;
DROP TABLE IF EXISTS "admin";
DROP TABLE IF EXISTS seller;
DROP TABLE IF EXISTS buyer;
DROP TABLE IF EXISTS "user";

DROP TYPE IF EXISTS skill_name;
DROP TYPE IF EXISTS category_name;
DROP TYPE IF EXISTS shipping;
DROP TYPE IF EXISTS rating;
DROP TYPE IF EXISTS payment;
DROP TYPE IF EXISTS dev_stage;
DROP TYPE IF EXISTS color;
DROP TYPE IF EXISTS report_status_name;
DROP TYPE IF EXISTS auction_status_name;

DROP INDEX IF EXISTS user_email;
DROP INDEX IF EXISTS search_auction;
DROP INDEX IF EXISTS admin_search;
DROP INDEX IF EXISTS auction_id;
DROP INDEX IF EXISTS notification_id;

DROP TRIGGER IF EXISTS create_buyer ON "user";
DROP TRIGGER IF EXISTS create_seller ON "user";
DROP TRIGGER IF EXISTS stop_ongoing_auctions ON blocks;
DROP TRIGGER IF EXISTS update_current_price ON bids;
DROP TRIGGER IF EXISTS send_notification ON bids;
DROP TRIGGER IF EXISTS notify_winner ON auction_status;
DROP TRIGGER IF EXISTS verify_bid_value ON bids;
DROP TRIGGER IF EXISTS update_rating ON auction;
DROP TRIGGER IF EXISTS remove_watchlists ON auction_status;

DROP FUNCTION IF EXISTS create_buyer();
DROP FUNCTION IF EXISTS create_seller();
DROP FUNCTION IF EXISTS stop_ongoing_auctions();
DROP FUNCTION IF EXISTS update_current_price();
DROP FUNCTION IF EXISTS send_notification();
DROP FUNCTION IF EXISTS notify_winner();
DROP FUNCTION IF EXISTS verify_bid_value();
DROP FUNCTION IF EXISTS update_rating();
DROP FUNCTION IF EXISTS remove_watchlists();
-----------------------------------------
-- TYPES
----------------------------------------- 
CREATE TYPE rating AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE shipping AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE payment AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE skill_name AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE color AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE dev_stage AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE category_name AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');
CREATE TYPE report_status_name as ENUM('Pending', 'Approved', 'Denied');
CREATE TYPE auction_status_name as ENUM('Ongoing', 'Cancelled','Finished');

-----------------------------------------
-- TABLES
-----------------------------------------
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
    rating integer CHECK (rating >= 1 AND rating <= 5)
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

-----------------------------------------
-- INDEXES
-----------------------------------------

 CREATE INDEX search_auction ON auction USING GIST (to_tsvector('english', name || ' ' || species_name || ' ' || description ));

 CREATE INDEX admin_search ON "user" USING GIST (to_tsvector('english', name || ' ' || email));

 CREATE INDEX notification_id ON "notification" USING hash(id_buyer);

CREATE INDEX watchlists_id ON watchlists USING hash(id_buyer);

CREATE INDEX auction_id ON auction USING hash(id_seller);

CREATE INDEX bids_id ON bids USING hash(id_buyer);

-----------------------------------------
-- TRIGGERS
-----------------------------------------

CREATE FUNCTION notify_winner() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF(NEW.TYPE = 'Finished')
    THEN
        SELECT auction_info.id_buyer AS id_winner, auction_info.id_auction AS id_auction , max(auction_info.value)
            FROM (SELECT value, id_auction, id_buyer
                    FROM  bids
                    WHERE id_auction >= NEW.id_auction) AS auction_info;
        INSERT INTO "notification" ("message", "read", id_auction, id_buyer)
            VALUES ("You won an auction", FALSE, id_auction, id_winner);
    END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_winner
    AFTER UPDATE ON auction_status 
	FOR EACH ROW
    EXECUTE PROCEDURE notify_winner(); 


CREATE FUNCTION update_current_price() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE auction 
        SET current_price = NEW.value
        WHERE id = NEW.id_auction;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_current_price
    AFTER INSERT ON bids 
    FOR EACH ROW
    EXECUTE PROCEDURE update_current_price();

CREATE FUNCTION verify_bid_value() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM auction WHERE NEW.id_auction = id AND current_price > NEW.value ) 
        THEN RAISE EXCEPTION 'A bid can only be made with a value greater than the current bid';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER verify_bid_value
    BEFORE INSERT ON bids
	FOR EACH ROW
    EXECUTE PROCEDURE verify_bid_value();
	
	
CREATE FUNCTION update_rating() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF(NEW.TYPE != NULL)
    THEN
        UPDATE seller
        SET rating = (
            SELECT AVG(TYPE)
            FROM auction
            WHERE auction.id = NEW.id
        )
        WHERE seller.id = NEW.id_seller;
    END IF;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_rating
    AFTER UPDATE ON auction 
    EXECUTE PROCEDURE update_rating(); 

CREATE FUNCTION send_notification() RETURNS TRIGGER AS
$BODY$

BEGIN
    INSERT INTO "notification" ("message", "read", id_auction, id_buyer)
	SELECT 'Your bid has been surpassed', FALSE, info.id_auction, info.id_buyer
    FROM (
        SELECT auction_info.id_auction as id_auction, auction_info.id_buyer as id_buyer, max(auction_info.value) 
            FROM (SELECT value, id_auction, id_buyer
                FROM  bids
                WHERE id_auction >= NEW.id_auction) AS auction_info
            GROUP BY auction_info.id_buyer, auction_info.id_auction) AS info;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER send_notification
    BEFORE INSERT ON bids 
    EXECUTE PROCEDURE send_notification();
	
CREATE FUNCTION stop_ongoing_auctions() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE auction_status 
        SET TYPE = 'Cancelled'
        WHERE (SELECT DISTINCT id_seller FROM auction WHERE id_seller = NEW.id_seller) = NEW.id_seller AND TYPE = 'Ongoing';
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER stop_ongoing_auctions
    AFTER INSERT ON blocks
	FOR EACH ROW
    EXECUTE PROCEDURE stop_ongoing_auctions(); 
	
CREATE FUNCTION create_buyer() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO buyer(id) VALUES (NEW.id);
	RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_buyer
    AFTER INSERT ON "user" 
	FOR EACH ROW
    EXECUTE PROCEDURE create_buyer(); 
 

CREATE FUNCTION create_seller() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT * FROM auction WHERE NEW.id = id)
       THEN INSERT INTO seller(id) values (NEW.id) ;
    END IF;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_seller
    BEFORE INSERT ON auction
	FOR EACH ROW
    EXECUTE PROCEDURE create_seller(); 


CREATE FUNCTION remove_watchlists() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(SELECT * FROM auction_status WHERE auction_status.id = NEW.id AND NEW.TYPE = 'Finished')
    THEN
        DELETE FROM watchlists
        WHERE id_buyer = (SELECT id_buyer FROM watchlists WHERE watchlists.id_auction = NEW.id_auction);
	END IF;
    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER remove_watchlists
    AFTER UPDATE ON auction_status
	FOR EACH ROW
    EXECUTE PROCEDURE remove_watchlists(); 