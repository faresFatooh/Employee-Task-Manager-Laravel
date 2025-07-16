<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('إدارة الأقسام') }}
    </x-slot>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">قائمة الأقسام</h3>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-square me-1"></i> إضافة قسم جديد
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
                                <th scope="col">اسم القسم</th>
                                <th scope="col">تاريخ الإنشاء</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($department->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-sm btn-warning me-2" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-department-btn"
                                                data-bs-toggle="modal" data-bs-target="#deleteDepartmentConfirmationModal"
                                                data-department-id="{{ $department->id }}"
                                                data-department-name="{{ $department->name }}"
                                                title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد أقسام لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $departments->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal for Departments -->
    <div class="modal fade" id="deleteDepartmentConfirmationModal" tabindex="-1" aria-labelledby="deleteDepartmentConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDepartmentConfirmationModalLabel">تأكيد حذف القسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد حذف القسم <strong id="modalDepartmentName"></strong>؟
                    <p class="text-danger">ملاحظة: حذف القسم سيؤدي إلى تعيين حقل القسم للموظفين المرتبطين به إلى "غير محدد".</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteDepartmentForm" method="POST" action="">
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
            var deleteDepartmentConfirmationModal = document.getElementById('deleteDepartmentConfirmationModal');
            deleteDepartmentConfirmationModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var departmentId = button.getAttribute('data-department-id');
                var departmentName = button.getAttribute('data-department-name');

                var modalDepartmentName = deleteDepartmentConfirmationModal.querySelector('#modalDepartmentName');
                modalDepartmentName.textContent = departmentName;

                var deleteForm = deleteDepartmentConfirmationModal.querySelector('#deleteDepartmentForm');
                deleteForm.action = `/admin/departments/${departmentId}`;
            });
        });
    </script>
    @endpush
</x-app-bootstrap-layout>
