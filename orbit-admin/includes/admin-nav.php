<ul class="admin-nav">
    <li <?php echo ($page == 'dashboard' ? " class='active'" : ""); ?>><a href="/orbit-admin/">Dashboard</a></li>
    <li class='layout<?php echo ($page == 'layouts' ? " active" : ""); ?>'><a href="/orbit-admin/layouts/">Layouts</a>
        <ul><li><a href="/orbit-admin/layouts/new/">Create New Layout</a></li></ul>
    </li>
    <li class='module<?php echo ($page == 'modules' ? " active" : ""); ?>'><a href="/orbit-admin/modules/">Modules</a>
        <ul><li><a href="/orbit-admin/modules/new/">Create New Module</a></li></ul>
    </li>
    <li><a href="/orbit-admin/navs/" class="navs<?php echo ($page == 'navs' ? " active" : ""); ?>">Navigations</a></li>
    <li><a href="#" class="media">Media</a></li>
    <li<?php echo ($page == 'version' ? " class='active'" : ""); ?>><a href="/orbit-admin/version.php">Version Info</a></li>
    <li><a href="http://www.orbitd.co.uk/help/" target="_blank">Help</a></li>
</ul>