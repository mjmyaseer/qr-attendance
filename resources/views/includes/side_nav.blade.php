<div class="sidebar content-box" style="display: block;">
    <ul class="nav">
        @php
        $path = $_SERVER['REQUEST_URI'];
        $path = (explode("/",$path));
        $secure = $path[3];
        $final = $path[4];
        $url = '/'.$secure.'/'.$final;
        $selected = 'current';
        @endphp
        <!-- Main menu -->
            <li class="<?php  if($url == '/secure/dashboard.html'){echo $selected;} ?>">  <a href="<?php echo e(url("/secure/dashboard.html")); ?>"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
            <li class="<?php  if($url == '/secure/categories' || $url == '/secure/add-categories' ){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/categories")); ?>"><i class="glyphicon glyphicon-calendar"></i> Categories</a></li>
            <li class="<?php  if($url == '/secure/customers' || $url == '/secure/add-customers'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/customers")); ?>"><i class="glyphicon glyphicon-king"></i> Customers</a></li>
            <li class="<?php  if($url == '/secure/branch' || $url == '/secure/add-branch'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/branch")); ?>"><i class="glyphicon glyphicon-king"></i> Branch</a></li>
            <li class="<?php  if($url == '/secure/city' || $url == '/secure/add-city'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/city")); ?>"><i class="glyphicon glyphicon-king"></i> City</a></li>
            <li class="<?php  if($url == '/secure/users'){echo $selected;} ?>"> <a href="<?php echo e(url("/secure/users")); ?>"><i class="glyphicon glyphicon-user"></i> Users</a></li>


        <!--li><a href="stats.html"><i class="glyphicon glyphicon-stats"></i> Statistics (Charts)</a></li>
        <li><a href="tables.html"><i class="glyphicon glyphicon-list"></i> Tables</a></li>
        <li><a href="buttons.html"><i class="glyphicon glyphicon-record"></i> Buttons</a></li>
        <li><a href="editors.html"><i class="glyphicon glyphicon-pencil"></i> Editors</a></li>
        <li><a href="forms.html"><i class="glyphicon glyphicon-tasks"></i> Forms</a></li>
        <li class="submenu">
            <a href="#">
                <i class="glyphicon glyphicon-list"></i> Pages
                <span class="caret pull-right"></span>
            </a-->
            <!-- Sub menu -->
            <!--ul>
                <li><a href="login.html">Login</a></li>
                <li><a href="signup.html">Signup</a></li>
            </ul>
        </li-->
    </ul>
</div>