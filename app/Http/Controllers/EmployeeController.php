<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Illuminate\Support\Facades\Storage;



class EmployeeController extends Controller
{
    public function list_emp()
    {
        $details['data'] = Employee::select('*')->orderBy('id', 'desc')->get();
        return view('ListEmployees',$details);
    }
   public function add_emp()
   {
    return view('AddEmployee');
   }
   
   
   public function new_emp(Request $request)
   {	

        $employee = new Employee;
        $employee->firstname = $request->input('firstname');
        $employee->lastname = $request->input('lastname');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->education_qualification = $request->input('education_qualification');
        $employee->address = $request->input('address');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
      //  $employee->photo = $request->input('photo');
        $employee->resume = $request->input('resume');

          // Image upload
    if ($request->hasFile('photo')) {
        $uploadedFile = $request->file('photo');
        
        // Get the original file name
        $originalFileName = $uploadedFile->getClientOriginalName();

        // Generate a unique filename
        $filename = pathinfo($originalFileName, PATHINFO_FILENAME);
        $filename = $filename.'_'.time().'.'.$uploadedFile->getClientOriginalExtension();

        // Store the file in the specified directory
        $uploadedFile->storeAs('employee_photos', $filename, 'public');

        // Save only the filename in the database
        $employee->photo = $filename;
    }



    // Update PDF if a new one is provided
        if ($request->hasFile('resume')) {
            $uploadedFile = $request->file('resume');

            $originalFileName = $uploadedFile->getClientOriginalName();
            $filename = pathinfo($originalFileName, PATHINFO_FILENAME);
            $filename = $filename.'_'.time().'.'.$uploadedFile->getClientOriginalExtension();

            // Delete the old PDF if it exists
            if ($employee->resume) {
                Storage::disk('public')->delete('employee_pdfs/' . $employee->pdf_path);
            }

            $uploadedFile->storeAs('employee_pdfs', $filename, 'public');
            $employee->resume = $filename;
        }


		
		//$lastEmployee = Employee::latest()->first();
        $lastEmployee = Employee::select('*')->orderBy('id', 'desc')->first();

		// Check if a record was found
		if ($lastEmployee) {
			$lastEmployeeId = $lastEmployee->id + 1;
			
			
			// Now $lastEmployeeId contains the employee ID from the last row
		} else {
			$lastEmployeeId =1;
		}
		// Generate the new employee ID
		$employee->employee_id = 'EMP' . now()->format('Ymd') . $lastEmployeeId;
		

        if ($employee->save()) {
            return redirect('/Home')->with('success', 'Employee added successfully.');
        } else {
            return redirect('/Home')->with('error', 'Failed to add employee.');
        }
   }
   
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Assume the first row is the header
        $header = fgetcsv($handle);
		

         // Find the last employee record
       // $lastEmployee = Employee::latest('id')->first();
        $lastEmployee = Employee::select('*')->orderBy('id', 'desc')->first();


        // Get the last ID or start from 1 if there's no record
        $lastId = $lastEmployee ? $lastEmployee->id : 0;

        while (($row = fgetcsv($handle)) !== false) {
			
            $data = array_combine($header, $row);
			
			 // Format the date of birth before saving
            $data['date_of_birth'] = $this->formatDateOfBirth($data['date_of_birth']);


            // Generate an employee_id based on the last ID in the database
			$employeeId = 'EMP' . now()->format('Ymd') . $lastId + 1;

            // Create a new employee record
            Employee::create(array_merge(['employee_id' => $employeeId], $data));

            // Increment the last ID
            $lastId++;
        }

        fclose($handle);

        return redirect('/Home')->with('success', 'CSV file imported successfully.');
    }
	 private function formatDateOfBirth($date)
    {
        // Convert the date to a DateTime object
        $dateTime = DateTime::createFromFormat('d-m-Y', $date);

        // Format the date as needed
        return $dateTime->format('Y-m-d');
    }
    public function view_employee(Request $request)
   {

    $e_id = last(request()->segments());

    $employee['details'] = Employee::select('*')
    ->where('employee_id','=',$e_id)
    ->get();

    if(count($employee['details'])>0)
    {
        return view('ViewEmployee',$employee);
    }
   }
   public function edit_employee(Request $request)
   {

    $e_id = last(request()->segments());

    $employee['details'] = Employee::select('*')
    ->where('employee_id','=',$e_id)
    ->get();

    if(count($employee['details'])>0)
    {
        return view('EditEmployee',$employee);
    }
   }
   

   public function update_emp(Request $request)
   {
    $e_id = $request->input('employee_id');
    $update = Employee::where('employee_id',$e_id)->first();

    if(!$update)
    {
        // return redirect('/Home');
        return 'Data Not Updated';
    }

    $update->firstname = $request->input('firstname');
    $update->lastname = $request->input('lastname');
    $update->date_of_birth = $request->input('date_of_birth');
    $update->education_qualification = $request->input('education_qualification');
    $update->address = $request->input('address');
    $update->email = $request->input('email');
    $update->phone = $request->input('phone');
    //$update->photo = $request->input('photo');
   // $update->resume = $request->input('resume');

        // Update Photo if a new one is provided
    if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');

            $originalFileName = $uploadedFile->getClientOriginalName();
            $filename = pathinfo($originalFileName, PATHINFO_FILENAME);
            $filename = $filename.'_'.time().'.'.$uploadedFile->getClientOriginalExtension();

            // Delete the old photo if it exists
            if ($update->photo) {
                Storage::disk('public')->delete('employee_photos/' . $update->photo);
            }



            $uploadedFile->storeAs('employee_photos', $filename, 'public');
            $update->photo = $filename;
        }


    // Update Photo if a new one is provided
    if ($request->hasFile('resume')) {
            $uploadedFile = $request->file('resume');

            $originalFileName = $uploadedFile->getClientOriginalName();
            $filename = pathinfo($originalFileName, PATHINFO_FILENAME);
            $filename = $filename.'_'.time().'.'.$uploadedFile->getClientOriginalExtension();

            // Delete the old photo if it exists
            if ($update->resume) {
                Storage::disk('public')->delete('employee_pdfs/' . $update->resume);
            }



            $uploadedFile->storeAs('employee_pdfs', $filename, 'public');
            $update->resume = $filename;
        }

        if ($update->save()) {
            return redirect('/Home')->with('success', 'Employee updated successfully.');
        } else {
            return redirect('/Home')->with('error', 'Failed to update employee.');
        }

   }

   public function delete_employee(Request $request)
   {
    $e_id = last(request()->segments());
    $update = Employee::where('employee_id',$e_id)->first();


    if ($update->photo) {
                Storage::disk('public')->delete('employee_photos/' . $update->photo);
     }

     if ($update->resume) {
                Storage::disk('public')->delete('employee_pdfs/' . $update->resume);
     }


    $delete = Employee::where('employee_id',$e_id)->first();


    if(!$delete)
    {
        return 'No Data Found';
    }

    if ($delete->delete()) {
            return redirect('/Home')->with('success', 'Employee deleted successfully.');
        } else {
            return redirect('/Home')->with('error', 'Failed to delete employee.');
        }
   }
   public function downloadCsvTemplate()
    {
        $templatePath = storage_path('app/csv_templates/employees_template.csv');

        return response()->download($templatePath, 'employees_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
