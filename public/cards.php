<?php
require_once '../config/db.php';
protect_page();

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle POST requests for Add, Edit, Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        // Add a new card
        if ($action === 'add') {
            $stmt = $pdo->prepare(
                'INSERT INTO cards (user_id, card_name, bank_name, last4, limit_amount, statement_date, due_date) 
                 VALUES (:user_id, :card_name, :bank_name, :last4, :limit_amount, :statement_date, :due_date)'
            );
            $stmt->execute([
                'user_id' => $user_id,
                'card_name' => $_POST['card_name'],
                'bank_name' => $_POST['bank_name'],
                'last4' => $_POST['last4'],
                'limit_amount' => $_POST['limit_amount'],
                'statement_date' => $_POST['statement_date'] ?: null,
                'due_date' => $_POST['due_date'] ?: null,
            ]);
            $success = 'Card added successfully!';
        }

        // Delete a card
        if ($action === 'delete') {
            $card_id = $_POST['card_id'];
            $stmt = $pdo->prepare('DELETE FROM cards WHERE id = :id AND user_id = :user_id');
            $stmt->execute(['id' => $card_id, 'user_id' => $user_id]);
            $success = 'Card deleted successfully!';
        }
        
        // Edit a card
        if ($action === 'edit') {
            $stmt = $pdo->prepare(
                'UPDATE cards SET card_name = :card_name, bank_name = :bank_name, last4 = :last4, 
                 limit_amount = :limit_amount, current_balance = :current_balance, 
                 statement_date = :statement_date, due_date = :due_date
                 WHERE id = :id AND user_id = :user_id'
            );
            $stmt->execute([
                'card_name' => $_POST['card_name'],
                'bank_name' => $_POST['bank_name'],
                'last4' => $_POST['last4'],
                'limit_amount' => $_POST['limit_amount'],
                'current_balance' => $_POST['current_balance'],
                'statement_date' => $_POST['statement_date'] ?: null,
                'due_date' => $_POST['due_date'] ?: null,
                'id' => $_POST['card_id'],
                'user_id' => $user_id,
            ]);
            $success = 'Card updated successfully!';
        }

    } catch (PDOException $e) {
        error_log("Card Action Error: " . $e->getMessage());
        $error = 'An error occurred. Please try again.';
    }
}

// Fetch all cards for the logged-in user
$stmt = $pdo->prepare('SELECT * FROM cards WHERE user_id = :user_id ORDER BY created_at DESC');
$stmt->execute(['user_id' => $user_id]);
$cards = $stmt->fetchAll();

// Handle edit form pre-population
$edit_card = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM cards WHERE id = :id AND user_id = :user_id');
    $stmt->execute(['id' => $edit_id, 'user_id' => $user_id]);
    $edit_card = $stmt->fetch();
}

require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="page-header">
    <h1>My Credit Cards</h1>
    <p>Manage all your credit cards in one place.</p>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<!-- Form for Adding or Editing a Card -->
<div class="form-box">
    <h3><?php echo $edit_card ? 'Edit Card' : 'Add a New Card'; ?></h3>
    <form action="cards.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $edit_card ? 'edit' : 'add'; ?>">
        <?php if ($edit_card): ?>
            <input type="hidden" name="card_id" value="<?php echo $edit_card['id']; ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="card_name">Card Name (e.g., "Shopping Card")</label>
                <input type="text" name="card_name" value="<?php echo htmlspecialchars($edit_card['card_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="bank_name">Bank Name</label>
                <input type="text" name="bank_name" value="<?php echo htmlspecialchars($edit_card['bank_name'] ?? ''); ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="last4">Last 4 Digits</label>
                <input type="text" name="last4" pattern="\d{4}" title="Four digits" value="<?php echo htmlspecialchars($edit_card['last4'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="limit_amount">Credit Limit</label>
                <input type="number" step="0.01" name="limit_amount" value="<?php echo htmlspecialchars($edit_card['limit_amount'] ?? ''); ?>" required>
            </div>
        </div>
        <?php if ($edit_card): ?>
        <div class="form-row">
            <div class="form-group">
                <label for="current_balance">Current Balance</label>
                <input type="number" step="0.01" name="current_balance" value="<?php echo htmlspecialchars($edit_card['current_balance'] ?? '0.00'); ?>" required>
            </div>
        </div>
        <?php endif; ?>
        <div class="form-row">
            <div class="form-group">
                <label for="statement_date">Statement Date</label>
                <input type="date" name="statement_date" value="<?php echo htmlspecialchars($edit_card['statement_date'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" name="due_date" value="<?php echo htmlspecialchars($edit_card['due_date'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php echo $edit_card ? 'Update Card' : 'Add Card'; ?></button>
            <?php if ($edit_card): ?>
                <a href="cards.php" class="btn btn-secondary">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Display Existing Cards -->
<div class="cards-grid">
    <?php if (empty($cards)): ?>
        <p>You haven't added any cards yet. Add one using the form above.</p>
    <?php else: ?>
        <?php foreach ($cards as $card): ?>
            <div class="credit-card">
                <div class="card-header">
                    <div class="card-bank-name"><?php echo htmlspecialchars($card['bank_name']); ?></div>
                    <div class="card-type-logo">VISA</div> <!-- Dummy logo -->
                </div>
                <div class="card-number">
                    •••• •••• •••• <?php echo htmlspecialchars($card['last4']); ?>
                </div>
                <div class="card-details">
                    <div class="card-holder-name"><?php echo htmlspecialchars($card['card_name']); ?></div>
                    <div class="card-due-date">
                        <span>Due Date</span>
                        <?php echo $card['due_date'] ? date('m/d', strtotime($card['due_date'])) : 'N/A'; ?>
                    </div>
                </div>
                <div class="card-balance">
                    <span>Balance:</span> $<?php echo number_format($card['current_balance'], 2); ?> / $<?php echo number_format($card['limit_amount'], 2); ?>
                </div>
                <div class="progress-bar">
                    <?php 
                        $percentage = $card['limit_amount'] > 0 ? ($card['current_balance'] / $card['limit_amount']) * 100 : 0;
                        $percentage = min(100, $percentage); // Cap at 100%
                    ?>
                    <div class="progress" style="width: <?php echo $percentage; ?>%;"></div>
                </div>
                <div class="card-actions">
                    <a href="cards.php?edit=<?php echo $card['id']; ?>" class="btn-edit">Edit</a>
                    <form action="cards.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this card?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'partials/footer.php'; ?>
