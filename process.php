<?php
include("db_config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add_customer') {
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $accountType = $_POST['account_type'];
        $balance = $_POST['balance'];

        $stmt = $conn->prepare("INSERT INTO Customers (FullName, Email, Phone, Address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $address);
        $stmt->execute();
        $customerID = $stmt->insert_id;

        $stmt2 = $conn->prepare("INSERT INTO Accounts (CustomerID, AccountType, Balance) VALUES (?, ?, ?)");
        $stmt2->bind_param("isd", $customerID, $accountType, $balance);
        $stmt2->execute();

        echo "Customer and account added successfully!";
    }

    if ($action == 'view_account') {
        $accountNumber = $_POST['account_number'];
        $sql = "SELECT a.AccountNumber, c.FullName, a.AccountType, a.Balance
                FROM Accounts a JOIN Customers c ON a.CustomerID = c.CustomerID
                WHERE a.AccountNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $accountNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo "<h3>Account Details:</h3>";
            echo "Name: " . $row['FullName'] . "<br>";
            echo "Account Type: " . $row['AccountType'] . "<br>";
            echo "Balance: ₹" . $row['Balance'] . "<br>";
        } else {
            echo "Account not found.";
        }
    }
}
?>