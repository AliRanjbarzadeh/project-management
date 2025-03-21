<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
	<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
		<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
			<i class="bx bx-menu bx-sm"></i>
		</a>
	</div>
	<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
		<!-- Search -->
		<div class="navbar-nav align-items-center d-none">
			<div class="nav-item d-flex align-items-center">
				<i class="bx bx-search fs-4 lh-0"></i>
				<input type="text" class="form-control border-0 shadow-none" placeholder="جستجو..." aria-label="Search...">
			</div>
		</div>
		<!-- /Search -->
		<ul class="navbar-nav flex-row align-items-center mr-auto f-ir">
			<!-- User -->
			<li class="nav-item navbar-dropdown dropdown-user dropdown">
				<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
					<div class="avatar avatar-online">
						<img src="{{ asset("assets/img/avatars/1.png") }}" alt class="w-px-40 h-auto rounded-circle">
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end new-style-13">
					<li>
						<a class="dropdown-item" href="{{ route('profile.index') }}">
							<i class="bx bx-user me-2"></i>
							<span class="align-middle">@lang('profile.singular')</span>
						</a>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<a class="dropdown-item" href="{{ route('logout') }}">
							<i class="bx bx-power-off me-2"></i>
							<span class="align-middle">@lang('auth.buttons.logout')</span>
						</a>
					</li>
				</ul>
			</li>
			<!--/ User -->
		</ul>
	</div>
</nav>