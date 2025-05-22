<?php
session_start();
include("database.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['logged_in']) || !isset($_SESSION['role']) || $_SESSION['logged_in'] !== true) {
    session_unset();
    session_destroy();
    header("Location: index.php?error=session_invalid");
    exit();
}

$success = false;
$error = "";
$receipts = [];

// Handle form submission for adding new receipts
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = trim($_POST['id']);
    $client_id = trim($_POST['client_id']);
    $supplier = trim($_POST['supplier']);
    $receipt_date = trim($_POST['receipt_date']);
    $total = floatval($_POST['total']);

    if ($client_id && $id && $supplier && $receipt_date && $total > 0) {
        $stmt = $conn->prepare("INSERT INTO receipts (id, client_id, supplier, receipt_date, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssd", $id, $client_id, $supplier, $receipt_date, $total);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields and enter a valid amount.";
    }
}

// Handle inline edit update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $edit_id = trim($_POST['edit_id'] ?? '');
    $edit_supplier = isset($_POST['edit_supplier']) ? trim($_POST['edit_supplier']) : '';
    $edit_receipt_date = isset($_POST['edit_receipt_date']) ? trim($_POST['edit_receipt_date']) : '';
    $edit_total = isset($_POST['edit_total']) ? floatval($_POST['edit_total']) : 0;

    if ($edit_id && $edit_supplier && $edit_receipt_date && $edit_total > 0) {
        $stmt = $conn->prepare("UPDATE receipts SET supplier = ?, receipt_date = ?, total = ? WHERE id = ?");
        $stmt->bind_param("ssds", $edit_supplier, $edit_receipt_date, $edit_total, $edit_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Database error (update): " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields when editing and enter a valid amount.";
    }
}

// Handle delete receipt
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = trim($_POST['delete_id']);
    if ($delete_id) {
        $stmt = $conn->prepare("DELETE FROM receipts WHERE id = ?");
        $stmt->bind_param("s", $delete_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Database error (delete): " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Invalid receipt ID for deletion.";
    }
}

// Handle GET requests for viewing history
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['view_history'])) {
    $client_id = trim($_GET['client_id']);
    if ($client_id) {
        $stmt = $conn->prepare("SELECT id, supplier, receipt_date, total, client_id FROM receipts WHERE client_id = ?");
        $stmt->bind_param("s", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receipts = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $error = "Please provide a valid client ID.";
    }
}

include('Component/nav-head.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Input Receipt Information</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="css/TopNav.css">
    <link rel="stylesheet" href="css/receipt_info.css">
    <script src="js/receipt_info.js"></script>

</head>
<body>
    <main>
        <section class="section-1">
            <div id="Nav-container">
                <h1>JMCYK Client Receipt Management System</h1>
            </div>
        </section>

        <h1>Receipt Information</h1>
        <p>Manage receipts here!</p><br>

        <div class="input-field">
            <h2>Client ID</h2><br>
            <input type="text" name="client_id" placeholder="Enter client id" value="<?php echo isset($_POST['client_id']) ? htmlspecialchars($_POST['client_id']) : (isset($_GET['client_id']) ? htmlspecialchars($_GET['client_id']) : ''); ?>">
        </div><br>

        <div class="tabs" role="tablist" aria-label="Receipt Tabs">
            <span class="tab-link active" data-tab="input-details" role="tab" tabindex="0" aria-selected="true">Input Receipt Details</span>
            <span class="tab-link" data-tab="generate-summary" role="tab" tabindex="0" aria-selected="false">Generate Receipt Summary</span>
            <span class="tab-link" data-tab="receipt-history" role="tab" tabindex="0" aria-selected="false">Receipt History</span>
        </div>

        <div class="tab-content active" id="input-details" role="tabpanel" tabindex="0">
            <?php if ($success): ?>
                <h2>Receipt information submitted successfully!</h2>
                <br>
                <a href="receipt_info.php">Add another receipt</a>
            <?php else: ?>
                <?php if ($error): ?>
                    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form action="receipt_info.php" method="POST">
                    <input type="hidden" name="action" value="add" />
                    <div class="form first">
                        <div class="details personal">
                            <div class="fields">
                                <div class="input-field">
                                    <label>Reference Number</label>
                                    <input type="text" name="id" placeholder="Enter PK reference number" value="<?php echo isset($_POST['id']) ? htmlspecialchars($_POST['id']) : ''; ?>" required>
                                </div><br>
                                <div class="input-field">
                                    <label>Client ID</label>
                                    <input type="text" name="client_id" placeholder="Enter client id" value="<?php echo isset($_POST['client_id']) ? htmlspecialchars($_POST['client_id']) : ''; ?>" required>
                                </div><br>
                                <div class="input-field">
                                    <label>Supplier</label>
                                    <input type="text" name="supplier" placeholder="Name of Supplier" value="<?php echo isset($_POST['supplier']) ? htmlspecialchars($_POST['supplier']) : ''; ?>" required>
                                </div><br>
                                <div class="input-field">
                                    <label>Date</label>
                                    <input type="date" name="receipt_date" value="<?php echo isset($_POST['receipt_date']) ? htmlspecialchars($_POST['receipt_date']) : ''; ?>" required>
                                </div><br>
                                <div class="input-field">
                                    <label>Total Amount</label>
                                    <input type="number" name="total" step="0.01" placeholder="Enter total amount" value="<?php echo isset($_POST['total']) ? htmlspecialchars($_POST['total']) : ''; ?>" required>
                                </div><br>
                                <input type="submit" value="Save Changes" />
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <div class="tab-content" id="generate-summary" role="tabpanel" tabindex="0">
            <h2>Receipt Summary Generator</h2>
            <p>Generate a summary of receipts here!</p>
            <form action="receipt_info.php" method="GET">
                <button type="submit" class="submit">
                    <span class="btnText">Generate Summary</span>
                </button>
            </form>
        </div>

        <div class="tab-content" id="receipt-history" role="tabpanel" tabindex="0">
            <h2>Receipt History</h2>
            <p>View the history of added receipts here!</p>
            <form action="receipt_info.php" method="GET" style="margin-bottom: 1em;">
                <input type="text" name="client_id" placeholder="Enter client ID to view history" value="<?php echo isset($_GET['client_id']) ? htmlspecialchars($_GET['client_id']) : ''; ?>" required>
                <button type="submit" name="view_history" class="submit">
                    <span class="btnText">View Receipt History</span>
                </button>
            </form>
            <?php if (!empty($receipts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Reference Number</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($receipts as $receipt): ?>
                            <tr id="row-<?php echo htmlspecialchars($receipt['id']); ?>">
                                <td class="cell-id"><?php echo htmlspecialchars($receipt['id']); ?></td>
                                <td class="cell-supplier"><?php echo htmlspecialchars($receipt['supplier']); ?></td>
                                <td class="cell-date"><?php echo htmlspecialchars($receipt['receipt_date']); ?></td>
                                <td class="cell-total"><?php echo htmlspecialchars(number_format($receipt['total'], 2)); ?></td>
                                <td class="cell-actions">
                                    <button class="edit" type="button" onclick="enableEdit('<?php echo htmlspecialchars($receipt['id']); ?>')">Edit</button>
                                    <form method="POST" class="inline-form" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this receipt?');">
                                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($receipt['id']); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif (isset($_GET['view_history'])): ?>
                <p>No receipts found for this client ID.</p>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>

<?php $conn->close(); ?>


