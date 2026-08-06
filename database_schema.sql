CREATE TABLE Departments(
    Department_ID INT PRIMARY KEY,
    Department_Name VARCHAR(100) UNIQUE
);

CREATE TABLE Employees(
    Employee_ID INT PRIMARY KEY,
    Name VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(20),
    Department_ID INT,
    Position VARCHAR(100),
    FOREIGN KEY (Department_ID)
    REFERENCES Departments(Department_ID)
);

CREATE TABLE Attendance(
    Attendance_ID INT PRIMARY KEY,
    Employee_ID INT,
    Attendance_Date DATE,
    Status VARCHAR(20),
    FOREIGN KEY(Employee_ID)
    REFERENCES Employees(Employee_ID)
);

CREATE TABLE Leave_Management(
    Leave_ID INT PRIMARY KEY,
    Employee_ID INT,
    Leave_Type VARCHAR(50),
    Start_Date DATE,
    End_Date DATE,
    Status VARCHAR(20),
    FOREIGN KEY(Employee_ID)
    REFERENCES Employees(Employee_ID)
);

CREATE TABLE Payroll(
    Payroll_ID INT PRIMARY KEY,
    Employee_ID INT,
    Month VARCHAR(20),
    Basic_Salary DECIMAL(10,2),
    Deductions DECIMAL(10,2),
    Net_Salary DECIMAL(10,2),
    FOREIGN KEY(Employee_ID)
    REFERENCES Employees(Employee_ID)
);

CREATE TABLE Users(
    User_ID INT PRIMARY KEY,
    Username VARCHAR(50) UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('Admin','HR') NOT NULL
);
