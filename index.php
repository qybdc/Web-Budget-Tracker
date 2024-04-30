<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = "budgettracker";


$link = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$firstDayOfMonth = date('Y-m-01');
$lastDayOfMonth = date('Y-m-t'); 

$sql = "SELECT * FROM `budget` WHERE `transDate` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' ORDER BY `transDate`";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$BudgetTotal = 0;
$HousingTotal = 0;
$UtilitiesTotal = 0;
$FoodTotal = 0;
$TransTotal = 0;
$HealthTotal = 0;
$DebtReTotal = 0;
$SavingsTotal = 0;
$PersonalTotal = 0;
$OtherTotal = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $Category = $row['Category'];
    $Amount = $row['Amount'];
    $transDate = $row['transDate'];
    $Desc = $row['Description'];
    $Type = $row['Type'];
    $paymentMethod = $row['paymentMethod'];

    if ($Type == "Expense") {
        $BudgetTotal += $Amount;
    } else {
        $BudgetTotal -= $Amount;
    }

    if ($Category == "Housing") {
        if ($Type == "Expense") {
            $HousingTotal += $Amount;
        } else {
            $HousingTotal -= $Amount;
        }
        
    } elseif ($Category == "Utilities") {
        if ($Type == "Expense") {
            $UtilitiesTotal += $Amount;
        } else {
            $UtilitiesTotal -= $Amount;
        }
        
    } elseif ($Category == "Food") {
        if ($Type == "Expense") {
            $FoodTotal += $Amount;
        } else {
            $FoodTotal -= $Amount;
        }
        
    } elseif ($Category == "Transportation") {
        if ($Type == "Expense") {
            $TransTotal += $Amount;
        } else {
            $TransTotal -= $Amount;
        }
        
    } elseif ($Category == "Healthcare") {
        if ($Type == "Expense") {
            $HealthTotal += $Amount;
        } else {
            $HealthTotal -= $Amount;
        }
        
    } elseif ($Category == "Debt Repayment") {
        if ($Type == "Expense") {
            $DebtReTotal += $Amount;
        } else {
            $DebtReTotal -= $Amount;
        }
        
    } elseif ($Category == "Savings") {
        if ($Type == "Expense") {
            $SavingsTotal += $Amount;
        } else {
            $SavingsTotalTotal -= $Amount;
        }
        
    } elseif ($Category == "Personal") {
        if ($Type == "Expense") {
            $PersonalTotal += $Amount;
        } else {
            $PersonalTotal -= $Amount;
        }
        
    } elseif ($Category == "Other") {
        if ($Type == "Expense") {
            $OtherTotal += $Amount;
        } else {
            $OtherTotal -= $Amount;
        }
        
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "INSERT INTO budget (Category, Amount, transDate, Description, Type, paymentMethod) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, 'sdssss', $param_Category, $param_Amount, $param_transDate, $param_Desc, $param_Type, $param_paymentMethod);
    }

    $param_Category = $_POST["category"];
    $param_Amount = $_POST["amount"];
    $param_transDate = $_POST["transDate"];
    $param_Desc = $_POST["description"];
    $param_Type = $_POST["type"];
    $param_paymentMethod = $_POST["paymentMethod"];

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <h1>Budget Tracker: "Current Month"</h1>
    <h2>Budget</h2>
    <h2>$<?=$BudgetTotal?></h2>

    <div class="categoryBudget">
        <div class="categoryItem">
            <h3>Housing</h3>
            <p>$1000</p>
            <p>$<?= $HousingTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Utilities</h3>
            <p>$1000</p>
            <p>$<?= $UtilitiesTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Food</h3>
            <p>$1000</p>
            <p>$<?= $FoodTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Transportation</h3>
            <p>$1000</p>
            <p>$<?=$TransTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Healthcare</h3>
            <p>$1000</p>
            <p>$<?=$HealthTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Debt Repayment</h3>
            <p>$1000</p>
            <p>$<?=$DebtReTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Savings</h3>
            <p>$1000</p>
            <p>$<?=$SavingsTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Personal</h3>
            <p>$1000</p>
            <p>$<?$PersonalTotal?></p>
        </div>
        <div class="categoryItem">
            <h3>Other</h3>
            <p>$1000</p>
            <p>$<?=$OtherTotal?></p>
        </div>
    </div>

    <h3>Add transactions</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="formItem">
            <label>Category:</label>
            <select name="category" id="category" required>
                <option disabled selected></option>
                <option>Housing</option>
                <option>Utilities</option>
                <option>Food</option>
                <option>Transportation</option>
                <option>Healthcare</option>
                <option>Dept Repayment</option>
                <option>Savings</option>
                <option>Personal</option>
                <option>Other</option>
            </select>
        </div>
        <div class="formItem">
            <label>Amount:</label>
            <input type="number" id="amount" name="amount" step="0.01" min="0" required>
        </div>
        <div class="formItem">
            <label>Transaction Date:</label>
            <input type="date" id="transDate" name="transDate" required>
        </div>
        <div class="formItem">
            <label>Description:</label>
            <input type="text" id="description" name="description" required>
        </div>
        <div class="formItem">
            <label>Type:</label>
            <select id="type" name="type" required>
                <option disabled selected></option>
                <option>Income</option>
                <option>Expense</option>
            </select>
        </div>
        <div class="formItem">
            <label>Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod" required>
                <option disabled selected></option>
                <option>Credit</option>
                <option>Debit</option>
                <option>Cash</option>
                <option>Transfer</option>
                <option>Other</option>
            </select>
        </div>
        <div class="formItem">
            <input type="submit" value="Submit">
        </div>
    </form>



    <h3>Transactions</h3>
    <div class="transactionContainer">
        <div class="transactionItem">
            <h3>Category</h3>
            <h3>Amount</h3>
            <h3>Transaction Date</h3>
            <h3>Description</h3>
            <h3>Type</h3>
            <h3>Payment Method</h3>
        </div>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $Category = $row['Category'];
            $Amount = $row['Amount'];
            $transDate = $row['transDate'];
            $Desc = $row['Description'];
            $Type = $row['Type'];
            $paymentMethod = $row['paymentMethod'];
            echo "<div class='transactionItem'>";
            echo "<p>" . $Category . "</p>";
            echo "<p>" . $Amount . "</p>";
            echo "<p>" . $transDate . "</p>";
            echo "<p>" . $Desc . "</p>";
            echo "<p>" . $Type . "</p>";
            echo "<p>" . $paymentMethod . "</p>";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>