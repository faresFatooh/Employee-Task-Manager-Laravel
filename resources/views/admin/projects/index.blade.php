<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('إدارة المشاريع') }}
    </x-slot>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">قائمة المشاريع</h3>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-square me-1"></i> إضافة مشروع جديد
            </a>
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
                                <th scope="col">اسم المشروع</th>
                                <th scope="col">الوصف</th>
                                <th scope="col">تاريخ الإنشاء</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ Str::limit($project->description, 50) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-warning me-2" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-project-btn"
                                                data-bs-toggle="modal" data-bs-target="#deleteProjectConfirmationModal"
                                                data-project-id="{{ $project->id }}"
                                                data-project-name="{{ $project->name }}"
                                                title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد مشاريع لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $projects->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal for Projects -->
    <div class="modal fade" id="deleteProjectConfirmationModal" tabindex="-1" aria-labelledby="deleteProjectConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProjectConfirmationModalLabel">تأكيد حذف المشروع</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد حذف المشروع <strong id="modalProjectName"></strong>؟ لا يمكن التراجع عن هذا الإجراء.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteProjectForm" method="POST" action="">
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
            var deleteProjectConfirmationModal = document.getElementById('deleteProjectConfirmationModal');
            deleteProjectConfirmationModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var projectId = button.getAttribute('data-project-id');
                var projectName = button.getAttribute('data-project-name');

                var modalProjectName = deleteProjectConfirmationModal.querySelector('#modalProjectName');
                modalProjectName.textContent = projectName;

                var deleteForm = deleteProjectConfirmationModal.querySelector('#deleteProjectForm');
                deleteForm.action = `/admin/projects/${projectId}`;
            });
        });
    </script>
    @endpush
</x-app-bootstrap-layout>
