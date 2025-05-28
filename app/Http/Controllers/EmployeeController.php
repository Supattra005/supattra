use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->department) {
            $query->where('department', $request->department);
        }

        if ($request->position) {
            $query->where('position', $request->position);
        }

        return Inertia::render('Employees/Index', [
            'employees' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'department' => 'required|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        Employee::create($data);
        return redirect()->route('employees.index');
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'department' => 'required|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $employee->update($data);
        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}
