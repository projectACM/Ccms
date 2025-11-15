<?php
require_once '../config/db.php';
session_start();
protect_page();

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="page-header">
    <h1>EMI & Rewards</h1>
    <p>Track your ongoing EMIs and redeem your reward points.</p>
</div>

<div class="emi-rewards-container">
    <div class="summary-cards">
        <div class="summary-card">
            <h4>Active EMIs</h4>
            <p id="emi-active-count">0</p>
        </div>
        <div class="summary-card">
            <h4>Total Reward Points</h4>
            <p id="emi-total-points">0</p>
        </div>
        <div class="summary-card">
            <h4>Points Value</h4>
            <p id="emi-points-value">$0.00</p>
        </div>
    </div>

    <div class="content-box">
        <h3>Active EMIs (Mock Data)</h3>
        <div class="list-item">
            <div class="item-details">
                <strong>iPhone 15 Pro</strong>
                <span>Paid 3 of 12 installments</span>
            </div>
            <div class="item-value">$100.00 / month</div>
        </div>
        <div class="list-item">
            <div class="item-details">
                <strong>Sony Bravia TV</strong>
                <span>Paid 8 of 18 installments</span>
            </div>
            <div class="item-value">$75.50 / month</div>
        </div>
    </div>

    <div class="content-box">
        <h3>Reward Points by Card (Mock Data)</h3>
        <div class="list-item">
            <div class="item-details">
                <strong>Shopping Card</strong>
                <span>Bank of America</span>
            </div>
            <div class="item-value">8,200 pts</div>
        </div>
        <div class="list-item">
            <div class="item-details">
                <strong>Travel Card</strong>
                <span>Chase</span>
            </div>
            <div class="item-value">4,300 pts</div>
        </div>
        <div class="form-group">
             <button type="submit" class="btn btn-primary">Redeem Points</button>
        </div>
    </div>
</div>

<style>
.emi-rewards-container {
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
.content-box {
    background: var(--primary-color);
    padding: 2rem;
    border-radius: var(--border-radius);
}
.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--secondary-color);
}
.list-item:last-child {
    border-bottom: none;
}
.item-details strong {
    display: block;
    font-size: 1.1rem;
}
.item-details span {
    color: #aaa;
}
.item-value {
    font-size: 1.2rem;
    font-weight: bold;
}
</style>

<?php require_once 'partials/footer.php'; ?>
