-- Group 14 CREATE TABLE statements

DROP TABLE IF EXISTS Destination;
DROP TABLE IF EXISTS Departure;
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS EngineHistory;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS Equipment;
DROP TABLE IF EXISTS ConductorHistory;
DROP TABLE IF EXISTS EngineerHistory;
DROP TABLE IF EXISTS Train;
DROP TABLE IF EXISTS Conductor;
DROP TABLE IF EXISTS Engineer;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Authentication;
DROP TABLE IF EXISTS Employee;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS LogEntry;
DROP TABLE IF EXISTS Person;

CREATE TABLE Person (
    UserID VARCHAR(50),
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Graveyard BOOLEAN DEFAULT false,
    CONSTRAINT PKPerson PRIMARY KEY (UserID)
);

CREATE TABLE LogEntry (
    LogNumber INT AUTO_INCREMENT,
    IP VARCHAR(50),
    LogDate DATE,
    LogTime TIME,
    ActionKey VARCHAR(255),
    UserID VARCHAR(50),
    CONSTRAINT PKLogEntry PRIMARY KEY (LogNumber, UserID),
    FOREIGN KEY (UserID) REFERENCES Person (UserID)
);

CREATE TABLE Customer (
    CompanyID VARCHAR(50),
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Person (UserID) ON DELETE CASCADE,
    CONSTRAINT PKCustomer PRIMARY KEY (UserID)
);

CREATE TABLE Employee (
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Person (UserID) ON DELETE CASCADE,
    CONSTRAINT PKEmployee PRIMARY KEY (UserID)
);

CREATE TABLE Authentication (
    Password VARCHAR(255),
    Roles VARCHAR(50),
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Employee (UserID) ON DELETE CASCADE,
    CONSTRAINT PKAuthentication PRIMARY KEY (UserID)
);

CREATE TABLE Administrator (
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Employee (UserID) ON DELETE CASCADE,
    CONSTRAINT PKAdministrator PRIMARY KEY (UserID)
);

CREATE TABLE Engineer (
    Status BOOLEAN DEFAULT true,
    Rank VARCHAR(50),
    Hours INT,
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Employee (UserID) ON DELETE CASCADE,
    CONSTRAINT PKEngineer PRIMARY KEY (UserID)
);

CREATE TABLE Conductor (
    Status BOOLEAN DEFAULT true,
    Rank VARCHAR(50),
    UserID VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES Employee (UserID) ON DELETE CASCADE,
    CONSTRAINT PKConductor PRIMARY KEY (UserID)
);

CREATE TABLE Train (
    TrainNumber INT AUTO_INCREMENT,
    DepartureTime TIME,
    DepartureDate DATE,
    CONSTRAINT PKTrain PRIMARY KEY (TrainNumber)
);

CREATE TABLE EngineerHistory (
    UserID VARCHAR(50),
    TrainNumber INT,
    FOREIGN KEY (UserID) REFERENCES Engineer (UserID),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    CONSTRAINT PKEngineerHistory PRIMARY KEY (UserID, TrainNumber)
);

CREATE TABLE ConductorHistory (
    UserID VARCHAR(50),
    TrainNumber INT,
    FOREIGN KEY (UserID) REFERENCES Conductor (UserID),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    CONSTRAINT PKConductorHistory PRIMARY KEY (UserID, TrainNumber)
);

CREATE TABLE Equipment (
    SerialNumber INT,
    Type INT,
    Price DECIMAL(10,2),
    Manufacturer VARCHAR(50),
    CONSTRAINT PKEquipment PRIMARY KEY (SerialNumber)
);

CREATE TABLE Reservation (
    TrainNumber INT,
    SerialNumber INT,
    UserID VARCHAR(50),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    FOREIGN KEY (SerialNumber) REFERENCES Equipment (SerialNumber),
    FOREIGN KEY (UserID) REFERENCES Customer (UserID),
    CONSTRAINT PKReservation PRIMARY KEY (TrainNumber, SerialNumber, UserID)
);

CREATE TABLE EngineHistory (
    SerialNumber INT,
    TrainNumber INT,
    FOREIGN KEY (SerialNumber) REFERENCES Equipment (SerialNumber),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    CONSTRAINT PKEngineHistory PRIMARY KEY (SerialNumber, TrainNumber)
);

CREATE TABLE Location (
    Zip CHAR(5),
    Address VARCHAR(100),
    Name VARCHAR(50),
    City VARCHAR(50),
    State CHAR(2),
    CONSTRAINT PKLocation PRIMARY KEY (Zip, Address)
);

CREATE TABLE Destination (
    Zip CHAR(5),
    Address VARCHAR(100),
    TrainNumber INT,
    FOREIGN KEY (Zip, Address) REFERENCES Location (Zip, Address),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    CONSTRAINT PKDestination PRIMARY KEY (Zip, Address, TrainNumber)
 );
 
 CREATE TABLE Departure (
    Zip CHAR(5),
    Address VARCHAR(100),
    TrainNumber INT,
    FOREIGN KEY (Zip, Address) REFERENCES Location (Zip, Address),
    FOREIGN KEY (TrainNumber) REFERENCES Train (TrainNumber),
    CONSTRAINT PKDeparture PRIMARY KEY (Zip, Address, TrainNumber)
 );
