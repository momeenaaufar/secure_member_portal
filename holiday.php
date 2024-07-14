<?php
session_start();
include 'conn.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// API endpoint for public holidays
$api_url = 'https://data.gov.sg/api/action/datastore_search?resource_id=6228c3c5-03bd-4747-bb10-85140f87168b&limit=10';

// Fetch data from the API
$response = file_get_contents($api_url);

// Check if API request was successful
if ($response === false) {
    echo "Failed to fetch holidays. Please try again later.";
} else {
    $data = json_decode($response, true);

    if (isset($data['result']['records'])) {
?>
<div class="container">
    <div class="holiday-table">
        <h1>Public Holidays</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Holiday Name</th>
                    <th>Day</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['result']['records'] as $holiday): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($holiday['date']); ?></td>
                        <td><?php echo htmlspecialchars($holiday['holiday']); ?></td>
                        <td><?php echo htmlspecialchars(date('l', strtotime($holiday['date']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="protected-home.php" class="btn">Back to Dashboard</a>
    </div>
</div>
<?php
    } else {
        echo "No holidays found.";
    }
}

include 'footer.php';
?>
