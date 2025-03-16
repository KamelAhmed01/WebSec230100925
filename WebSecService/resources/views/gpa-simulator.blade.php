<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GPA Simulator</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
@extends('layouts.master')
@section('title', 'GPA Simulator')
@section('content')
    <div class="card m-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">GPA Simulator</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Add Course</h5>
                    <div class="mb-3">
                        <label for="courseSelect" class="form-label">Select Course</label>
                        <select class="form-select" id="courseSelect">
                            <option value="">-- Select a course --</option>
                            @foreach($courseCatalog as $course)
                                <option value="{{ $course['code'] }}"
                                        data-title="{{ $course['title'] }}"
                                        data-credits="{{ $course['credit_hours'] }}">
                                    {{ $course['code'] }} - {{ $course['title'] }} ({{ $course['credit_hours'] }} CH)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gradeInput" class="form-label">Grade (0-100)</label>
                        <input type="number" class="form-control" id="gradeInput" min="0" max="100" placeholder="Enter your grade">
                    </div>
                    <button type="button" class="btn btn-primary" id="addCourseBtn">Add Course</button>
                </div>
                <div class="col-md-6">
                    <h5>Course Catalog</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Credit Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courseCatalog as $course)
                                    <tr>
                                        <td>{{ $course['code'] }}</td>
                                        <td>{{ $course['title'] }}</td>
                                        <td>{{ $course['credit_hours'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Selected Courses</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="selectedCoursesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Title</th>
                                    <th>Credit Hours</th>
                                    <th>Grade</th>
                                    <th>Letter</th>
                                    <th>GPA</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedCoursesList">
                                <!-- Selected courses will be added here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noCourses" class="alert alert-info">
                        No courses added yet. Select a course and add a grade to begin.
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-3" id="gpaResult" style="display:none;">
                <strong>Cumulative GPA (CGPA):</strong> <span id="cgpa">0.00</span>
                (<span id="letterGrade">F</span>)
            </div>
        </div>
    </div>

    <script>
        // Store selected courses
        let selectedCourses = [];

        // Function to calculate GPA based on grade
        function calculateGPA(grade) {
            if (grade >= 90) return 4.0;
            if (grade >= 85) return 3.7;
            if (grade >= 80) return 3.3;
            if (grade >= 75) return 3.0;
            if (grade >= 70) return 2.7;
            if (grade >= 65) return 2.3;
            if (grade >= 60) return 2.0;
            return 0.0;
        }

        // Function to get letter grade
        function getGradeLetter(grade) {
            if (grade >= 90) return 'A';
            if (grade >= 85) return 'A-';
            if (grade >= 80) return 'B+';
            if (grade >= 75) return 'B';
            if (grade >= 70) return 'B-';
            if (grade >= 65) return 'C+';
            if (grade >= 60) return 'C';
            return 'F';
        }

        // Function to update the GPA display
        function updateGPA() {
            if (selectedCourses.length === 0) {
                document.getElementById('gpaResult').style.display = 'none';
                document.getElementById('noCourses').style.display = 'block';
                return;
            }

            document.getElementById('noCourses').style.display = 'none';
            document.getElementById('gpaResult').style.display = 'block';

            let totalCreditHours = 0;
            let totalGPAPoints = 0;

            selectedCourses.forEach(course => {
                totalCreditHours += course.creditHours;
                totalGPAPoints += (course.gpa * course.creditHours);
            });

            const cgpa = totalGPAPoints / totalCreditHours;
            document.getElementById('cgpa').textContent = cgpa.toFixed(2);
            document.getElementById('letterGrade').textContent = getGradeLetter(cgpa * 25);
        }

        // Function to render the selected courses table
        function renderSelectedCourses() {
            const tableBody = document.getElementById('selectedCoursesList');
            tableBody.innerHTML = '';

            selectedCourses.forEach((course, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${course.code}</td>
                    <td>${course.title}</td>
                    <td>${course.creditHours}</td>
                    <td>${course.grade}/100</td>
                    <td>${course.letter}</td>
                    <td>${course.gpa.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeCourse(${index})">Remove</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            updateGPA();
        }

        // Function to add a course
        function addCourse() {
            const courseSelect = document.getElementById('courseSelect');
            const gradeInput = document.getElementById('gradeInput');

            if (!courseSelect.value) {
                alert('Please select a course.');
                return;
            }

            const grade = parseInt(gradeInput.value);
            if (isNaN(grade) || grade < 0 || grade > 100) {
                alert('Please enter a valid grade between 0 and 100.');
                return;
            }

            // Check if course is already added
            if (selectedCourses.some(course => course.code === courseSelect.value)) {
                alert('This course is already added.');
                return;
            }

            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            const gpa = calculateGPA(grade);
            const letter = getGradeLetter(grade);

            const course = {
                code: courseSelect.value,
                title: selectedOption.dataset.title,
                creditHours: parseInt(selectedOption.dataset.credits),
                grade: grade,
                gpa: gpa,
                letter: letter
            };

            selectedCourses.push(course);
            renderSelectedCourses();

            // Reset form
            courseSelect.value = '';
            gradeInput.value = '';
        }

        // Function to remove a course
        function removeCourse(index) {
            selectedCourses.splice(index, 1);
            renderSelectedCourses();
        }

        // Add event listener
        document.getElementById('addCourseBtn').addEventListener('click', addCourse);

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateGPA();
        });
    </script>
@endsection
</body>
</html>
