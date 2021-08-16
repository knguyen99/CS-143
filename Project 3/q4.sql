SELECT COUNT(city) FROM 
(
    SELECT * FROM affiliations
    WHERE name="University of California"
    GROUP BY city
) as T;

