@extends('mahasiswa.layout')

@section('title', 'My Schedule')
@section('page-title', 'Class Schedule')

@section('content')
<style>
    .schedule-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .schedule-sidebar {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        height: fit-content;
        border: 1px solid #f0f0f0;
    }

    .today-classes {
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .today-class {
        padding: 1rem;
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .today-class:hover {
        border-color: #29166F;
        background: #f8fff9;
    }

    .today-class.active {
        border-color: #29166F;
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
    }

    .class-time {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .class-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .class-room {
        font-size: 0.85rem;
        opacity: 0.8;
    }

    .schedule-main {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .schedule-header {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .week-navigation {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 0.5rem;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .current-week {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
    }

    .schedule-table th,
    .schedule-table td {
        border: 1px solid #f0f0f0;
        text-align: center;
        vertical-align: top;
    }

    .schedule-table th {
        background: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .time-slot {
        background: #f8f9fa;
        font-weight: 600;
        color: #666;
        padding: 1rem;
        width: 100px;
        font-size: 0.85rem;
    }

    .schedule-cell {
        padding: 0.5rem;
        height: 80px;
        position: relative;
    }

    .class-block {
        background: linear-gradient(135deg, #29166F, #4c2c91);
        color: white;
        border-radius: 8px;
        padding: 0.5rem;
        font-size: 0.8rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .class-block:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .class-block.current {
        background: linear-gradient(135deg, #fd7e14, #e63946);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(253, 126, 20, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(253, 126, 20, 0); }
        100% { box-shadow: 0 0 0 0 rgba(253, 126, 20, 0); }
    }

    .block-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .block-room {
        font-size: 0.7rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .schedule-container {
            grid-template-columns: 1fr;
        }

        .schedule-table {
            font-size: 0.75rem;
        }

        .schedule-cell {
            height: 60px;
        }

        .class-block {
            padding: 0.25rem;
            font-size: 0.7rem;
        }

        .time-slot {
            width: 70px;
            padding: 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="schedule-container">
    <div class="schedule-sidebar">
        <div class="today-classes">
            <div class="sidebar-title">
                <i class="fas fa-clock"></i>
                Today's Classes
            </div>
            <div class="today-class active">
                <div class="class-time">09:00 - 11:00</div>
                <div class="class-name">Web Programming</div>
                <div class="class-room">Room A301</div>
            </div>
            <div class="today-class">
                <div class="class-time">13:00 - 15:00</div>
                <div class="class-name">Database Systems</div>
                <div class="class-room">Lab B202</div>
            </div>
            <div class="today-class">
                <div class="class-time">15:30 - 17:00</div>
                <div class="class-name">Software Engineering</div>
                <div class="class-room">Room A205</div>
            </div>
        </div>

        <div>
            <div class="sidebar-title">
                <i class="fas fa-calendar-week"></i>
                Quick Stats
            </div>
            <div style="padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                <div style="margin-bottom: 0.5rem;"><strong>18</strong> classes this week</div>
                <div style="margin-bottom: 0.5rem;"><strong>6</strong> different courses</div>
                <div><strong>24</strong> total hours</div>
            </div>
        </div>
    </div>

    <div class="schedule-main">
        <div class="schedule-header">
            <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-calendar-alt"></i>
                Weekly Schedule
            </h3>
            <div class="week-navigation">
                <button class="nav-btn"><i class="fas fa-chevron-left"></i></button>
                <span class="current-week">October 7-11, 2025</span>
                <button class="nav-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="time-slot">08:00<br>09:30</td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Computer Networks</div>
                            <div class="block-room">Lab C301</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Computer Networks</div>
                            <div class="block-room">Lab C301</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="time-slot">09:00<br>11:00</td>
                    <td class="schedule-cell">
                        <div class="class-block current">
                            <div class="block-name">Web Programming</div>
                            <div class="block-room">Room A301</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Web Programming</div>
                            <div class="block-room">Room A301</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                </tr>
                <tr>
                    <td class="time-slot">10:00<br>12:00</td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Data Structures</div>
                            <div class="block-room">Room C105</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Data Structures</div>
                            <div class="block-room">Room C105</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="time-slot">13:00<br>15:00</td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Database Systems</div>
                            <div class="block-room">Lab B202</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Database Systems</div>
                            <div class="block-room">Lab B202</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                </tr>
                <tr>
                    <td class="time-slot">14:00<br>16:00</td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Research Methods</div>
                            <div class="block-room">Room D201</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="time-slot">15:00<br>17:00</td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Software Engineering</div>
                            <div class="block-room">Room A205</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell"></td>
                    <td class="schedule-cell">
                        <div class="class-block">
                            <div class="block-name">Software Engineering</div>
                            <div class="block-room">Room A205</div>
                        </div>
                    </td>
                    <td class="schedule-cell"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
