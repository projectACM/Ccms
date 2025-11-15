document.addEventListener('DOMContentLoaded', function() {
    // --- Dummy Data for Dashboard ---
    const mockData = {
        expenditure: {
            total: 4580.50,
            topCategory: 'Shopping'
        },
        emi: {
            activeCount: 3,
            totalPoints: 12500
        },
        creditScore: {
            score: 780,
            lastUpdated: new Date().toLocaleDateString()
        }
    };

    // --- Update Dashboard UI with Dummy Data ---

    // Expenditure Analysis
    const totalSpendingEl = document.getElementById('total-spending');
    const topCategoryEl = document.getElementById('top-category');
    if (totalSpendingEl && topCategoryEl) {
        totalSpendingEl.textContent = `$${mockData.expenditure.total.toFixed(2)}`;
        topCategoryEl.textContent = mockData.expenditure.topCategory;
    }

    // EMI & Rewards
    const activeEmisEl = document.getElementById('active-emis');
    const rewardPointsEl = document.getElementById('reward-points');
    if (activeEmisEl && rewardPointsEl) {
        activeEmisEl.textContent = mockData.emi.activeCount;
        rewardPointsEl.textContent = mockData.emi.totalPoints.toLocaleString();
    }

    // Credit Score
    const creditScoreValueEl = document.getElementById('credit-score-value');
    const creditScoreDateEl = document.getElementById('credit-score-date');
    if (creditScoreValueEl && creditScoreDateEl) {
        creditScoreValueEl.textContent = mockData.creditScore.score;
        creditScoreDateEl.textContent = mockData.creditScore.lastUpdated;
    }

    // --- Autopay Toggle Interaction ---
    const autopayToggle = document.getElementById('autopay-toggle');
    const autopayStatus = document.getElementById('autopay-status');
    if (autopayToggle && autopayStatus) {
        autopayToggle.addEventListener('change', function() {
            if (this.checked) {
                autopayStatus.textContent = 'Autopay is ON';
                autopayStatus.style.color = '#81c784'; // Green color for ON
            } else {
                autopayStatus.textContent = 'Autopay is OFF';
                autopayStatus.style.color = ''; // Reset color
            }
        });
    }
});
