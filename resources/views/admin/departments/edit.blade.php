<x-app-bootstrap-layout>
    <x-slot name="header">
        {{ __('تعديل القسم') }}
    </x-slot>

    <div class="content-area">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">نموذج تعديل القسم: {{ $department->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم القسم:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $department->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>ش
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt me-1"></i> تحديث القسم
                    </button>
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary ms-2">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-bootstrap-layout>
