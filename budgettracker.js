window.onload = pageLoad;

// called when page loads; sets up event handlers
function pageLoad() {
    withinBudget();
}

function withinBudget() {
    var totalBudget = document.getElementById("totalBudget");
    var totalSpent = document.getElementById("totalSpent");
    if (totalBudget <= totalSpent) {
        totalSpent.style.backgroundColor = "Lime";
    } else {
        totalSpent.style.backgroundColor = "Red";
    }

    var categoryItems = document.getElementsByClassName("categoryItem");
    for (var i = 0; i < categoryItems.length; i++) {
        var budget = parseFloat(categoryItems[i].getElementsByTagName("p")[0].innerText.replace('$', ''));
        var total = parseFloat(categoryItems[i].getElementsByTagName("p")[1].innerText.replace('$', ''));
        if (budget >= total) {
            categoryItems[i].style.backgroundColor = "Lime";
        } else {
            categoryItems[i].style.backgroundColor = "Red";
        }
    }
}