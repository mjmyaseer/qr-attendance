<div class="sidebar content-box" style="display: block;">
    <ul class="nav">
        @php
        $path = $_SERVER['REQUEST_URI'];
        $path = (explode("/",$path));
        $secure = $path[2];
        $final = $path[3];
        $url = '/'.$secure.'/'.$final;
        $selected = 'current';
        @endphp
        <!-- Main menu -->
            <li class="<?php  if($url == '/secure/dashboard.html'){echo $selected;} ?>">  <a href="<?php echo e(url("/secure/dashboard.html")); ?>"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
            <li class="<?php  if($url == '/secure/customers' || $url == '/secure/add-customers'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/customers")); ?>"><i class="glyphicon glyphicon-king"></i> Customers</a></li>
            <li class="<?php  if($url == '/secure/event' || $url == '/secure/add-event'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/event")); ?>"><i class="glyphicon glyphicon-king"></i> Event</a></li>
            <li class="<?php  if($url == '/secure/userEvent' || $url == '/secure/add-userEvent'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/userEvent")); ?>"><i class="glyphicon glyphicon-king"></i> User Event</a></li>
            <li class="<?php  if($url == '/secure/attendance' || $url == '/secure/attendance'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/attendance")); ?>"><i class="glyphicon glyphicon-king"></i> Attendance</a></li>
            <li class="<?php  if($url == '/secure/branch' || $url == '/secure/add-branch'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/branch")); ?>"><i class="glyphicon glyphicon-king"></i> Branch</a></li>
            <li class="<?php  if($url == '/secure/city' || $url == '/secure/add-city'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/city")); ?>"><i class="glyphicon glyphicon-king"></i> City</a></li>
            <li class="<?php  if($url == '/secure/users'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/users")); ?>"><i class="glyphicon glyphicon-user"></i> Users</a></li>


    </ul>
</div>