<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('لوحة تحكم الموظف') }}
    </x-slot>

    <div class="content-area">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">مرحباً بك يا موظف، {{ Auth::user()->name }}!</h3>
                <p class="lead">هنا ستجد جميع المهام الموكلة إليك وحالتها.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهامي الجديدة</h5>
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $myNewTasks }}</p>
                        <a href="{{ route('employee.tasks.index', ['status' => 'new']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهامي قيد التنفيذ</h5>
                            <i class="fas fa-sync-alt fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $myInProgressTasks }}</p>
                        <a href="{{ route('employee.tasks.index', ['status' => 'in progress']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">مهامي المنجزة</h5>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <p class="card-text fs-2">{{ $myCompletedTasks }}</p>
                        <a href="{{ route('employee.tasks.index', ['status' => 'done']) }}" class="text-white text-decoration-none">عرض التفاصيل <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">آخر المهام الموكلة إليك</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse ($latestMyTasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <strong>{{ $task->title }}</strong>
                                        <p class="mb-0 text-muted">تاريخ التسليم: {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</p>
                                    </div>
                                    @php
                                        $badgeClass = '';
                                        switch ($task->status) {
                                            case 'new':
                                                $badgeClass = 'bg-primary';
                                                break;
                                            case 'in progress':
                                                $badgeClass = 'bg-warning text-dark';
                                                break;
                                            case 'done':
                                                $badgeClass = 'bg-success';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} me-2">{{ $task->status }}</span>
                                    <a href="{{ route('employee.tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary">عرض المهمة</a>
                                </li>
                            @empty
                                <li class="list-group-item text-center">لا توجد مهام حديثة موكلة إليك.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
