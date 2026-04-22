@extends('layouts.app')

@section('title', 'المستخدمين')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إدارة المستخدمين</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> إضافة مستخدم جديد
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الدور</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" 
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-person-gear display-1 text-muted"></i>
            <h4 class="text-muted mt-3">لا توجد مستخدمين</h4>
            <p class="text-muted">لم يتم إضافة أي مستخدم بعد</p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> إضافة مستخدم جديد
            </a>
        </div>
        @endif
    </div>
</div>
@endsection