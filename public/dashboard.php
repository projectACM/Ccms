<?php
require_once '../config/db.php';
protect_page(); // Protect this page

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="dashboard-header">
    <h1>Dashboard</h1>
    <p>Your financial command center.</p>
</div>

<div class="dashboard-grid">
    <!-- Real Feature: My Cards -->
    <div class="dashboard-card">
        <h3><a href="cards.php">My Credit Cards</a></h3>
        <p>View, add, and manage your credit cards.</p>
        <div class="card-icon">💳</div>
        <a href="cards.php" class="card-link">Manage Cards &rarr;</a>
    </div>

    <!-- Dummy Feature: Expenditure Analysis -->
    <div class="dashboard-card" id="expenditure-analysis">
        <h3><a href="spend_analysis.php">Expenditure Analysis</a></h3>
        <p>Visualize your spending habits.</p>
        <div class="card-icon">📊</div>
        <div class="dummy-content">
            <p><strong>This Month's Spending:</strong> <span id="total-spending">$0.00</span></p>
            <p><strong>Top Category:</strong> <span id="top-category">N/A</span></p>
        </div>
        <a href="spend_analysis.php" class="card-link">View Analysis &rarr;</a>
    </div>

    <!-- Dummy Feature: EMI & Rewards -->
    <div class="dashboard-card" id="emi-rewards">
        <h3><a href="emi_rewards.php">EMI & Rewards</a></h3>
        <p>Track your EMIs and reward points.</p>
        <div class="card-icon">🎁</div>
        <div class="dummy-content">
            <p><strong>Active EMIs:</strong> <span id="active-emis">0</span></p>
            <p><strong>Total Reward Points:</strong> <span id="reward-points">0</span></p>
        </div>
        <a href="emi_rewards.php" class="card-link">Explore Rewards &rarr;</a>
    </div>

    <!-- Dummy Feature: Autopay Setup -->
    <div class="dashboard-card">
        <h3><a href="autopay.php">Autopay Setup</a></h3>
        <p>Never miss a due date again.</p>
        <div class="card-icon">🔄</div>
        <div class="dummy-content">
            <label class="switch">
                <input type="checkbox" id="autopay-toggle">
                <span class="slider round"></span>
            </label>
            <span id="autopay-status">Autopay is OFF</span>
        </div>
        <a href="autopay.php" class="card-link">Configure Autopay &rarr;</a>
    </div>

    <!-- Dummy Feature: Credit Score -->
    <div class="dashboard-card" id="credit-score">
        <h3>Credit Score</h3>
        <p>Monitor your credit health.</p>
        <div class="card-icon">📈</div>
        <div class="dummy-content">
            <p><strong>Your Score:</strong> <span id="credit-score-value">---</span></p>
            <p><em>Last updated: <span id="credit-score-date">N/A</span></em></p>
        </div>
        <a href="#" class="card-link" onclick="alert('Dummy Feature: This is a mock UI.')">Check Score &rarr;</a>
    </div>

    <!-- Dummy Feature: Fraud Monitoring -->
    <div class="dashboard-card">
        <h3>Fraud Monitoring</h3>
        <p>Proactive alerts for your security.</p>
        <div class="card-icon">🛡️</div>
        <div class="dummy-content">
            <p><strong>Status:</strong> <span class="status-safe">Secure</span></p>
            <p>No suspicious activity detected.</p>
        </div>
        <a href="#" class="card-link" onclick="alert('Dummy Feature: This is a mock UI.')">View Alerts &rarr;</a>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
