<?php
include 'DbConnect.php';
$conn = getDbConnection();

function getWeekData($startOfWeek, $conn) {
    $data = [];
    for ($i = 0; $i < 7; $i++) {
        $date = date('Y-m-d', strtotime("+$i days", strtotime($startOfWeek)));
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM Attendance WHERE DATE(DateAttended) = ?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $data[] = (int)$result['total'];
    }
    return $data;
}

// Calculate Monday of this week and last week
$today = date('Y-m-d');
$dayOfWeek = date('w', strtotime($today));
$startOfThisWeek = date('Y-m-d', strtotime("last Sunday", strtotime($today)));
$startOfLastWeek = date('Y-m-d', strtotime('-7 days', strtotime($startOfThisWeek)));

// Labels for days (e.g., Sun, Mon, ..., Sat)
$labels = [];
for ($i = 0; $i < 7; $i++) {
    $labels[] = date('D', strtotime("+$i days", strtotime($startOfThisWeek)));
}

$response = [
    'labels' => $labels,
    'thisWeek' => getWeekData($startOfThisWeek, $conn),
    'lastWeek' => getWeekData($startOfLastWeek, $conn)
];

header('Content-Type: application/json');
echo json_encode($response);
?>
