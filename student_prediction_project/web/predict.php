<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $study_hours = $_POST['study_hours'];
    $attendance = $_POST['attendance'];
    $previous_grade = $_POST['previous_grade'];
    $assignment_score = $_POST['assignment_score'];

    $data = [
        "study_hours" => $study_hours,
        "attendance" => $attendance,
        "previous_grade" => $previous_grade,
        "assignment_score" => $assignment_score
    ];

    $options = [
        "http" => [
            "header"  => "Content-type: application/json",
            "method"  => "POST",
            "content" => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents("http://localhost:5000/predict", false, $context);

    if ($result === FALSE) {
        die("Error connecting to ML API. Make sure Flask is running.");
    }

    $response = json_decode($result, true);

    $prediction = $response['prediction'];
    $probability = $response['probability'];

    // Save to database
    $stmt = $conn->prepare("INSERT INTO predictions 
        (study_hours, attendance, previous_grade, assignment_score, prediction, probability) 
        VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ddddid",
        $study_hours,
        $attendance,
        $previous_grade,
        $assignment_score,
        $prediction,
        $probability
    );

    $stmt->execute();

} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prediction Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #4e73df;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .pass {
            color: #1cc88a;
            font-weight: bold;
        }

        .fail {
            color: #e74a3b;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-5 text-center">

                <h2 class="mb-4">Prediction Result</h2>

                <?php if($prediction == 1): ?>
                    <h3 class="pass">PASS</h3>
                <?php else: ?>
                    <h3 class="fail">AT RISK</h3>
                <?php endif; ?>

                <p class="mt-3">
                    Probability of Passing:
                    <strong><?php echo round($probability * 100, 2); ?>%</strong>
                </p>

                <div class="mt-4">
                    <a href="index.php" class="btn btn-primary">Try Again</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>