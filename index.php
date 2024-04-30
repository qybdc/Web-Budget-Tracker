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
    <h2>Total Usage</h2>

    <div class="categoryBudget">
        <div class="categoryItem">
            <h3>Housing</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Utilities</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Food</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Transportation</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Healthcare</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Debt Repayment</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Savings</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Personal</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
        <div class="categoryItem">
            <h3>Other</h3>
            <p>$1000</p>
            <p>$400</p>
        </div>
    </div>

    <h3>Add transactions</h3>
    <form action="index.php" method="post">
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

        <div class="transactionItem">
            <p>Housing</p>
            <p>$100.69</p>
            <p>04/30/2024</p>
            <p>This is a sample transaction</p>
            <p>Expense</p>
            <p>Credit</p>
        </div>

        <div class="transactionItem">
            <p>Housing</p>
            <p>$100.69</p>
            <p>04/30/2024</p>
            <p>This is a sample transaction</p>
            <p>Expense</p>
            <p>Credit</p>
        </div>

        <div class="transactionItem">
            <p>Housing</p>
            <p>$100.69</p>
            <p>04/30/2024</p>
            <p>This is a sample transaction</p>
            <p>Expense</p>
            <p>Credit</p>
        </div>
    </div>

</body>

</html>