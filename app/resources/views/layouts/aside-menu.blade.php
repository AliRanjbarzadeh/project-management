<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo ">
		<a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="menu-logo" src="{{ asset('assets/img/logo.png') }}" alt="@lang('global.app.name')">
            </span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2">@lang('global.app.name')</span>
		</a>
		<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large mr-auto d-block d-xl-none">
			<i class="bx bx-chevron-right bx-sm align-middle"></i>
		</a>
	</div>

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		@foreach($menus as $menu)
			@if($menu->get('is_separator'))
				<li class="menu-header small text-uppercase">
					<span class="menu-header-text">{{ $menu->get('name') }}</span>
				</li>
			@else
				@if($menu->get('is_allowed'))
					<li class="menu-item @if($menu->get('is_active')) active open @endif">
						<a href="{{ $menu->get('href') }}" class="menu-link @if($menu->has('children')) menu-toggle @endif">
							<i class="menu-icon tf-icons {{ $menu->get('icon') }}"></i>
							<div data-i18n="{{ $menu->get('i18n') }}">{{ $menu->get('name') }}</div>
							@if($menu->get('badge') > 0)
								<span class="badge badge-center rounded-pill bg-primary ms-1">{{ $menu->get('badge') }}</span>
							@endif
						</a>

						@if($menu->has('children'))
							<ul class="menu-sub">
								@foreach($menu->get('children') as $childMenu)
									@if($childMenu->get('is_allowed'))
										<li class="menu-item @if($childMenu->get('is_active')) active open @endif">
											<a href="{{ $childMenu->get('href') }}" class="menu-link @if($childMenu->has('children')) menu-toggle @endif">
												<div data-i18n="{{ $childMenu->get('i18n') }}">{{ $childMenu->get('name') }}</div>
												@if($childMenu->get('badge') > 0)
													<span class="badge badge-center rounded-pill bg-primary ms-1">{{ $childMenu->get('badge') }}</span>
												@endif
											</a>

											@if($childMenu->has('children'))
												<ul class="menu-sub">
													@foreach($childMenu->get('children') as $childChildMenu)
														@if($childChildMenu->get('is_allowed'))
															<li class="menu-item @if($childChildMenu->get('is_active')) active @endif">
																<a href="{{ $childChildMenu->get('href') }}" class="menu-link">
																	<div data-i18n="{{ $childChildMenu->get('i18n') }}">{{ $childChildMenu->get('name') }}</div>
																	@if($childChildMenu->get('badge') > 0)
																		<span class="badge badge-center rounded-pill bg-primary ms-1">{{ $childChildMenu->get('badge') }}</span>
																	@endif
																</a>
															</li>
														@endif
													@endforeach
												</ul>
											@endif
										</li>
									@endif
								@endforeach
							</ul>
						@endif
					</li>
				@endif
			@endif
		@endforeach
	</ul>
</aside>