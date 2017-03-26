-- Group14 test data for database
-- The computers are taking over

-- default admin account
INSERT INTO Person (UserID, FirstName, LastName) VALUES ("admin", "Admin", "istrator");
INSERT INTO Employee (UserID) VALUES ("admin");
INSERT INTO Administrator (UserID) VALUES ("admin");
INSERT INTO Authentication (UserID, Password, Roles) VALUES ("admin", "$2y$10$gkKfX/FICyjOivkfG14dsOaSfHbX6ukGVCDuM8wCilQmKY0DD0GHe", "a");
INSERT INTO LogEntry (UserID, IP, LogDate, LogTime, ActionKey) VALUES ("admin", "localhost", CURDATE(), CURTIME(), "CreateUser");
