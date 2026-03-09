<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">

<div class="min-h-screen p-4 md:p-10">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-6">
            <div class="relative">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
                    <span class="flex items-center justify-center w-14 h-14 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-200 transition-transform hover:rotate-6">
                        <i class="fa-solid fa-receipt"></i>
                    </span>
                    Company Expense Log
                </h2>
                <p class="text-slate-500 mt-2 ml-1 inline-block bg-white px-3 py-1 rounded-full text-sm border border-slate-100 shadow-sm">
                    <i class="fa-solid fa-chart-line mr-1 text-blue-500"></i> Accurately track operational and warehouse expenses
                </p>
            </div>
            
          
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -left-4 -top-4 w-24 h-24 bg-rose-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center gap-5 relative">
                    <div class="w-14 h-14 bg-rose-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Expenses</p>
                        <p class="text-2xl font-black text-slate-800 tracking-tighter mt-1">{{ number_format($expenses->sum('amount'), 2) }} <span class="text-sm font-medium text-slate-500">DZD</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -left-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center gap-5 relative">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Warehouse Status</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">Active <span class="text-xs bg-emerald-100 text-emerald-600 px-2 py-1 rounded-lg">Online</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -left-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="flex items-center gap-5 relative">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Today's Date</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">{{ now()->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden relative">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white/50 backdrop-blur-md sticky top-0 z-10">
                <h3 class="font-black text-slate-800 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-blue-600"></i>
                    Detailed Data Table
                </h3>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-left">Expense Item</th>
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-center">Amount</th>
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-left">Responsible</th>
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-center">Location/Warehouse</th>
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-center">Date</th>
                            <th class="py-5 px-6 text-slate-500 font-bold text-xs uppercase text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($expenses as $expense)
                        <tr class="group hover:bg-blue-50/30 transition-all">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-10 bg-blue-100 rounded-full group-hover:bg-blue-600 transition-colors"></div>
                                    <div>
                                        <div class="font-black text-slate-800">{{ $expense->title }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">Ref: #{{ $expense->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6 text-center">
                                <span class="inline-block bg-rose-50 text-rose-600 px-4 py-2 rounded-xl font-black text-sm">
                                    {{ number_format($expense->amount, 2) }} <span class="text-[10px]">DZD</span>
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border-2 border-white shadow-sm flex items-center justify-center font-black text-slate-500">
                                        {{ mb_substr($expense->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $expense->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6 text-center">
                                @if($expense->user->warehouse)
                                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-black border border-blue-100">
                                        <i class="fa-solid fa-location-dot"></i> {{ $expense->user->warehouse->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg text-xs font-bold italic">
                                        <i class="fa-solid fa-building-user"></i> HQ Administration
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6 text-center">
                                <div class="text-slate-600 text-sm font-bold flex items-center justify-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                    {{ $expense->expense_date }}
                                </div>
                            </td>
                            <td class="py-5 px-6 max-w-[200px]">
                                <div class="group/note relative cursor-default">
                                    <p class="text-slate-400 text-xs italic truncate group-hover/note:text-slate-600">
                                        {{ $expense->description ?? 'No additional notes' }}
                                    </p>
                                    @if($expense->description)
                                    <div class="absolute hidden group-hover/note:block bg-slate-800 text-white text-[11px] p-3 rounded-xl shadow-2xl -top-12 left-0 z-50 w-48 leading-relaxed">
                                        {{ $expense->description }}
                                        <div class="absolute -bottom-1 left-4 w-2 h-2 bg-slate-800 rotate-45"></div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-inbox text-5xl text-slate-200"></i>
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-400">No data found</h4>
                                    <p class="text-slate-300 text-sm mt-1">Start by adding your first expense to the system.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-slate-50/50 border-t border-slate-50 flex justify-between items-center">
                <p class="text-xs font-bold text-slate-400">Showing {{ $expenses->count() }} of {{ $expenses->count() }} entries</p>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-colors"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-colors"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>