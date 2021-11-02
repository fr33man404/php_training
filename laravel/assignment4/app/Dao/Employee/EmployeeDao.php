<?php

namespace App\Dao\Employee;

use App\Contracts\Dao\Employee\EmployeeDaoInterface;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeDao implements EmployeeDaoInterface
{
    /**
     * To get all employee list with company name
     * 
     * @return array list of employee with company name
     */
    public function getAllEmployee()
    {
        return DB::select(
            DB::raw("SELECT E.id, E.name, E.jobTitle, E.email, E.nationality, E.created_at, 
            E.updated_at, E.deleted_at, C.name as company_name from employees as E
            LEFT OUTER JOIN companies AS C ON E.company_id = C.id;")
        );
    }

    /**
     * To get employee by Id
     * @param string $id request with employee data
     * @return Employee employee object
     */
    public function getEmployeebyId($id)
    {
        $employee =  DB::select(DB::raw("SELECT * from employees WHERE id=" . $id));
        return $employee[0];
    }

    /**
     * To insert employee into database
     * @param Request $request values from request
     * @return void
     */
    public function insertEmployee(Employee $employee)
    {
        $employee->save();
    }

    /**
     * To edit employee into datbase
     * @param Request $request values from request
     * @return void
     */
    public function editEmployee(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->jobTitle = $request->jobTitle;
        $employee->email = $request->email;
        $employee->nationality = $request->nationality;
        $employee->company_id = $request->company_id;
        $employee->save();
    }

    /**
     * To delete employee by id
     * @param string $id employee id
     * @return void
     */
    public function deleteEmployee($id)
    {
        Employee::findOrFail($id)->delete();
    }

    /**
     * To search employee
     * @param Employee employee object to search
     * @param string startDate start date
     * @param string endDate end date
     */
    public function searchEmployee(Employee $employee, $startDate, $endDate)
    {   
        $currentDate = date('Y-m-d');

        if (!$startDate) {
            $startDate = $currentDate;
        }
        if (!$endDate)  {
            $endDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        $employeeList = DB::select(DB::raw(
            DB::raw("SELECT E.*, C.name as company_name from employees as E 
                LEFT OUTER JOIN companies AS C ON E.company_id = C.id WHERE 
                E.name LIKE '%$employee->name%' AND
                E.jobTitle LIKE '%$employee->jobTitle%' AND 
                E.email LIKE '%$employee->email%' AND
                E.nationality LIKE '%$employee->nationality%' AND 
                E.created_at BETWEEN '$startDate' AND '$endDate';
            ")
        ));
        
        return $employeeList;
    }
}