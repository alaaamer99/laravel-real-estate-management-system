@extends('layouts.app')

@section('title', 'مسوقي الإيجارات - السهل للعقارات')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="fas fa-users me-2"></i>
            مسوقي الإيجارات
        </h2>
        @auth
        <a href="{{ route('rent-partners.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>
            إضافة مسوق
        </a>
        @endauth
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($rentPartners->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>البريد الإلكتروني</th>
                                <th>نسبة العمولة</th>
                                <th>عدد العقارات</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentPartners as $partner)
                            <tr>
                                <td><strong>{{ $partner->name }}</strong></td>
                                <td>{{ $partner->phone ?? '-' }}</td>
                                <td>{{ $partner->email ?? '-' }}</td>
                                <td>{{ $partner->commission_rate }}%</td>
                                <td>
                                    <span class="badge bg-info">{{ $partner->rent_properties_count }}</span>
                                </td>
                                <td>
                                    @if($partner->is_active)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غير فعال</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('rent-partners.show', $partner) }}" 
                                           class="btn btn-sm btn-outline-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                        <a href="{{ route('rent-partners.edit', $partner) }}" 
                                           class="btn btn-sm btn-outline-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('rent-partners.destroy', $partner) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="حذف"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المسوق؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer">
                    {{ $rentPartners->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد مسوقين بعد</h4>
                    <p class="text-muted">ابدأ بإضافة أول مسوق</p>
                    @auth
                    <a href="{{ route('rent-partners.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        إضافة مسوق
                    </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection