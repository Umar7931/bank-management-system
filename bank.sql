CREATE DATABASE BankDB;
USE BankDB;

CREATE TABLE Customers (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(15),
    Address TEXT
);

CREATE TABLE Accounts (
    AccountNumber INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    AccountType VARCHAR(20),
    Balance DECIMAL(10,2),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);