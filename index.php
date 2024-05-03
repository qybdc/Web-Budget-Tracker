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

date_default_timezone_set('America/New_York');
$firstDayOfMonth = date('Y-m-01');
$lastDayOfMonth = date('Y-m-t');

$sql = "SELECT * FROM `budget` WHERE `transDate` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' ORDER BY `transDate`";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);



// Calculate totals for each category
$BudgetTotal = $HousingTotal = $UtilitiesTotal = $FoodTotal = $TransTotal = $HealthTotal = $DebtReTotal = $SavingsTotal = $PersonalTotal = $OtherTotal = 0;
$HousingTotal2 = $UtilitiesTotal2 = $FoodTotal2 = $TransTotal2 = $HealthTotal2 = $DebtReTotal2 = $SavingsTotal2 = $PersonalTotal2 = $OtherTotal2 = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $Category = $row['Category'];
    $Amount = $row['Amount'];
    $transDate = $row['transDate'];
    $Desc = $row['Description'];
    $Type = $row['Type'];
    $paymentMethod = $row['paymentMethod'];

    $transactions[] = array(
        'Category' => $Category,
        'Amount' => $Amount,
        'transDate' => $transDate,
        'Description' => $Desc,
        'Type' => $Type,
        'paymentMethod' => $paymentMethod
    );

    if ($Type == "Expense") {
        $BudgetTotal += $Amount;
    } else {
        $BudgetTotal -= $Amount;
    }

    if ($Category == "Housing") {
        if ($Type == "Expense") {
            $HousingTotal += $Amount;
            $HousingTotal2 += $Amount;
        } else {
            $HousingTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Utilities") {
        if ($Type == "Expense") {
            $UtilitiesTotal += $Amount;
            $UtilitiesTotal2 += $Amount;
        } else {
            $UtilitiesTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Food") {
        if ($Type == "Expense") {
            $FoodTotal += $Amount;
            $FoodTotal2 += $Amount;
        } else {
            $FoodTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Transportation") {
        if ($Type == "Expense") {
            $TransTotal += $Amount;
            $TransTotal2 += $Amount;
        } else {
            $TransTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Healthcare") {
        if ($Type == "Expense") {
            $HealthTotal += $Amount;
            $HealthTotal2 += $Amount;
        } else {
            $HealthTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Debt Repayment") {
        if ($Type == "Expense") {
            $DebtReTotal += $Amount;
            $DebtReTotal2 += $Amount;
        } else {
            $DebtReTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Savings") {
        if ($Type == "Expense") {
            $SavingsTotal += $Amount;
            $SavingsTotal2 += $Amount;
        } else {
            $SavingsTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Personal") {
        if ($Type == "Expense") {
            $PersonalTotal += $Amount;
            $PersonalTotal2 += $Amount;
        } else {
            $PersonalTotal -= $Amount;
            $Total += $Amount;
        }
    } elseif ($Category == "Other") {
        if ($Type == "Expense") {
            $OtherTotal += $Amount;
            $OtherTotal2 += $Amount;
        } else {
            $OtherTotal -= $Amount;
            $Total += $Amount;
        }
    }
}



// Get input for new transaction
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
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="budgettracker.js"></script>
    <script src="toggleVisibility.js"></script>
    <script src="pieChart.js"></script>
    <title>Budget Tracker</title>

</head>

<body>
    <a href="changeBudget.php" class="change-budget-btn">Change Budget</a>
    <h1>Budget Tracker: <?php echo date('F'); ?></h1>
    <div class="totalContainer">
        <h2>Total Budget</h2>
        <h2>$<span id="totalBudget"><?= number_format($Total, 2) ?></span></h2>
        <h2>Total Spent</h2>
        <h2>$<span id="totalSpent"><?= number_format($BudgetTotal, 2) ?></span></h2>
    </div>
    <?php
    $NeedsTotal = $HousingTotal + $UtilitiesTotal + $FoodTotal + $TransTotal + $HealthTotal;
    $WantsTotal = $PersonalTotal + $OtherTotal;
    $SavingsDebtRepaymentTotal = $DebtReTotal + $SavingsTotal;
    $Needs = $Housing + $Utilities + $Food + $Transportation + $Healthcare;
    $Wants = $Personal + $Other;
    $SavingsDebtRepayment = $Savings + $DebtRepay;
    ?>

    <div class="section" id="needsSection">
        <h3 onclick="toggleVisibility('needs')">Needs (<?= number_format(($Needs/$Total) * 100, 2) ?>%): $<?= number_format($NeedsTotal, 2) ?>/$<?= number_format($Needs, 2) ?></h3>
        <div class="categoryBudget" id="needs">
            <div class="categoryItem" onclick="toggleVisibility(this)">
                <h3>Housing</h3>
                <p>$<?= number_format($Housing, 2) ?></p>
                <p>$<?= number_format($HousingTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Utilities</h3>
                <p>$<?= number_format($Utilities, 2) ?></p>
                <p>$<?= number_format($UtilitiesTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Food</h3>
                <p>$<?= number_format($Food, 2) ?></p>
                <p>$<?= number_format($FoodTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Transportation</h3>
                <p>$<?= number_format($Transportation, 2) ?></p>
                <p>$<?= number_format($TransTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Healthcare</h3>
                <p>$<?= number_format($Healthcare, 2) ?></p>
                <p>$<?= number_format($HealthTotal, 2) ?></p>
            </div>
        </div>
    </div>

    <div class="section" id="wantsSection">
        <h3 onclick="toggleVisibility('wantsContainer')">Wants (<?= number_format(($Wants/$Total) * 100, 2) ?>%): $<?= number_format($WantsTotal, 2) ?>/$<?= number_format($Wants, 2) ?></h3>
        <div class="categoryBudget" id="wantsContainer">
            <div class="categoryItem">
                <h3>Personal</h3>
                <p>$<?= number_format($Personal, 2) ?></p>
                <p>$<?= number_format($PersonalTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Other</h3>
                <p>$<?= number_format($Other, 2) ?></p>
                <p>$<?= number_format($OtherTotal, 2) ?></p>
            </div>
        </div>
    </div>
    <div class="section" id="savingsDebtSection">
        <h3 onclick="toggleVisibility('savingsDebtContainer')">Savings/Debt Repayment (<?= number_format(($SavingsDebtRepayment/$Total) * 100, 2) ?>%): $<?= number_format($SavingsDebtRepaymentTotal, 2) ?>/$<?= number_format($SavingsDebtRepayment, 2) ?></h3>
        <div class="categoryBudget" id="savingsDebtContainer">
            <div class="categoryItem">
                <h3>Debt Repayment</h3>
                <p>$<?= number_format($DebtRepay, 2) ?></p>
                <p>$<?= number_format($DebtReTotal, 2) ?></p>
            </div>
            <div class="categoryItem">
                <h3>Savings</h3>
                <p>$<?= number_format($Savings, 2) ?></p>
                <p>$<?= number_format($SavingsTotal, 2) ?></p>

            </div>
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
                <option>Debt Repayment</option>
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

        <?php foreach ($transactions as $transaction) : ?>
            <div class='transactionItem'>
                <p><?php echo $transaction['Category']; ?></p>
                <p><?php echo "$" . number_format($transaction['Amount'], 2); ?></p>
                <p><?php echo $transaction['transDate']; ?></p>
                <p><?php echo $transaction['Description']; ?></p>
                <p><?php echo $transaction['Type']; ?></p>
                <p><?php echo $transaction['paymentMethod']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>


    <div id="chart-container">
        <canvas id="spendingChart"></canvas>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var data = [
            <?= $HousingTotal2 ?>,
            <?= $UtilitiesTotal2 ?>,
            <?= $FoodTotal ?>,
            <?= $TransTotal ?>,
            <?= $HealthTotal2 ?>,
            <?= $DebtReTotal2 ?>,
            <?= $SavingsTotal2 ?>,
            <?= $PersonalTotal2 ?>,
            <?= $OtherTotal2 ?>
        ];
        setupPieChart(data);
    });
</script>

</body>

</html>