SELECT familyName FROM Laureate L, nobelPrizes N
WHERE N.lid = L.id
GROUP BY L.familyName
HAVING COUNT(familyName) >= 5
