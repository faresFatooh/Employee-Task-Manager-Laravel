<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('إضافة مشروع جديد') }}
    </x-slot>

    <div class="content-area">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">نموذج إضافة مشروع</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.projects.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم المشروع:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ المشروع
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
