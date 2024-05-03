window.onload = pageLoad;

function pageLoad() {
    withinBudget();
}

function withinBudget() {
    var totalBudget = document.getElementById("totalBudget");
    var totalSpent = document.getElementById("totalSpent");
    var container = document.getElementsByClassName("totalContainer")[0];
    if (parseFloat(totalBudget) <= parseFloat(totalSpent)) {
        container.style.backgroundColor = "Lime";
    } else {
        container.style.backgroundColor = "Red";
    }

    var categoryItems = document.getElementsByClassName("categoryItem");
    for (var i = 0; i < categoryItems.length; i++) {
        var budget = parseFloat(categoryItems[i].getElementsByTagName("p")[0].innerText.replace(/[$,]/g, ''));
        var total = parseFloat(categoryItems[i].getElementsByTagName("p")[1].innerText.replace(/[$,]/g, ''));
        if (budget >= total) {
            categoryItems[i].style.backgroundColor = "Lime";
        } else {
            categoryItems[i].style.backgroundColor = "Red";
        }
    }    
}