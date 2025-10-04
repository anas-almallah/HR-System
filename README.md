HR System
Overview
The HR System is a web-based application designed to manage employee data, departments, attendance, leaves, and payroll efficiently. Built using PHP and MySQL, it follows the MVC (Model-View-Controller) architecture for organized and maintainable code.
This system provides an intuitive interface for HR administrators to manage employee records, track attendance, handle leave requests, and generate payroll reports. Employees can also access their profiles to submit leave requests and view their attendance history.

Features
1. Authentication

Login: Validates user credentials. Admins are redirected to the dashboard, while employees access a dedicated employee portal. Displays appropriate error messages for invalid credentials.
Logout: Securely terminates the session and prevents unauthorized access.

2. Employee Management

Add Employee: Create a new employee profile with automatic user account generation for login.
View Employees: Display a list of all employees with their details.
Edit Employee: Update employee information.
Delete Employee: Safely remove an employee from the system.

3. Department Management

Add Department: Create new departments within the organization.
Manage Departments: View, edit, or delete departments linked to employees.

4. Attendance Tracking

Daily Attendance: Record employee attendance (Present/Absent).
Attendance History: View daily attendance records for each employee.
Monthly Reports: Generate monthly attendance summaries.

5. Leave Management

Submit Leave Request: Employees can submit leave requests with specific dates and types.
Approve/Reject Leaves: Admins can approve or reject leave requests from the dashboard.

6. Payroll Management

Store Base Salary: Record each employee’s base salary in the database.
Payroll Reports: Generate reports displaying employee salary details.

7. Dashboard & Reports

Dashboard: Displays key metrics such as total employees, departments, and pending leave requests.
Department-wise Employee Report: Lists employees organized by department.


Project Structure
HrSystem/
├── config/           # Configuration files (e.g., database connection)
├── models/           # Data models for database interactions
├── views/            # User interface templates
├── controllers/      # Business logic and controllers
└── hr_system.sql     # Database schema


Requirements

PHP: 7.4 or higher
MySQL: 5.7 or higher
Web Server: Apache (or any compatible server)
Browser: Modern web browser (Chrome, Firefox, etc.)
