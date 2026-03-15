<!DOCTYPE html>
<html>
<head>
    <title>Student Exam Prediction</title>

    <!-- Bootstrap 5 CDN -->
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
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .card-header {
            background-color: #4e73df;
            color: white;
            border-radius: 20px 20px 0 0 !important;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #4e73df;
            color: white;
            border-radius: 10px;
        }

        .btn-custom:hover {
            background-color: #2e59d9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">

                <div class="card-header mb-4">
                    <h3>Student Pass/Fail Prediction</h3>
                </div>

                <form method="POST" action="predict.php">

                    <div class="mb-3">
                        <label class="form-label">Study Hours</label>
                        <input type="number" step="0.1" name="study_hours" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attendance (%)</label>
                        <input type="number" step="0.1" name="attendance" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Previous Grade</label>
                        <input type="number" step="0.1" name="previous_grade" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Assignment Score</label>
                        <input type="number" step="0.1" name="assignment_score" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom btn-lg">
                            Predict Result
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>