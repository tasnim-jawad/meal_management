<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item">
        <a href="{{route('admin.dashboard.home')}}" class="menu-link">
            <i class="fa-solid fa-house"style=margin:5px;></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>
    </li>

    {{-- User Management --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">User Management</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.user_management.add_user') }}" class="menu-link">
                    <div data-i18n="create user">Add User</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.user_management.all_user') }}" class="menu-link">
                    <div data-i18n="show user">All User</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- user meal --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">User Meals</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.meal.add_meal') }}" class="menu-link">
                    <div data-i18n="create user">Add meal</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.meal.all_meal') }}" class="menu-link">
                    <div data-i18n="show user">All Meal</div>
                </a>
            </li>

        </ul>
    </li>

    {{-- Meal rate --}}
    {{-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Meal rate</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.meal_rate.add_meal_rate') }}" class="menu-link">
                    <div data-i18n="create user">Add meal rate</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.meal_rate.all_meal_rate') }}" class="menu-link">
                    <div data-i18n="show user">All Meal Rate</div>
                </a>
            </li>

        </ul>
    </li> --}}


    {{-- All expense --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Expense</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.daily_expense.add_expense') }}" class="menu-link">
                    <div data-i18n="show user">Add Expense</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.daily_expense.add_cook_salary') }}" class="menu-link">
                    <div data-i18n="show user">Add Cook Salary</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.daily_expense.expense_date') }}" class="menu-link">
                    <div data-i18n="show user">All Expense</div>
                </a>
            </li>
        </ul>
    </li>
    {{-- Report --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Monthly Report</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.report.index') }}" class="menu-link">
                    <div data-i18n="show user">Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.report.user_report') }}" class="menu-link">
                    <div data-i18n="show user">User Report</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- All User Due --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">User Due List</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        {{-- <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.user.all_user') }}" class="menu-link">
                    <div data-i18n="show user">All User</div>
                </a>
            </li>
        </ul> --}}
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.due.daily_data') }}" class="menu-link">
                    <div data-i18n="show user">Daile Due</div>
                </a>
            </li>
        </ul>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.due.monthly_data') }}" class="menu-link">
                    <div data-i18n="show user">Monthly Due</div>
                </a>
            </li>
        </ul>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.due.yearly_data') }}" class="menu-link">
                    <div data-i18n="show user">Total Due</div>
                </a>
            </li>
        </ul>
    </li>

    {{-- meal_booking --}}
    {{-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">User Meal Booking List</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.meal_booking.all_meal') }}" class="menu-link">
                    <div data-i18n="show user">All Meal Booking</div>
                </a>
            </li>
        </ul>
    </li> --}}

          {{-- Meal Register --}}
    {{-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Meal Register</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.meal_register.Add_user_meal') }}" class="menu-link">
                    <div data-i18n="show user">Add User Meal</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.meal_register.all_user_meal') }}" class="menu-link">
                    <div data-i18n="show user">All User Meal</div>
                </a>
            </li>
        </ul>
    </li> --}}

        {{-- Add payment --}}

        <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">User Payment</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.user_payment.add_payment') }}" class="menu-link">
                    <div data-i18n="show user">Add Payment</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.user_payment.all_payment') }}" class="menu-link">
                    <div data-i18n="show user">All User Payment</div>
                </a>
            </li>
        </ul>
    </li>
    {{-- Meal rate --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Batch</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('batch.create') }}" class="menu-link">
                    <div data-i18n="create user">Add Batch</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('batch.all') }}" class="menu-link">
                    <div data-i18n="show user">All Batch</div>
                </a>
            </li>

        </ul>
    </li>
    {{-- Admin Setting --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Users">Setting</div>
            {{-- <div class="badge bg-label-primary rounded-pill ms-auto">3</div> --}}
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('admin.setting.add_admin') }}" class="menu-link">
                    <div data-i18n="show user">Add Admin</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.setting.view') }}" class="menu-link">
                    <div data-i18n="show user">View Admin</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
