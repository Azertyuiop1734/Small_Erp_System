@extends('layouts.app')

@section('title', 'سجل حضور وانصراف الموظفين')

@section('content')

{{-- ══════════════════════════════════════════
     FILTER BAR
══════════════════════════════════════════ --}}
<div class="relative mb-8 rounded-2xl overflow-hidden
            bg-white dark:bg-[#0f172a]
            border border-gray-100 dark:border-gray-800/80
            shadow-lg shadow-gray-200/60 dark:shadow-black/40">

    {{-- accent line top --}}
    <div class="absolute top-0 inset-x-0 h-[3px]
                bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-600
                rounded-t-2xl"></div>

    <div class="p-6 pt-8">
        <form action="{{ route('attendance.index') }}" method="GET"
              class="flex flex-col md:flex-row items-end gap-4">

            {{-- Date field --}}
            <div class="w-full md:w-72 space-y-1.5">
                <label class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest
                              text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-500" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    تصفية حسب التاريخ
                </label>
                <input type="date" name="date"
                       value="{{ request('date', date('Y-m-d')) }}"
                       class="w-full bg-gray-50 dark:bg-[#020617]
                              border border-gray-200 dark:border-gray-700/80
                              rounded-xl px-4 py-3
                              text-gray-900 dark:text-white text-sm
                              focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              transition-all duration-200 outline-none
                              hover:border-blue-300 dark:hover:border-blue-700">
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit"
                        class="flex-1 md:flex-none
                               bg-gradient-to-br from-blue-600 to-cyan-600
                               hover:from-blue-500 hover:to-cyan-500
                               text-white px-8 py-3 rounded-xl font-bold text-sm
                               shadow-lg shadow-blue-600/25
                               hover:shadow-blue-500/40 hover:-translate-y-0.5
                               active:translate-y-0
                               transition-all duration-200
                               flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    عرض السجل
                </button>

                <a href="{{ route('attendance.index') }}"
                   class="flex-1 md:flex-none text-center
                          bg-gray-100 dark:bg-gray-800/60
                          hover:bg-gray-200 dark:hover:bg-gray-700/60
                          text-gray-500 dark:text-gray-400
                          border border-gray-200 dark:border-gray-700/60
                          hover:border-gray-300 dark:hover:border-gray-600
                          px-6 py-3 rounded-xl font-bold text-sm
                          transition-all duration-200 hover:-translate-y-0.5">
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════
     TABLE CARD
══════════════════════════════════════════ --}}
<div class="relative rounded-2xl overflow-hidden
            bg-white dark:bg-[#0f172a]
            border border-gray-100 dark:border-gray-800/80
            shadow-xl shadow-gray-200/60 dark:shadow-black/50">

    {{-- accent line top --}}
    <div class="absolute top-0 inset-x-0 h-[3px]
                bg-gradient-to-r from-emerald-500 via-cyan-400 to-blue-500
                rounded-t-2xl"></div>

    {{-- Table header bar --}}
    <div class="px-6 pt-7 pb-4 flex items-center justify-between border-b border-gray-100 dark:border-gray-800/60">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl
                        bg-gradient-to-br from-blue-600 to-cyan-600
                        flex items-center justify-center shadow-md shadow-blue-600/25">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-white w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white text-sm leading-tight">سجل الحضور والانصراف</h3>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                    {{ request('date', date('Y-m-d')) }}
                </p>
            </div>
        </div>

        {{-- total badge --}}
        <span class="px-3 py-1.5 rounded-xl text-xs font-bold
                     bg-blue-50 dark:bg-blue-500/10
                     text-blue-600 dark:text-blue-400
                     border border-blue-100 dark:border-blue-500/20">
            {{ $attendances->count() }} سجل
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">

            {{-- ── THEAD ── --}}
            <thead>
                <tr class="bg-gray-50/80 dark:bg-[#020617]/60
                           border-b border-gray-100 dark:border-gray-800/60">
                    @foreach ([
                        ['التاريخ',       ''],
                        ['الموظف',        ''],
                        ['المخزن / الفرع',''],
                        ['وقت الحضور',   'text-center'],
                        ['وقت الانصراف', 'text-center'],
                        ['الحالة',        'text-center'],
                    ] as [$col, $align])
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest
                               text-gray-400 dark:text-gray-500 {{ $align }}">
                        {{ $col }}
                    </th>
                    @endforeach
                </tr>
            </thead>

            {{-- ── TBODY ── --}}
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">

                @forelse($attendances as $record)
                <tr class="group
                           hover:bg-blue-50/40 dark:hover:bg-blue-500/[0.04]
                           transition-colors duration-150">

                    {{-- Date --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5
                                     text-xs font-semibold
                                     text-gray-500 dark:text-gray-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 flex-shrink-0"></span>
                            {{ $record->date }}
                        </span>
                    </td>

                    {{-- Employee --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            {{-- avatar --}}
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-xl
                                            bg-gradient-to-br from-blue-500 to-cyan-500
                                            flex items-center justify-center
                                            text-white font-bold text-sm
                                            shadow-md shadow-blue-500/20
                                            group-hover:shadow-blue-500/30
                                            transition-shadow duration-200">
                                    {{ mb_substr($record->user->name, 0, 1) }}
                                </div>
                                {{-- online dot --}}
                                @if($record->check_in && !$record->check_out)
                                <span class="absolute -bottom-0.5 -left-0.5
                                             w-3 h-3 rounded-full
                                             bg-emerald-400 border-2
                                             border-white dark:border-[#0f172a]"></span>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-sm text-gray-900 dark:text-white leading-tight">
                                    {{ $record->user->name }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                    {{ $record->user->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Warehouse --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5
                                     px-3 py-1.5 rounded-lg text-xs font-semibold
                                     bg-gray-100 dark:bg-gray-800/60
                                     text-gray-600 dark:text-gray-400
                                     border border-gray-200/60 dark:border-gray-700/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 opacity-60"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 4V4"/>
                            </svg>
                            {{ $record->user->warehouse->name ?? 'غير محدد' }}
                        </span>
                    </td>

                    {{-- Check-in --}}
                    <td class="px-6 py-4 text-center">
                        @if($record->check_in)
                        <span class="inline-flex items-center gap-1.5
                                     px-3 py-1.5 rounded-lg
                                     bg-emerald-50 dark:bg-emerald-500/10
                                     border border-emerald-100 dark:border-emerald-500/20
                                     font-mono text-sm font-bold
                                     text-emerald-600 dark:text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            {{ $record->check_in }}
                        </span>
                        @else
                        <span class="text-gray-300 dark:text-gray-700 font-mono text-sm">--:--</span>
                        @endif
                    </td>

                    {{-- Check-out --}}
                    <td class="px-6 py-4 text-center">
                        @if($record->check_in)
                            @if($record->check_out)
                            <span class="inline-flex items-center gap-1.5
                                         px-3 py-1.5 rounded-lg
                                         bg-rose-50 dark:bg-rose-500/10
                                         border border-rose-100 dark:border-rose-500/20
                                         font-mono text-sm font-bold
                                         text-rose-500 dark:text-rose-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                {{ $record->check_out }}
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5
                                         px-3 py-1.5 rounded-lg text-xs font-bold
                                         bg-amber-50 dark:bg-amber-500/10
                                         border border-amber-100 dark:border-amber-500/20
                                         text-amber-600 dark:text-amber-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                في العمل
                            </span>
                            @endif
                        @else
                        <span class="text-gray-300 dark:text-gray-700 font-mono text-sm">--:--</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4 text-center">
                        @php
                            $status = strtolower($record->status);
                            $badges = [
                                'present' => [
                                    'bg'   => 'bg-emerald-50 dark:bg-emerald-500/10',
                                    'text' => 'text-emerald-600 dark:text-emerald-400',
                                    'border'=> 'border-emerald-100 dark:border-emerald-500/20',
                                    'dot'  => 'bg-emerald-400',
                                    'label'=> 'حاضر',
                                ],
                                'absent' => [
                                    'bg'   => 'bg-rose-50 dark:bg-rose-500/10',
                                    'text' => 'text-rose-600 dark:text-rose-400',
                                    'border'=> 'border-rose-100 dark:border-rose-500/20',
                                    'dot'  => 'bg-rose-400',
                                    'label'=> 'غائب',
                                ],
                                'late' => [
                                    'bg'   => 'bg-amber-50 dark:bg-amber-500/10',
                                    'text' => 'text-amber-600 dark:text-amber-400',
                                    'border'=> 'border-amber-100 dark:border-amber-500/20',
                                    'dot'  => 'bg-amber-400',
                                    'label'=> 'متأخر',
                                ],
                            ];
                            $b = $badges[$status] ?? [
                                'bg'=>'bg-gray-100 dark:bg-gray-800',
                                'text'=>'text-gray-500',
                                'border'=>'border-gray-200 dark:border-gray-700',
                                'dot'=>'bg-gray-400',
                                'label'=> ucfirst($record->status),
                            ];
                        @endphp
                        <span class="inline-flex items-center gap-1.5
                                     px-3 py-1.5 rounded-full text-xs font-bold
                                     border {{ $b['bg'] }} {{ $b['text'] }} {{ $b['border'] }}">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $b['dot'] }}"></span>
                            {{ $b['label'] }}
                        </span>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl
                                        bg-gray-50 dark:bg-gray-800/40
                                        border border-gray-100 dark:border-gray-800
                                        flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-9 h-9 text-gray-300 dark:text-gray-700"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-500 dark:text-gray-400 text-sm">
                                    لا توجد سجلات حضور لهذا اليوم
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                                    جرّب تاريخاً آخر أو تأكد من إدخال البيانات
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination (if applicable) --}}
    @if(method_exists($attendances, 'links'))
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800/60
                bg-gray-50/50 dark:bg-[#020617]/30">
        {{ $attendances->links() }}
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* ── Dropdowns ── */

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-full');
            const collapsed = sidebar.classList.contains('translate-x-full');
            mainContent.classList.replace(collapsed ? 'mr-72' : 'mr-0',
                                          collapsed ? 'mr-0'  : 'mr-72');
        });
    }

    /* ── Flash success ── */
    @if(session('success'))
        Swal.fire({
            title: 'تم الحفظ!',
            text: "{{ session('success') }}",
            icon: 'success',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
            color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#1e293b',
            confirmButtonColor: '#2563eb',
            borderRadius: '1rem',
        });
    @endif
</script>
@endpush