<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('تعديل المهمة') }}
    </x-slot>

    <div class="content-area">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">نموذج تعديل المهمة: {{ $task->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان المهمة:</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $task->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة:</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="new" {{ old('status', $task->status) == 'new' ? 'selected' : '' }}>جديدة</option>
                            <option value="in progress" {{ old('status', $task->status) == 'in progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                            <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>منجزة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">تاريخ البداية (اختياري):</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $task->start_date) }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">تاريخ التسليم:</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}" required>
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">الموظف المكلّف:</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">-- اختر موظفاً --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('user_id', $task->user_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">المشروع (اختياري):</label>
                        <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                            <option value="">-- لا يوجد مشروع --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt me-1"></i> تحديث المهمة
                    </button>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
