bob@bob.com A
fred@fred.fr O
third@third.com P
john@john.com P
paul@paul.com P
new@new.com P

sql test for home page
SELECT \*
FROM event LEFT JOIN participate on event.eventID=participate.eventID
AND participate.userID;

SELECT event.\*,
(CASE WHEN p.userID IS NULL THEN 'Not signed up' ELSE 'Signed up' END) AS signedUp
FROM event LEFT JOIN participate p ON event.eventID=p.eventID AND p.userID=63;

Bugs:
page=editVenue this no ID error (as Admin)
editEvent bug when trying to edit as Admin
