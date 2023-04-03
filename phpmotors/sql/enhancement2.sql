-- QUERY 1 
INSERT INTO clients
	(clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES 
	("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman");


-- QUERY 2
UPDATE 
	clients 
SET 
	clientLevel = 3
WHERE 
	clientFirstname = "Tony" AND clientLastname = "Stark";


-- QUERY 3
UPDATE 
	inventory
SET 
	invDescription = REPLACE(invDescription, "small interior", "spacious interior")
WHERE
	invId = 12;


-- QUERY 4
SELECT 
	inventory.invModel, carclassification.classificationName 
FROM 
	inventory
INNER JOIN 
	carclassification 
ON 
	inventory.classificationId = carclassification.classificationId
WHERE 
	carclassification.classificationName = "SUV";


-- QUERY 5
DELETE FROM 
	inventory
WHERE 
    invId = 1;


-- QUERY 6
UPDATE 
	inventory
SET 
	invImage = CONCAT("/phpmotors", invImage),
    invThumbnail = CONCAT("/phpmotors", invThumbnail);