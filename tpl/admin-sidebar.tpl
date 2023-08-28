<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{$sitename}</div>
    </a>
    {if $admin eq true}

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" id="element1">
        <a class="nav-link" href="/index.php?view=admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Fahrtenbuch</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Verwaltung
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item" id="element2">
        <a class="nav-link" href="index.php?view=admin-users">
            <i class="fas fa-fw fa-table"></i>
            <span>Benutzer</span></a>
    </li>

    <!-- Nav Item - Cars -->
    <li class="nav-item" id="element3">
        <a class="nav-link" href="index.php?view=admin-cars">
            <i class="fas fa-fw fa-car"></i>
            <span>Autos</span></a>
    </li>
    {/if}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Get Back -->
    <div class="sidebar-heading">
        Menu
    </div>
    <li class="nav-item">
        <a class="nav-link" href="index.php?view=mobile">
            <i class="fas fa-solid fa-rotate-left"></i>
            <span>Zurück zur Mobile-Seite</span></a>
    </li>

</ul>
<!-- End of Sidebar -->
