<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="{{ route('dashboard') }}">
			<i class="bi bi-building-fill me-2"></i>
			السهل للعقارات
		</a>
		
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
						<i class="bi bi-speedometer2"></i> لوحة التحكم
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}" href="{{ route('properties.index') }}">
						<i class="bi bi-building-fill"></i> عقارات المبيعات
					</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('rent-properties.*') ? 'active' : '' }}" href="{{ route('rent-properties.index') }}">
						<i class="bi bi-house-door"></i> عقارات الإيجارات
					</a>
				</li>
				
				
				
				@can('property_types.manage')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('property-types.*') ? 'active' : '' }}" href="{{ route('property-types.index') }}">
						<i class="bi bi-tags"></i> أنواع العقارات
					</a>
				</li>
				@endcan
				
				@can('partners.manage')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('partners.*') ? 'active' : '' }}" href="{{ route('partners.index') }}">
						<i class="bi bi-people"></i> مسوقي المبيعات
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('rent-partners.*') ? 'active' : '' }}" href="{{ route('rent-partners.index') }}">
						<i class="bi bi-person-workspace"></i> مسوقي الإيجارات
					</a>
				</li>
				@endcan
				
				@can('users.manage')
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
						<i class="bi bi-person-gear"></i> المستخدمين
					</a>
				</li>
				@endcan
				
				@can('users.manage')
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
						<i class="bi bi-graph-up"></i> التقارير
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.todo') ? 'active' : '' }}" href="{{ route('reports.todo') }}">
								<i class="bi bi-list-check me-2"></i> خطة التقارير
							</a>
						</li>
						<li><hr class="dropdown-divider"></li>
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.dashboard') ? 'active' : '' }}" href="{{ route('reports.dashboard') }}">
								<i class="bi bi-speedometer2 me-2"></i> تقرير شامل
							</a>
						</li>
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.data-quality') ? 'active' : '' }}" href="{{ route('reports.data-quality') }}">
								<i class="bi bi-shield-check me-2"></i> جودة البيانات
							</a>
						</li>
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.partners') ? 'active' : '' }}" href="{{ route('reports.partners') }}">
								<i class="bi bi-people me-2"></i> أداء المسوقين
							</a>
						</li>
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.rentals') ? 'active' : '' }}" href="{{ route('reports.rentals') }}">
								<i class="bi bi-house-door me-2"></i> تقرير الإيجارات
							</a>
						</li>
						<li>
							<a class="dropdown-item {{ request()->routeIs('reports.alerts') ? 'active' : '' }}" href="{{ route('reports.alerts') }}">
								<i class="bi bi-bell me-2"></i> التنبيهات
							</a>
						</li>
					</ul>
				</li>
				@endcan
			</ul>
			
			<!-- User menu -->
			@auth
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
						<i class="bi bi-person-circle me-1"></i>
						{{ auth()->user()->name }}
					</a>
					<ul class="dropdown-menu dropdown-menu-start">
						<li>
							<a class="dropdown-item" href="{{ route('profile.edit') }}">
								<i class="bi bi-person-circle me-2"></i> الملف الشخصي
							</a>
						</li>
						<li><hr class="dropdown-divider"></li>
						<li>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="dropdown-item">
									<i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
								</button>
							</form>
						</li>
					</ul>
				</li>
			</ul>
			@else
			<!-- Guest menu -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('login') }}">
						<i class="bi bi-box-arrow-in-right me-1"></i>
						تسجيل الدخول
					</a>
				</li>
			</ul>
			@endauth
		</div>
	</div>
</nav>
