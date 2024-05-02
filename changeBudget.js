window.onload = pageLoad;

function pageLoad() {
    var inputs = document.querySelectorAll('input[type="number"]');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].oninput = calculateTotalAndPercentages;
    }
    calculateTotalAndPercentages();
}

function calculateTotalAndPercentages() {
    var housing = parseFloat(document.getElementById("housing").value) || 0;
    var utilities = parseFloat(document.getElementById("utilities").value) || 0;
    var transportation = parseFloat(document.getElementById("transportation").value) || 0;
    var healthcare = parseFloat(document.getElementById("healthcare").value) || 0;
    var personal = parseFloat(document.getElementById("personal").value) || 0;
    var other = parseFloat(document.getElementById("other").value) || 0;
    var debtrepay = parseFloat(document.getElementById("debtrepay").value) || 0;
    var savings = parseFloat(document.getElementById("savings").value) || 0;

    var total = housing + utilities + transportation + healthcare + personal + other + debtrepay + savings;
    document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);

    var needs = housing + utilities + transportation + healthcare;
    var wants = personal + other;
    var savingsDebt = debtrepay + savings;

    document.getElementById("needs").innerHTML = "Needs: " + ((needs / total) * 100).toFixed(2) + "%";
    document.getElementById("wants").innerHTML = "Wants: " + ((wants / total) * 100).toFixed(2) + "%";
    document.getElementById("savings-debt").innerHTML = "Savings/Debt Repayment: " + ((savingsDebt / total) * 100).toFixed(2) + "%";
}
