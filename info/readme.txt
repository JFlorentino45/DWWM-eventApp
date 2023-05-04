bob@bob.com A
fred@fred.fr O
third@third.com P
john@john.com P
paul@paul.com P
new@new.com P

Bugs:

ToDo:
change getnavitems



DELIMITER $$
CREATE PROCEDURE loginGetUser(IN userEmail VARCHAR(255))
BEGIN
    SELECT * FROM user WHERE email = userEmail;
END $$
DELIMITER ;