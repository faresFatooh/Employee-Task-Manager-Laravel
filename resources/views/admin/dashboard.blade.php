<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('لوحة تحكم المدير') }}
    </x-slot>

    <div class="content-area">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">مرحباً بك يا مدير، {{ Auth::user()->name }}!</h3>
                <p class="lead">هنا ستعرض ملخصاً سريعاً عن حالة المهام والموظفين في نظامك.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">إجمالي الموظفين</h5>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $totalUsers }}</p> 
                        <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهام منجزة</h5>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $completedTasks }}</p> 
                        <a href="{{ route('admin.tasks.index', ['status' => 'done']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهام قيد التنفيذ</h5>
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $inProgressTasks }}</p> 
                        <a href="{{ route('admin.tasks.index', ['status' => 'in progress']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهام جديدة</h5>
                            <i class="fas fa-plus-circle fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $newTasks }}</p> 
                        <a href="{{ route('admin.tasks.index', ['status' => 'new']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">إجراءات سريعة</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary me-2 mb-2">
                            <i class="fas fa-user-plus me-1"></i> إضافة موظف جديد
                        </a>
                        <a href="{{ route('admin.tasks.create') }}" class="btn btn-success me-2 mb-2">
                            <i class="fas fa-plus-circle me-1"></i> إضافة مهمة جديدة
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-info me-2 mb-2">
                            <i class="fas fa-project-diagram me-1"></i> إدارة المشاريع
                        </a>
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-warning text-dark me-2 mb-2">
                            <i class="fas fa-building me-1"></i> إدارة الأقسام
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
