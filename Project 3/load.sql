DROP TABLE IF EXISTS Laureate;
DROP TABLE IF EXISTS nobelPrizes;
DROP TABLE IF EXISTS affiliations;

CREATE TABLE Laureate(
    id INT PRIMARY KEY,
    name VARCHAR(100),
    familyName VARCHAR(100),
    gender VARCHAR(6),
    bDate date,
    city VARCHAR(40),
    country VARCHAR(40) 
);

CREATE TABLE nobelPrizes(
    lid INT,
    awardYear INT(4),
    category VARCHAR(60),
    sortOrder VARCHAR(1),
    portion VARCHAR(3),
    dateAwarded date,
    prizeStatus VARCHAR(20),
    motivation TEXT,
    prizeAmount INT,
    PRIMARY KEY (lid, awardYear, category)
);

CREATE TABLE affiliations(
    name VARCHAR(200),
    lid INT,
    awardYear INT,
    category VARCHAR(60),
    city VARCHAR(60),
    country VARCHAR(60),
    PRIMARY KEY(name, lid,awardYear, category)
);

LOAD DATA LOCAL INFILE './laureates.del' INTO TABLE Laureate
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE './nobelPrizes.del' INTO TABLE nobelPrizes
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE './affiliations.del' INTO TABLE affiliations
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';

