<?php
$user_id = Session::get('user_id');
$setting = DB::table('tbl_user')->where('user_id', $user_id)->first();

?>
<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top gradient-scooter">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>

        </ul>
        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <?php
                    if (!empty($setting->user_pic == null)) {
                    ?>
                        <span><img src="{{ url('admin/'.$setting->user_pic) }}" class="img-circle" alt="user avatar" style="height: 30px; width: 30px;"></span>
                    <?php } else { ?>

                        <span><img src="{{ url('admin/profilepic.png') }}" class="img-circle" alt="user avatar" style="height: 30px; width: 30px;"></span>
                    <?php } ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">

                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item"><i class="icon-home mr-2"></i><a href="{{url('/')}}" target="_bank">Fronted</a> </li>
                    <li class="dropdown-divider"></li>

                    <li class="dropdown-item"><a href="{{url('/admin/update-profile')}}"><i class="icon-settings mr-2"></i>Setting</a></li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item"><a href="{{url('/logout')}}"><i class="icon-power mr-2"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>