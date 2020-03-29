PRAGMA foreign_keys = ON;

--View Profile
SELECT name, email, url
    FROM ("user" NATURAL JOIN profile_photo)
    WHERE "user".email = $email;

--Search for Auctions with filters, current_price comes from Materialized View
SELECT id, species_name, current_price, age, ending_date
    FROM (auction JOIN features ON auction.id = features.id_auction)
    WHERE   (id_category = $category OR $category IS NULL)
        AND (id_main_color = $main_color OR $main_color IS NULL)
        AND (id_dev_stage = $dev_stage OR $dev_stage IS NULL)
        AND (current_price < $max_price OR $max_price IS NULL)
        AND (id_skill = $climbs OR $climbs IS NULL)
        AND (id_skill = $jumps OR $jumps IS NULL)
        AND (id_skill = $talks OR $talks IS NULL)
        AND (id_skill = $skates OR $skates IS NULL)
        AND (id_skill = $olfaction OR $olfaction IS NULL)
        AND (id_skill = $navigation OR $navigation IS NULL)
        AND (id_skill = $echo OR $echo IS NULL)
        AND (id_skill = $acrobatics OR $acrobatics IS NULL);

--Full Text Search Auction
SELECT id, species_name, current_price, age, ending_date, ts_rank_cd(textsearch, query) AS rank
    FROM auction, to_tsquery($search) AS query, 
        to_tsvector(name || ' ' || species_name || ' ' || description || ' ' || category || ' ' || main_color || ' ' || skill || ' ' || dev_stage) AS textsearch
    WHERE query @@ textsearch\\ 
    ORDER BY rank DESC;

--Full Text Search Admin
SELECT "name", email, ts_rank_cd(textsearch, query) AS rank
    FROM "user", to_tsquery($search) AS query, 
        to_tsvector(name || ' ' || email) AS textsearch
    WHERE query @@ textsearch\\ 
    ORDER BY rank DESC;

--Homepage Top 3 Auctions
SELECT id, species_name, $current_price, age, ending_date
    FROM (SELECT *, count(*) AS num_bids
            FROM  ((auction JOIN bids ON auction.id = bids.id_auction) JOIN auction_status ON auction.id = auction_status.id_auction)
            WHERE auction_status_name = "Ongoing"
            GROUP BY  auction.id)
    ORDER BY num_bids DESC
    LIMIT 3;
        
-- View Notifications
SELECT id, message, read
    FROM ("user" JOIN "notification" ON "user".id = "notification".id_buyer)
    WHERE "user".id = $id_user
    ORDER BY id DESC
    LIMIT 5;

-- Get Categories
SELECT id, TYPE as name
    FROM category
    ORDER BY name;


        --temos de rever a tabela, nao me lembro de ver la nada de notificações


--View Auction
SELECT * 
    FROM auction
    WHERE id = $id_auction;

---------------------------INSERTS-----------------------------
--Create New User 
INSERT INTO "user" (name, email, hashed_password) 
    values ($name, $email, $hashed_password);

--Create an Auction
INSERT INTO auction (name, description, species_name, age, starting_price, buyout_price, current_price, ending_date, rating_seller, id_category, id_main_color, id_dev_stage, id_seller)
    values ($name, $description, $species_name, $age, $starting_price, $buyout_price, $current_price, $ending_date, $rating_seller, $id_category, $id_main_color, $id_dev_stage, $id_seller);

-- Create a new Bid
INSERT INTO bids(value, maximum, id_auction, id_buyer)
    values ($value, $maximum, $id_auction, $id_buyer );

--Create a new Notification
INSERT INTO "notification" ("message", "type", "read", id_auction, id_buyer)
    values ($message, $type, false, $id_auction, $id_buyer);

--Create a new Block
INSERT INTO blocks (end_date, id_admin, id_seller)
    values($end_date, $id_admin, $id_seller);

--Create a new Report
INSERT INTO reports("date", id_buyer, id_seller)
    values($date, $id_buyer, $id_seller);

-- Add a New Auction to Watchlist
INSERT INTO watchlists (id_auction, id_buyer)
    values($id_auction, id_buyer);

--Insert a status for report
INSERT INTO report_status (id, id_reports, TYPE)
    values($id, $id_reports, $report_status);

--Insert a status for an auction
INSERT INTO auction_status (id, id_auction, TYPE)
    values($id, $id_auction, $auction_status);


---------------------------UPDATES---------------------------
--Edit Profile
UPDATE "user" 
    SET name=$name, email=$email, hashed_password = $password 
    WHERE id = $id_user

--Edit Auction
UPDATE auction
    SET name=$name, description=$description, species_name=$species_name, age=$age, starting_price = $starting_price, buyout_price = $buyout_price, ending_date=$ending_date, id_category = $id_category, id_main_color = $id_main_color, id_dev_stage = $id_dev_stage
    WHERE id = $id_auction AND id_seller = $id_seller


--Up-Update read status in notate read status in notification
UPDATE "notification"
    SET "read" = $read
    WHERE id_auction = $id_auction AND id_buyer = $id_buyer;

--Update auction status 
UPDATE auction_status   
    SET TYPE = $auction_status
    WHERE id = $id;

--Update report status
UPDATE report_status   
    SET TYPE = $report_status
    WHERE id=$id;
    
---------------------------DELETES--------------------------
--Delete User
DELETE FROM "user"
    WHERE id = $id_user;

--Delete Auction
DELETE FROM auction
    WHERE id = $id_auction;

