<?php
require_once '../config/db.php';
session_start();
protect_page();

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="page-header">
    <h1>Autopay Settings</h1>
    <p>Configure automatic payments for your credit card bills.</p>
</div>

<div class="autopay-container">
    <div class="content-box">
        <h3>Manage Autopay (Mock UI)</h3>
        <p>Enable or disable autopay for each of your cards. When enabled, the total amount due will be paid automatically on the due date.</p>
        
        <div class="autopay-item">
            <div class="card-info">
                <strong>Shopping Card (•••• 1234)</strong>
                <span>Bank of America</span>
            </div>
            <div class="autopay-toggle">
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
                <span>Enabled</span>
            </div>
        </div>

        <div class="autopay-item">
            <div class="card-info">
                <strong>Travel Card (•••• 5678)</strong>
                <span>Chase</span>
            </div>
            <div class="autopay-toggle">
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
                <span>Disabled</span>
            </div>
        </div>

        <div class="autopay-item">
            <div class="card-info">
                <strong>Groceries Card (•••• 9876)</strong>
                <span>Citibank</span>
            </div>
            <div class="autopay-toggle">
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
                <span>Enabled</span>
            </div>
        </div>
    </div>
</div>

<style>
.autopay-container {
    max-width: 800px;
    margin: 0 auto;
}
.content-box {
    background: var(--primary-color);
    padding: 2rem;
    border-radius: var(--border-radius);
}
.autopay-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--secondary-color);
}
.autopay-item:last-child {
    border-bottom: none;
}
.card-info strong {
    display: block;
    font-size: 1.1rem;
}
.card-info span {
    color: #aaa;
}
.autopay-toggle {
    display: flex;
    align-items: center;
    gap: 1rem;
}
</style>

<script>
document.querySelectorAll('.autopay-toggle .switch input').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const status = this.closest('.autopay-toggle').querySelector('span');
        status.textContent = this.checked ? 'Enabled' : 'Disabled';
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>
