{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

{{-- Phone Management --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('phone') }}"><i class="nav-icon la la-mobile"></i> Phones CRUD</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('phones') }}"><i class="nav-icon la la-list"></i> Phone Catalog</a></li>
