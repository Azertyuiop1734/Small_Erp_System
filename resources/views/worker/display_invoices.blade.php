@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 px-4 py-8" dir="rtl">

    <div class="relative overflow-hidden glass-panel p-8 rounded-[2.5rem] shadow-2xl border border-white/20 transition-all">
        <div class="absolute top-0 left-0 w-64 h-64 bg-indigo-500/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-500/10 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="relative">
                    <div class="absolute inset-0 bg-indigo-600 blur-lg opacity-40 animate-pulse"></div>
                    <div class="relative p-4 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-xl">
                        <i class="fas fa-file-invoice-dollar text-white text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">سجل فواتير المبيعات</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 font-medium flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        إدارة ومراقبة كافة العمليات المالية الصادرة
                    </p>
                </div>
            </div>
            
            <div class="flex gap-4">
                <div class="px-6 py-3 bg-white/50 dark:bg-slate-800/50 backdrop-blur-md rounded-2xl border border-white/20 shadow-sm">
                    <p class="text-[10px] font-black text-gray-400 uppercase">إجمالي العمليات</p>
                    <p class="text-xl font-black text-indigo-600 dark:text-indigo-400">{{ $sales->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-panel rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20 transition-all hover:shadow-indigo-500/5">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 text-gray-400 uppercase text-[10px] font-black tracking-[0.2em] border-b border-gray-100 dark:border-gray-800">
                        <th class="p-6">رقم المرجع</th>
                        <th class="p-6">المسؤول</th>
                        <th class="p-6 text-center">القيمة الإجمالية</th>
                        <th class="p-6 text-center">التوقيت</th>
                        <th class="p-6 text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/50 dark:divide-gray-800/50">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-transparent dark:hover:from-indigo-900/10 transition-all group">
                        <td class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-black text-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1.5 rounded-lg border border-indigo-100 dark:border-indigo-800">
                                    #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center text-sm font-black text-slate-500 dark:text-slate-400 shadow-inner">
                                    {{ strtoupper(substr($sale->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-700 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $sale->user->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">نقطة بيع رئيسية</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <div class="inline-block px-4 py-2 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20">
                                <span class="text-emerald-600 dark:text-emerald-400 font-black text-lg">
                                    {{ number_format($sale->total_amount, 2) }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-500/70 mr-1 uppercase">DA</span>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ $sale->created_at->format('Y/m/d') }}</span>
                                <span class="text-[10px] text-gray-400 bg-gray-100 dark:bg-slate-700 px-2 py-0.5 rounded-md italic">{{ $sale->created_at->format('H:i A') }}</span>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <a href="{{ route('sales.show', $sale->id) }}" 
                               class="inline-flex items-center gap-3 px-6 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-xs font-black shadow-sm hover:shadow-indigo-500/20 hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all transform active:scale-95 group/btn">
                                <i class="fas fa-expand-alt text-gray-400 group-hover/btn:text-indigo-500 transition-colors"></i>
                                عرض الفاتورة
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-32 text-center">
                            <div class="flex flex-col items-center animate-bounce-slow">
                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-6">
                                    <i class="fas fa-folder-open text-slate-300 text-4xl"></i>
                                </div>
                                <h3 class="text-xl font-black text-slate-400 italic">لا توجد سجلات حالياً</h3>
                                <p class="text-slate-400/60 text-sm mt-2 font-medium">ابدأ بإضافة أول عملية بيع لتظهر هنا</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($sales, 'links'))
        <div class="p-8 border-t border-gray-100 dark:border-gray-800 bg-slate-50/30 dark:bg-slate-800/30 backdrop-blur-sm">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
    
    /* Custom Scrollbar for the table */
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: transparent; }
    .overflow-x-auto::-webkit-scrollbar-thumb { 
        background: rgba(99, 102, 241, 0.1); 
        border-radius: 10px; 
    }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.3); }
</style>
@endsection