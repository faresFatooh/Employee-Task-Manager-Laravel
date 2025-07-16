<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('تفاصيل المهمة') }}
    </x-slot>

    <div class="content-area">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">تفاصيل المهمة: {{ $task->title }}</h5>
            </div>
            <div class="card-body">
                <p><strong>الوصف:</strong> {{ $task->description ?? 'لا يوجد وصف.' }}</p>
                <p><strong>الموظف المكلّف:</strong> {{ $task->user->name ?? 'غير محدد' }}</p>
                <p><strong>المشروع:</strong> {{ $task->project->name ?? 'لا يوجد مشروع' }}</p>
                <p><strong>تاريخ البداية:</strong> {{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') : 'غير محدد' }}</p>
                <p><strong>تاريخ التسليم:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</p>
                <p>
                    <strong>الحالة:</strong>
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
                </p>

                <hr>

                <h5>تغيير حالة المهمة:</h5>
                <form action="{{ route('employee.tasks.updateStatus', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة الجديدة:</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="new" {{ old('status', $task->status) == 'new' ? 'selected' : '' }}>جديدة</option>
                            <option value="in progress" {{ old('status', $task->status) == 'in progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>منجزة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt me-1"></i> تحديث الحالة
                    </button>
                    <a href="{{ route('employee.tasks.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left me-1"></i> العودة إلى المهام
                    </a>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">التعليقات</h5>
            </div>
            <div class="card-body">
                @forelse ($task->comments as $comment)
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $comment->user->name ?? 'مستخدم غير معروف' }} <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small></h6>
                            <p class="mb-1">{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">لا توجد تعليقات على هذه المهمة حتى الآن.</p>
                @endforelse

            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">المرفقات</h5>
            </div>
            <div class="card-body">
                @forelse ($task->attachments as $attachment)
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-file-alt me-2 text-primary"></i>
                        <a href="#" class="text-decoration-none">{{ $attachment->file_name }}</a>
                        <small class="text-muted ms-auto">({{ round($attachment->file_size / 1024, 2) }} KB)</small>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مرفقات لهذه المهمة.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
