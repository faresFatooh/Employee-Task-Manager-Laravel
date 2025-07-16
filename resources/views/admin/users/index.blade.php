<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('إدارة المستخدمين') }}
    </x-slot>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">قائمة المستخدمين</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i> إضافة مستخدم جديد
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
                                <th scope="col">الاسم</th>
                                <th scope="col">البريد الإلكتروني</th>
                                <th scope="col">الدور</th>
                                <th scope="col">القسم</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role === 'admin' ? 'bg-info' : 'bg-secondary' }}">
                                            {{ $user->role === 'admin' ? 'مدير' : 'موظف' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->department->name ?? 'غير محدد' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-2" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- زر الحذف الذي سيفتح المودال --}}
                                        <button type="button" class="btn btn-sm btn-danger delete-user-btn"
                                                data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا يوجد مستخدمون لعرضهم.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
    {{ $users->links('vendor.pagination.bootstrap-4') }}
</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد حذف المستخدم <strong id="modalUserName"></strong>؟ لا يمكن التراجع عن هذا الإجراء.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteUserForm" method="POST" action="">
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
            var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
                // الزر الذي فتح المودال
                var button = event.relatedTarget;
                // استخراج المعلومات من خصائص data-*
                var userId = button.getAttribute('data-user-id');
                var userName = button.getAttribute('data-user-name');

                // تحديث محتوى المودال
                var modalUserName = deleteConfirmationModal.querySelector('#modalUserName');
                modalUserName.textContent = userName;

                // تحديث مسار الـ form action
                var deleteForm = deleteConfirmationModal.querySelector('#deleteUserForm');
                // بناء المسار باستخدام userId
                deleteForm.action = `/admin/users/${userId}`;
            });
        });
    </script>
    @endpush
</x-app-bootstrap-layout>
