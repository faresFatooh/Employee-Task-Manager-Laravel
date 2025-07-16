<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('إدارة المهام') }}
    </x-slot>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">قائمة المهام</h3>
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> إضافة مهمة جديدة
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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
                                <th scope="col">الموظف المكلّف</th>
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
                                    <td>{{ $task->user->name ?? 'غير محدد' }}</td>
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
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-sm btn-warning me-2" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-task-btn"
                                                data-bs-toggle="modal" data-bs-target="#deleteTaskConfirmationModal"
                                                data-task-id="{{ $task->id }}"
                                                data-task-title="{{ $task->title }}"
                                                title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد مهام لعرضها.</td>
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

    <!-- Delete Confirmation Modal for Tasks -->
    <div class="modal fade" id="deleteTaskConfirmationModal" tabindex="-1" aria-labelledby="deleteTaskConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskConfirmationModalLabel">تأكيد حذف المهمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد حذف المهمة <strong id="modalTaskTitle"></strong>؟ لا يمكن التراجع عن هذا الإجراء.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteTaskForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteTaskConfirmationModal = document.getElementById('deleteTaskConfirmationModal');
            deleteTaskConfirmationModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var taskId = button.getAttribute('data-task-id');
                var taskTitle = button.getAttribute('data-task-title');

                var modalTaskTitle = deleteTaskConfirmationModal.querySelector('#modalTaskTitle');
                modalTaskTitle.textContent = taskTitle;

                var deleteForm = deleteTaskConfirmationModal.querySelector('#deleteTaskForm');
                deleteForm.action = `/admin/tasks/${taskId}`;
            });
        });
    </script>
    @endpush
</x-app-bootstrap-layout>
