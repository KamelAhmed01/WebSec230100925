<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">GPA Simulator</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">GPA Simulator</h4>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h5 class="text-lg font-semibold mb-4">Add Course</h5>
                    <div class="mb-4">
                        <label for="courseSelect" class="block text-gray-700 text-sm font-bold mb-2">Select Course</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="courseSelect">
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
                    <div class="mb-4">
                        <label for="gradeInput" class="block text-gray-700 text-sm font-bold mb-2">Grade (0-100)</label>
                        <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="gradeInput" min="0" max="100" placeholder="Enter your grade">
                    </div>
                    <button type="button" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" id="addCourseBtn">Add Course</button>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Course Catalog</h5>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit Hours</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($courseCatalog as $course)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course['code'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $course['title'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course['credit_hours'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-t border-gray-200">

            <div class="mt-6">
                <h5 class="text-lg font-semibold mb-4">Selected Courses</h5>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="selectedCoursesTable">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Credit Hours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Letter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">GPA</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="selectedCoursesList" class="bg-white divide-y divide-gray-200">
                            <!-- Selected courses will be added here -->
                        </tbody>
                    </table>
                </div>
                <div id="noCourses" class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mt-4">
                    No courses added yet. Select a course and add a grade to begin.
                </div>
            </div>

            <div class="mt-6 bg-blue-100 text-blue-800 p-4 rounded-md hidden" id="gpaResult">
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
                document.getElementById('gpaResult').classList.add('hidden');
                document.getElementById('noCourses').classList.remove('hidden');
                return;
            }

            document.getElementById('noCourses').classList.add('hidden');
            document.getElementById('gpaResult').classList.remove('hidden');

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
                row.className = "hover:bg-gray-50";
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.code}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${course.title}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.creditHours}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.grade}/100</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.letter}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.gpa.toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button class="bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200" onclick="removeCourse(${index})">Remove</button>
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
</x-layout>
