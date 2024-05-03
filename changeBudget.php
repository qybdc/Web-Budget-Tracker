<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = "budgettracker";

$link = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM userbudget";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $Housing = $row['Housing'];
    $Utilities = $row['Utilities'];
    $Food = $row['Food'];
    $Transportation = $row['Transportation'];
    $Healthcare = $row['Healthcare'];
    $DebtRepay = $row['DebtRepay'];
    $Savings = $row['Savings'];
    $Personal = $row['Personal'];
    $Other = $row['Other'];
    $Total = $row['Total'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $housing = $_POST["housing"];
    $utilities = $_POST["utilities"];
    $food = $_POST["food"];
    $transportation = $_POST["transportation"];
    $healthcare = $_POST["healthcare"];
    $personal = $_POST["personal"];
    $other = $_POST["other"];
    $debtrepay = $_POST["debtrepay"];
    $savings = $_POST["savings"];

    $total = $housing + $utilities + $food + $transportation + $healthcare + $personal + $other + $debtrepay + $savings;

    $query = "UPDATE userbudget SET Housing=?, Utilities=?, Food=?, Transportation=?, Healthcare=?, Personal=?, Other=?, DebtRepay=?, Savings=?, Total=? WHERE id=1";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, 'dddddddddd', $housing, $utilities, $food, $transportation, $healthcare, $personal, $other, $debtrepay, $savings, $total);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: changeBudget.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="changeBudget.js"></script>
    <title>Update Budget Amounts</title>
</head>
<body>
    <h1>Update Budget Amounts</h1>
    <h2>Recommended Distribution: 50/30/20</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="flex-container">
            <div class="card" id="needs-container">
                <h3 id="needs">Needs</h3>
                <label for="housing">Housing:</label>
                <input type="number" id="housing" name="housing" value="<?= $Housing ?>" step="0.01">
                <label for="utilities">Utilities:</label>
                <input type="number" id="utilities" name="utilities" value="<?= $Utilities ?>" step="0.01">
                <label for="food">Food:</label>
                <input type="number" id="food" name="food" value="<?= $Food ?>" step="0.01">
                <label for="transportation">Transportation:</label>
                <input type="number" id="transportation" name="transportation" value="<?= $Transportation ?>" step="0.01">
                <label for="healthcare">Healthcare:</label>
                <input type="number" id="healthcare" name="healthcare" value="<?= $Healthcare ?>" step="0.01">
            </div>
            <div class="card" id="wants-container">
                <h3 id="wants">Wants</h3>
                <label for="personal">Personal:</label>
                <input type="number" id="personal" name="personal" value="<?= $Personal ?>" step="0.01">
                <label for="other">Other:</label>
                <input type="number" id="other" name="other" value="<?= $Other ?>" step="0.01">
            </div>
            <div class="card" id="savings-debt-container">
                <h3 id="savings-debt">Savings/Debt Repayment</h3>
                <label for="debtrepay">Debt Repayment:</label>
                <input type="number" id="debtrepay" name="debtrepay" value="<?= $DebtRepay ?>" step="0.01">
                <label for="savings">Savings:</label>
                <input type="number" id="savings" name="savings" value="<?= $Savings ?>" step="0.01">
            </div>
        </div>
        <h2 id="total">Total: $0.00</h2>
        <input type="submit" value="Update Budget">
    </form>
</body>
</html>
