document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("toggleNeeds").addEventListener("click", function() {
        toggleVisibility('needsContainer');
    });
    document.getElementById("toggleWants").addEventListener("click", function() {
        toggleVisibility('wantsContainer');
    });
    document.getElementById("toggleSavingsDebt").addEventListener("click", function() {
        toggleVisibility('savingsDebtContainer');
    });

 
    var containers = document.querySelectorAll('.categoryBudget');
    containers.forEach(function(container) {
        container.style.display = 'none'; 
    });
});

function toggleVisibility(containerId) {
    var container = document.getElementById(containerId);
    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'flex'; 
        container.style.flexDirection = 'row';
    } else {
        container.style.display = 'none';
    }
}