<?php
require_once '../config/db.php';
session_start();
protect_page();

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="page-header">
    <h1>Expenditure Analysis</h1>
    <p>Visualize your spending habits across all your cards.</p>
</div>

<div class="analysis-container">
    <div class="summary-cards">
        <div class="summary-card">
            <h4>Total Spending (This Month)</h4>
            <p id="analysis-total-spending">$0.00</p>
        </div>
        <div class="summary-card">
            <h4>Top Spending Category</h4>
            <p id="analysis-top-category">N/A</p>
        </div>
        <div class="summary-card">
            <h4>Most Used Card</h4>
            <p id="analysis-top-card">N/A</p>
        </div>
    </div>

    <div class="chart-container">
        <h3>Spending by Category (Dummy Chart)</h3>
        <div class="dummy-chart">
            <div class="bar" style="height: 60%;"><span class="label">Shopping</span></div>
            <div class="bar" style="height: 80%;"><span class="label">Groceries</span></div>
            <div class="bar" style="height: 40%;"><span class="label">Travel</span></div>
            <div class="bar" style="height: 70%;"><span class="label">Bills</span></div>
            <div class="bar" style="height: 50%;"><span class="label">Dining</span></div>
        </div>
    </div>

    <div class="transaction-list">
        <h3>Recent Transactions (Mock Data)</h3>
        <ul>
            <li><strong>Amazon:</strong> $120.50 on 'Shopping Card'</li>
            <li><strong>Walmart:</strong> $85.20 on 'Groceries Card'</li>
            <li><strong>Uber:</strong> $25.00 on 'Travel Card'</li>
            <li><strong>Netflix:</strong> $15.99 on 'Bills Card'</li>
        </ul>
    </div>
</div>

<style>
.analysis-container {
    display: grid;
    gap: 2rem;
}
.summary-cards {
    display: flex;
    gap: 1.5rem;
    justify-content: space-around;
}
.summary-card {
    background: var(--primary-color);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    text-align: center;
    flex: 1;
}
.summary-card h4 {
    margin-top: 0;
    color: var(--font-color);
    opacity: 0.8;
}
.summary-card p {
    font-size: 1.8rem;
    font-weight: bold;
    color: #fff;
    margin-bottom: 0;
}
.chart-container {
    background: var(--primary-color);
    padding: 2rem;
    border-radius: var(--border-radius);
}
.dummy-chart {
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
    height: 250px;
    border-left: 2px solid var(--secondary-color);
    border-bottom: 2px solid var(--secondary-color);
    padding: 1rem;
}
.bar {
    background: var(--accent-color);
    width: 15%;
    border-radius: 5px 5px 0 0;
    position: relative;
    text-align: center;
}
.bar .label {
    position: absolute;
    bottom: -2rem;
    width: 100%;
    left: 0;
}
.transaction-list {
    background: var(--primary-color);
    padding: 2rem;
    border-radius: var(--border-radius);
}
.transaction-list ul {
    list-style: none;
    padding: 0;
}
.transaction-list li {
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--secondary-color);
}
</style>

<?php require_once 'partials/footer.php'; ?>
