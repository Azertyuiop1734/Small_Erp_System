<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Warehouse; // تأكد من استدعاء موديل المخزن
use App\Models\Warehouses;
use Illuminate\Support\Facades\Hash;
use App\Models\Attendance;
use App\Models\Sale;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index2() {
    // We load the user, and then the warehouse BELONGING to that user
    $reports = Report::with('user.warehouse')->orderBy('report_date', 'desc')->get();
    return view('admin.human_management.reports', compact('reports'));
}
public function destroy2($id)
{
    $report = Report::findOrFail($id);
    $report->delete();

    return back()->with('success', 'Report deleted successfully.');
}
    // عرض صفحة إضافة التقرير
    public function create()
    {
        return view('worker.create_report');
    }

    // حفظ التقرير في قاعدة البيانات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'report_date' => 'required|date',
            'description' => 'required|string',
        ]);

        Report::create([
            'user_id'     => Auth::id(), // ربط تلقائي بالعامل المسجل دخوله
            'title'       => $validated['title'],
            'report_date' => $validated['report_date'],
            'description' => $validated['description'],
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully!');
    }
}