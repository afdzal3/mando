<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon la la-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

<li class="nav-title">Config</li>
{{--
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-newspaper-o"></i> News</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon la la-newspaper-o"></i> <span>Articles</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-list"></i> <span>Categories</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-tag"></i> <span>Tags</span></a></li>
    </ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('page') }}"><i class="nav-icon la la-file-o"></i> <span>Pages</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('menu-item') }}"><i class="nav-icon la la-list"></i> <span>Menu</span></a></li>
--}}
<!-- Users, Roles Permissions -->
<li class="nav-item nav-dropdown">
  <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Authentication</a>
  <ul class="nav-dropdown-items">
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-group"></i> <span>Roles</span></a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
  </ul>
</li>

<li class="nav-item nav-dropdown">


      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon la la-terminal"></i> <span>Logs</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('setting') }}"><i class="nav-icon la la-cog"></i> <span>Settings</span></a></li>
   
</li>

<li class="nav-title">Demo Entities</li>
{{--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('monster') }}"><i class="nav-icon la la-optin-monster"></i> <span>Monsters</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('icon') }}"><i class="nav-icon la la-info-circle"></i> <span>Icons</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-shopping-cart"></i> <span>Products</span></a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('fluent-monster') }}"><i class="nav-icon la la-pastafarianism"></i> <span>Fluent Monsters</span></a></li>
--}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dummy') }}"><i class="nav-icon la la-poo"></i> <span>Dummies</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('input-address') }}'><i class='nav-icon la la-question'></i> Input addresses</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('rev-address') }}'><i class='nav-icon la la-question'></i> Rev addresses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('zip') }}'><i class='nav-icon la la-question'></i> Zips</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('input-error') }}'><i class='nav-icon la la-question'></i> Input errors</a></li>