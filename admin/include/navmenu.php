<?php
echo '

<nav class="main-menu">
        <ul>
            <li class=';
            if ($page == "index_page")
            {echo "active"; }; echo '
            >
                <a href="index.php">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                       Основная
                    </span>
                </a>
            </li>
            <li class=';
            if ($page == "users_page")
            {echo "active"; }; echo '
            >
                <a href="users.php">
                    <i class="fa fa-user fa-2x"></i>
                    <span class="nav-text">
                      Пользователи
                    </span>
                </a>
            </li>
            <li class=';
            if ($page == "person_page")
            {echo "active"; }; echo '
            >
               <a href="person.php">
                   <i class="fa fa-globe fa-2x"></i>
                    <span class="nav-text">
                        База граждан
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                   <i class="fa fa-info fa-2x"></i>
                    <span class="nav-text">
                        Информация
                    </span>
                </a>
            </li>
        </ul>

        <ul class="logout">
            <li>
               <a href="logout.php">
                     <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>

' ?>
