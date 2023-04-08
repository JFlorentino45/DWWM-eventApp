bob@bob.com A
fred@fred.fr O
third@third.com P
john@john.com P
paul@paul.com P
new@new.com P

Bugs:
Fix case where anyone types an ID in the url that doesn't exist
changing ID in url (editEvent) as organiser no redirect to forbidden (can copy from editUser)
Add check and error for newUser when using an existing email

ToDo:
fix Bugs
add lots of events and users
create filters and test (seats available logic)
htaccess
CSS
refactoring



DELIMITER $$
CREATE PROCEDURE loginGetUser(IN userEmail VARCHAR(255))
BEGIN
    SELECT * FROM user WHERE email = userEmail;
END $$
DELIMITER ;