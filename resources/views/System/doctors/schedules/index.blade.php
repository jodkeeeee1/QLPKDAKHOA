@extends('layouts.admin.master')

@section('title', 'Lịch làm việc');
@section('content')
<style>

.schedule-table table{
    table-layout: fixed;
    width: 100%;
}

.schedule-table td,
.schedule-table th{
    width: 14.28%;
    border: 1px solid #dee2e6;
}

.schedule-table td{
    height: 140px;
    vertical-align: top;
    padding: 8px;
}

.schedule-table th{
    background: #048647;
    color: white;
    padding: 12px;
}

.day-number{
    font-size: 18px;
    margin-bottom: 8px;
}

.has-schedule .day-number{
    font-weight: bold;
    color: #dc3545;
    font-size: 22px;
}

.schedule-item{
    background: #f8f9fa;
    border-left: 4px solid #048647;
    border-radius: 6px;
    padding: 6px;
    margin-bottom: 6px;
    text-align: left;
}

.today{
    background: #e8f9f1 !important;
}

</style>
    <div class="container">
        <!-- <div class="w-95 w-md-75 w-lg-60 w-xl-55 mx-auto mb-6 text-center">
            <div class="subtitle alt-font"><span class="text-primary">#04</span><span class="title">Timetable</span></div>
            <h2 class="display-18 display-md-16 display-lg-14 mb-0">Committed to fabulous and great <span
                    class="text-primary">#Timetable</span></h2>
        </div> -->
        @php
            $daysInMonth = $now->daysInMonth;
            $firstDayOfMonth = $now->copy()->startOfMonth()->dayOfWeek;
            $schedulesByDay = $schedules->groupBy(function($date) {
            return Carbon\Carbon::parse($date->day)->day;
        });
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="schedule-table">
                    <table class="table bg-white">
                        <thead>
                        <tr class="text-center">
                            <th>Chủ nhật</th>
                            <th>Thứ 2</th>
                            <th>Thứ 3</th>
                            <th>Thứ 4</th>
                            <th>Thứ 5</th>
                            <th>Thứ 6</th>
                            <th>Thứ 7</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for ( $i = 0; $i < $daysInMonth + $firstDayOfMonth; $i++)
                            @if ( $i % 7 == 0)
                                <tr class="text-center">
                                    @endif

                                    @if ( $i < $firstDayOfMonth)
                                        <td></td>
                                    @else
                                        @php
                                            $day = $i - $firstDayOfMonth + 1;
                                            $schedule = $schedulesByDay->get($day);
                                        @endphp
                                        <td class="
    {{ $now->day == $day ? 'today' : '' }}
    {{ $schedule ? 'has-schedule' : '' }}
">
                                            <p class="day-number">
    {{ $day }}
</p>
                                            @if ($schedule)
                                                @foreach ($schedule as $item)
                                                    
                                                  <div class="schedule-item">

    <div class="fw-bold text-success">
        {{ $item->shift_name }}
    </div>
<div class="small text-muted">
    {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
    -
    {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
</div>

</div>
                                                @endforeach
                                            @endif
                                        </td>
                                    @endif

                                    @if ( $i % 7 == 6)
                                </tr>
                            @endif
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
