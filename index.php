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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="budgettracker.js"></script>
    <title>Budget Tracker</title>

</head>

<body>
    <h1>Budget Tracker: <?php echo date('F'); ?></h1>
    <h2>Total Budget: $<span id="totalBudget"><?= number_format($Total, 2) ?></span></h2>
    <h2>Total Unspent: $<span id="totalSpent"><?= number_format($BudgetTotal * -1, 2) ?></span></h2>
    <?php
    $Needs = $Total * 0.50;
    $Wants = $Total * 0.30;
    $SavingsDebtRepayment = $Total * 0.20;
    ?>

    <div id="budgetBreakdown">
        <h3>Needs (50%): $<span id="needs"><?= number_format($Needs, 2) ?></span></h3>
        <h3>Wants (30%): $<span id="wants"><?= number_format($Wants, 2) ?></span></h3>
        <h3>Savings/Debt Repayment (20%): $<span id="savingsDebt"><?= number_format($SavingsDebtRepayment, 2) ?></span></h3>
    </div>

    <div class="categoryBudget">
        <div class="categoryItem">
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
        var ctx = document.getElementById('spendingChart').getContext('2d');
        var spendingChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Housing', 'Utilities', 'Food', 'Transportation', 'Healthcare', 'Debt Repayment', 'Savings', 'Personal', 'Other'],
                datasets: [{
                    label: 'Spending by Category',
                    data: [
                        <?= $HousingTotal2 ?>,
                        <?= $UtilitiesTotal2 ?>,
                        <?= $FoodTotal ?>,
                        <?= $TransTotal ?>,
                        <?= $HealthTotal2 ?>,
                        <?= $DebtReTotal2 ?>,
                        <?= $SavingsTotal2 ?>,
                        <?= $PersonalTotal2 ?>,
                        <?= $OtherTotal2 ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(199, 199, 199, 0.2)',
                        'rgba(83, 102, 255, 0.2)',
                        'rgba(40, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(40, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>

</body>

</html>