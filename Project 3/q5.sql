SELECT COUNT(awardYear) FROM (SELECT DISTINCT awardYear FROM nobelPrizes N
WHERE N.lid IN (SELECT id FROM Laureate EXCEPT SELECT id FROM Laureate WHERE gender="male" OR gender="female")) AS T;