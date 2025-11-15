<nav class="navbar">
    <div class="navbar-brand">
        <a href="dashboard.php">CCMS</a>
    </div>
    <div class="navbar-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="cards.php">My Cards</a>
        <a href="profile.php">Profile</a>
        <a href="spend_analysis.php">Analysis</a>
        <a href="emi_rewards.php">EMI/Rewards</a>
        <a href="autopay.php">Autopay</a>
    </div>
    <div class="navbar-user">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</nav>
<main class="main-content">
