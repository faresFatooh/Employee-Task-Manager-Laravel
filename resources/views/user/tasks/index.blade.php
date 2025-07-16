<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('مهامي') }}
    </x-slot>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">المهام الموكلة إليك</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">العنوان</th>
                                <th scope="col">المشروع</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">تاريخ التسليم</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->project->name ?? 'لا يوجد مشروع' }}</td>
                                    <td>
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
                                        <span class="badge {{ $badgeClass }}">{{ $task->status }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('employee.tasks.show', $task->id) }}" class="btn btn-sm btn-info" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد مهام موكلة إليك.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $tasks->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