--Remove an auction from the watchlist
DELETE FROM watchlists  
    WHERE id_auction = $id_auction AND id_buyer = $id_buyer;


----------------------------INDEXES-----------------------------

--SELECT01
 CREATE INDEX user_email ON "user" USING hash(email); 

--SELECT03
 CREATE INDEX search_index ON auction USING GIST (to_tsvector(name || ' ' || species_name || ' ' || description || ' ' || category || ' ' || main_color || ' ' || skill || ' ' || dev_stage))

--SELECT04
 CREATE INDEX admin_search ON "user" USING GIST (to_tsvector(name || ' ' || email));

--SELECT05
 CREATE INDEX auction_id ON auction USING hash(id); --??????

 --SELECT06
 CREATE INDEX notification_id ON "notifications" USING hash(id);

---------------------------TRIGGERS-----------------------------

DROP TRIGGER IF EXISTS create_buyer ON "user";
DROP FUNCTION IF EXISTS create_buyer();

--Create Buyer whenever a new User is created
CREATE FUNCTION create_buyer() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO buyer(id) values (NEW.id);
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_buyer
    AFTER INSERT ON "user" 
    EXECUTE PROCEDURE create_buyer(); 


--Create Seller whenever an user creates his first auction
DROP TRIGGER IF EXISTS create_seller ON "user";
DROP FUNCTION IF EXISTS create_seller();

CREATE FUNCTION create_seller() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT * FROM auction WHERE NEW.id = id)
       THEN INSERT INTO seller(id) values (NEW.id) ;
    END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_seller
    AFTER INSERT ON "user" 
    EXECUTE PROCEDURE create_seller(); 


-- Stop all ongoing auctions when a seller is blocked
DROP TRIGGER IF EXISTS stop_ongoing_auctions ON blocks;
DROP FUNCTION IF EXISTS stop_ongoing_auctions();

CREATE FUNCTION stop_ongoing_auctions() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE auction_status 
        SET TYPE = "Cancelled"
        WHERE id_seller = NEW.id_seller AND TYPE = "Ongoing";
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER stop_ongoing_auctions
    AFTER INSERT ON blocks 
    EXECUTE PROCEDURE stop_ongoing_auctions(); 


-- Update current price on auction after a bid
DROP TRIGGER IF EXISTS update_current_price ON bids;
DROP FUNCTION IF EXISTS update_current_price();

CREATE FUNCTION update_current_price() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE auction 
        SET current_price = NEW.value
        WHERE id = NEW.id_auction;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_current_price
    AFTER INSERT ON bids 
    EXECUTE PROCEDURE update_current_price(); 


-- Send Notification to buyers when their bid is surpassed
DROP TRIGGER IF EXISTS send_notification ON bids;
DROP FUNCTION IF EXISTS send_notification();

CREATE FUNCTION send_notification() RETURNS TRIGGER AS
$BODY$

BEGIN
    SELECT auction_info.id_buyer AS id_winner, auction_info.id_auction AS id_auction , max(auction_info.value)
        FROM (SELECT value, id_auction, id_buyer
              FROM  bids
              WHERE id_auction >= NEW.id_auction) AS auction_info;
        INSERT INTO "notification" ("message", "read", id_auction, id_buyer)
            values("Your bid has been surpassed", FALSE, NEW.id_auction, NEW.id_buyer ); 
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER send_notification
    BEFORE INSERT ON bids 
    EXECUTE PROCEDURE send_notification(); 

-- Send Notification to winner when the status changes to finished
DROP TRIGGER IF EXISTS notify_winner ON bids;
DROP FUNCTION IF EXISTS notify_winner();

CREATE FUNCTION notify_winner() RETURNS TRIGGER AS
$BODY$
BEGIN
    SELECT auction_info.id_buyer AS id_winner, auction_info.id_auction AS id_auction , max(auction_info.value)
        FROM (SELECT value, id_auction, id_buyer
              FROM  bids
              WHERE id_auction >= NEW.id_auction) AS auction_info;
    
    INSERT INTO "notification" ("message", "read", id_auction, id_buyer)
        VALUES ("You won an auction", FALSE, id_auction, id_winner);
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_winner
    AFTER INSERT ON bids 
    EXECUTE PROCEDURE notify_winner(); 

--Verify 

DROP TRIGGER IF EXISTS verify_bid_value ON bids;
DROP FUNCTION IF EXISTS verify_bid_value();

CREATE FUNCTION verify_bid_value() RETURNS TRIGGER AS
$BODY$
BEGIN
    SELECT current_price FROM auction WHERE NEW.id_auction = id_auction;
    IF (NEW.value <= current_price ) 
        THEN RAISE EXCEPTION 'A bid can only be made with a value greater than the current bid';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER verify_bid_value
    BEFORE INSERT ON bids
    EXECUTE PROCEDURE verify_bid_value();
-------------------------TRANSACTIONS---------------------------

--Select Reports
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY
 
-- Get number of current reports
SELECT COUNT(*)
FROM Reports
 
-- Get first 10 reports
SELECT reports.date, report_status.TYPE, B.name, S.name
    FROM (((reports 
        JOIN report_status ON reports.id = report_status.id_reports) 
        JOIN ((buyer ON reports.id_buyer = buyer.id JOIN "user" ON user.id = buyer.id) AS B))
        JOIN ((seller ON seller.id = reports.id_seller JOIN "user" ON user.id = buyer.id) AS S))
    ORDER BY reports.date DESC
    LIMIT 10;
 
COMMIT;



