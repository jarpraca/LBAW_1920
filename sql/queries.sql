PRAGMA foreign_keys = ON;

--View Profile 01
SELECT name, email, url
    FROM ("user" LEFT JOIN (profile_photo NATURAL JOIN "image") ON "user".id = profile_photo.id_user)
    WHERE "user".id = $id_user;

--Search for Auctions with filters 02
SELECT DISTINCT auction.id, species_name, current_price, age, ending_date
    FROM ((auction JOIN features ON auction.id = features.id_auction) JOIN auction_status ON auction.id = auction_status.id_auction)
    WHERE   (id_category = $category OR $category IS NULL)
        AND (id_main_color = $main_color OR $main_color IS NULL)
        AND (id_dev_stage = $dev_stage OR $dev_stage IS NULL)
        AND (current_price < $max_price OR $max_price IS NULL)
        AND (id_skill IN ($climbs, $jumps, $talks, $skates, $olfaction, $navigation, $echo, $acrobatics))
        AND auction_status.TYPE = 'Ongoing'
    ORDER BY ending_date;

--Full Text Search Auction 03
SELECT auction.id, species_name, current_price, age, ending_date, ts_rank_cd(textsearch, query) AS rank
    FROM (auction JOIN auction_status ON auction.id = auction_status.id_auction), to_tsquery($search) AS query, 
        to_tsvector(name || ' ' || species_name || ' ' || description ) AS textsearch
    WHERE query @@ textsearch AND auction_status.TYPE = 'Ongoing'
    ORDER BY rank DESC;

--Full Text Search Admin 04
SELECT "name", email, ts_rank_cd(textsearch, query) AS rank
    FROM "user", to_tsquery($search) AS query, 
        to_tsvector(name || ' ' || email) AS textsearch
    WHERE query @@ textsearch 
    ORDER BY rank DESC;

--Homepage Top 3 Auctions 05
SELECT auctions.id, auctions.species_name, auctions.current_price, auctions.age, auctions.ending_date
    FROM (SELECT auction.*, count(*) AS num_bids
            FROM  ((auction JOIN bids ON auction.id = bids.id_auction) JOIN auction_status ON auction.id = auction_status.id_auction)
            WHERE auction_status.TYPE = 'Ongoing'
            GROUP BY  auction.id) AS auctions
    ORDER BY num_bids DESC
    LIMIT 3;

-- View Notifications 06
SELECT *
    FROM "notification"
    WHERE id_buyer = $id_buyer
    ORDER BY id DESC
    LIMIT 5;

        --temos de rever a tabela, nao me lembro de ver la nada de notificações

--View Auction 07
SELECT auction.*, skill.TYPE, category.TYPE, main_color.TYPE, development_stage.TYPE
    FROM ((((auction JOIN features ON auction.id = features.id_auction) 
            JOIN skill ON skill.id = features.id_skill) 
            JOIN category ON category.id = auction.id_category)
            JOIN main_color ON main_color.id = auction.id_main_color)
            JOIN development_stage ON development_stage.id = auction.id_dev_stage
    WHERE auction.id = $id_auction;


-- View Watchlisted Auctions 08
SELECT auction.id, species_name, current_price, age, ending_date
    FROM (watchlists JOIN auction ON auction.id = watchlists.id_auction) JOIN auction_status ON auction.id = auction_status.id_auction
    WHERE watchlists.id_buyer = $id_buyer AND auction_status.TYPE = 'Ongoing'
    ORDER BY ending_date;

-- View My Auctions 09
SELECT auction.id, species_name, current_price, age, ending_date
    FROM auction JOIN auction_status ON auction.id = auction_status.id_auction
    WHERE auction.id_seller = $id_seller AND auction_status.TYPE = 'Ongoing'
    ORDER BY ending_date;

-- View Purchase History 10
SELECT auction.id, species_name, current_price, age, ending_date
    FROM auction JOIN auction_status ON auction.id = auction_status.id_auction
    WHERE auction.id_winner = $id_buyer AND auction_status.TYPE = 'Finished'
    ORDER BY ending_date DESC;

-- View Bidded Ongoing Auctions 11
SELECT DISTINCT auction.id, species_name, current_price, age, ending_date
    FROM (auction JOIN auction_status ON auction.id = auction_status.id_auction) JOIN bids ON bids.id_auction = auction.id
    WHERE bids.id_buyer = $id_buyer AND auction_status.TYPE = 'Ongoing'
    ORDER BY ending_date;

-- View Last 5 Bids Of Auction (first one is the current price)
SELECT bids.value, "user".name
    FROM (bids JOIN "user" ON "user".id = id_buyer)
    WHERE bids.id_auction = $id_auction
    ORDER BY bids.id DESC
    LIMIT 5;

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


--Update read status in notification
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

--SELECT03
 CREATE INDEX search_auction ON auction USING GIST (to_tsvector('english', name || ' ' || species_name || ' ' || description ));

--SELECT04
 CREATE INDEX admin_search ON "user" USING GIST (to_tsvector('english',name || ' ' || email));


--SELECT06
 CREATE INDEX notification_id ON "notification" USING hash(id_buyer);

--SELECT08
CREATE INDEX watchlists_id ON watchlists USING hash(id_buyer);

--SELECT09
CREATE INDEX auction_id ON auction USING hash(id_seller);

--SELECT11

CREATE INDEX bids_id ON bids USING hash(id_buyer);

    
-------------------------TRANSACTIONS---------------------------

--Select Reports
BEGIN TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;
 
-- Get number of current reports
SELECT COUNT(*)
FROM Reports;
 
-- Get first 10 reports
SELECT reports.date, report_status.TYPE, B.name, "user".name
FROM ((((SELECT "user".name AS name, buyer.id AS id FROM buyer JOIN "user" ON "user".id = buyer.id) AS B
    JOIN reports ON reports.id_buyer = B.id) JOIN report_status ON report_status.id_reports = reports.id)
    JOIN seller ON reports.id_seller = seller.id JOIN "user" ON "user".id = seller.id)
ORDER BY reports.date DESC
LIMIT 10;

COMMIT;


--Select Auction
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

--View Auction, including current price
SELECT auction.*, skill.TYPE, category.TYPE, main_color.TYPE, development_stage.TYPE
    FROM ((((auction JOIN features ON auction.id = features.id_auction) 
            JOIN skill ON skill.id = features.id_skill) 
            JOIN category ON category.id = auction.id_category)
            JOIN main_color ON main_color.id = auction.id_main_color)
            JOIN development_stage ON development_stage.id = auction.id_dev_stage
    WHERE auction.id = $id_auction;

-- View Last 5 Bids Of Auction (first one is the current price)
SELECT bids.value, "user".name
    FROM (bids JOIN "user" ON "user".id = id_buyer)
    WHERE bids.id_auction = $id_auction
    ORDER BY bids.id DESC
    LIMIT 5;

COMMIT;


--Select Auctions in Profile
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

-- View Purchase History 10
SELECT auction.id, species_name, current_price, age, ending_date
    FROM auction JOIN auction_status ON auction.id = auction_status.id_auction
    WHERE auction.id_winner = $id_buyer AND auction_status.TYPE = 'Finished'
    ORDER BY ending_date DESC;

-- View Bidded Ongoing Auctions 11
SELECT DISTINCT auction.id, species_name, current_price, age, ending_date
    FROM (auction JOIN auction_status ON auction.id = auction_status.id_auction) JOIN bids ON bids.id_auction = auction.id
    WHERE bids.id_buyer = $id_buyer AND auction_status.TYPE = 'Ongoing'
    ORDER BY ending_date;

COMMIT;