-- Types
 
CREATE TYPE "Rating" AS ENUM ('1', '2', '3', '4', '5');
CREATE TYPE "Shipping" AS ENUM ('Standard Mail', 'Express Mail', 'Urgent Mail');
CREATE TYPE "Payment" AS ENUM ('Debit Card', 'PayPal');
CREATE TYPE Skill AS ENUM ('Climbs', 'Jumps', 'Talks', 'Skates', 'Olfaction', 'Moonlight Navigation', 'Echolocation', 'Acrobatics');
CREATE TYPE "Color" AS ENUM ('Blue', 'Brown', 'Black', 'Yellow', 'Green', 'Red', 'White');
CREATE TYPE "DevStage" AS ENUM ('Baby', 'Child', 'Teen', 'Adult', 'Elderly');
CREATE TYPE Category AS ENUM ('Mammals', 'Insects', 'Reptiles', 'Fishes', 'Birds', 'Amphibians');

 
-- Tables

CREATE TABLE "User"
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    email text NOT NULL,
    "hashedPassword" text NOT NULL,
    CONSTRAINT "emailUK" UNIQUE (email)
);

CREATE TABLE "Admin"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "User" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Buyer"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "User" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Seller"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "User" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    rating integer NOT NULL,
    CONSTRAINT "ratingCK" CHECK (rating >= 1 AND rating <= 5)
);

CREATE TABLE "Skill"
(
    id SERIAL PRIMARY KEY,
    name Skill NOT NULL
);

CREATE TABLE "MainColor"
(
    id SERIAL PRIMARY KEY,
    name "Color" NOT NULL
);

CREATE TABLE "DevelopmentStage"
(
    id SERIAL PRIMARY KEY,
    name "DevStage" NOT NULL
);

CREATE TABLE "Category"
(
    id SERIAL PRIMARY KEY,
    name Category NOT NULL
);

CREATE TABLE "PaymentMethod"
(
    id SERIAL PRIMARY KEY,
    name "Payment" NOT NULL
);

CREATE TABLE "ShippingMethod"
(
    id SERIAL PRIMARY KEY,
    name "Shipping" NOT NULL
);

CREATE TABLE "Auction"
(
    id SERIAL PRIMARY KEY,
    name text NOT NULL,
    description text NOT NULL,
    "speciesName" text NOT NULL,
    age integer NOT NULL,
    "startingPrice" integer NOT NULL,
    "buyoutPrice" integer,
    "endingDate" date NOT NULL,
    "ratingSeller" "Rating",
    "idCategory" integer NOT NULL REFERENCES "Category" (id) ON UPDATE CASCADE,
    "idMainColor" integer NOT NULL REFERENCES "MainColor" (id) ON UPDATE CASCADE,
    "idDevStage" integer NOT NULL REFERENCES "DevelopmentStage" (id) ON UPDATE CASCADE,
    "idPaymentMethod" integer REFERENCES "PaymentMethod" (id) ON UPDATE CASCADE,
    "idShippingMethod" integer REFERENCES "ShippingMethod" (id) ON UPDATE CASCADE,
    "idSeller" integer NOT NULL REFERENCES "Seller" (id) ON UPDATE CASCADE,
    "idWinner" integer REFERENCES "Buyer" (id) ON UPDATE CASCADE,
    CONSTRAINT "endingDateCK" CHECK ("endingDate" > 'now'::text::date),
    CONSTRAINT "buyoutPriceCK" CHECK ("buyoutPrice" > "startingPrice")
);

CREATE TABLE "Bids"
(
    id SERIAL PRIMARY KEY,
    value integer NOT NULL,
    maximum integer,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE,
    "idBuyer" integer REFERENCES "Buyer" (id) ON UPDATE CASCADE,
    CONSTRAINT "maximumCK" CHECK ("maximum" >= value)
);

CREATE TABLE "Notification"
(
    id SERIAL PRIMARY KEY,
    "message" text NOT NULL,
    "type" text NOT NULL,
    "read" boolean DEFAULT FALSE,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE,
    "idBuyer" integer REFERENCES "Buyer" (id) ON UPDATE CASCADE
);

CREATE TABLE "Blocks"
(
    id SERIAL PRIMARY KEY,
    "endDate" date,
    "idAdmin" integer NOT NULL REFERENCES "Admin" (id) ON UPDATE CASCADE,
    "idSeller" integer NOT NULL REFERENCES "Seller" (id) ON UPDATE CASCADE,
    CONSTRAINT "endDateCK" CHECK ("endDate" > 'now'::text::date)
);

CREATE TABLE "Ships"
(
    id SERIAL PRIMARY KEY,
    "idSeller" integer NOT NULL REFERENCES "Seller" (id) ON UPDATE CASCADE,
    "idShippingMethod" integer NOT NULL REFERENCES "ShippingMethod" (id) ON UPDATE CASCADE
);

CREATE TABLE "Accepts"
(
    id SERIAL PRIMARY KEY,
    "idSeller" integer NOT NULL REFERENCES "Seller" (id) ON UPDATE CASCADE,
    "idPaymentMethod" integer NOT NULL REFERENCES "PaymentMethod" (id) ON UPDATE CASCADE
);

CREATE TABLE "Reports"
(
    id SERIAL PRIMARY KEY,
    "date" date NOT NULL DEFAULT 'now'::text::date,
    "idBuyer" integer NOT NULL REFERENCES "Buyer" (id) ON UPDATE CASCADE,
    "idSeller" integer NOT NULL REFERENCES "Seller" (id) ON UPDATE CASCADE
);

CREATE TABLE "ReportStatus"
(
    id SERIAL PRIMARY KEY,
    "idReports" integer NOT NULL REFERENCES "Reports" (id) ON UPDATE CASCADE
);

CREATE TABLE "ReportPending"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "ReportStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "ReportApproved"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "ReportStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "ReportDenied"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "ReportStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Watchlists"
(
    id SERIAL PRIMARY KEY,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE,
    "idBuyer" integer NOT NULL REFERENCES "Buyer" (id) ON UPDATE CASCADE
);

CREATE TABLE "Features"
(
    id SERIAL PRIMARY KEY,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE,
    "idSkill" integer NOT NULL REFERENCES "Skill" (id) ON UPDATE CASCADE
);

CREATE TABLE "AuctionStatus"
(
    id SERIAL PRIMARY KEY,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE
);

CREATE TABLE "AuctionOngoing"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "AuctionStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "AuctionCancelled"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "AuctionStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "AuctionFinished"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "AuctionStatus" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Image"
(
    id SERIAL PRIMARY KEY,
    url text NOT NULL
);

CREATE TABLE "ProfilePhoto"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "Image" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    "idUser" integer NOT NULL REFERENCES "User" (id) ON UPDATE CASCADE
);

CREATE TABLE "AnimalPhoto"
(
    id integer NOT NULL PRIMARY KEY REFERENCES "Image" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    "idAuction" integer NOT NULL REFERENCES "Auction" (id) ON UPDATE CASCADE
);
