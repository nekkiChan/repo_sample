<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-size: 36px;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        h1 {
            margin: 1rem;
            padding: 2rem;
            font-size: clamp(1rem, 5vw, 5rem);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .hamburger-menu {
            display: flex;
            align-items: center;
            width: 250px;
            z-index: 2;
        }

        .menu-icon {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            width: 30px;
            height: 20px;
            transition: transform 0.4s ease;
            position: relative; /* 相対位置に変更 */
        }

        .bar {
            width: 100%;
            height: 4px;
            background-color: #333;
            margin: 3px 0;
            transition: 0.4s;
        }

        .menu-list {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: left 0.4s ease;
            overflow: hidden;
            z-index: 1;
        }

        .menu-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-list li {
            margin: 10px 0;
            font-size: 0.5rem;
        }

        .menu-list a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .menu-list .sub-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 20px;
        }

        .submenu.active .sub-menu {
            max-height: 200px;
        }

        .menu-list.show {
            left: 0;
        }

        .menu-icon.active .bar:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .menu-icon.active .bar:nth-child(2) {
            opacity: 0;
        }

        .menu-icon.active .bar:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        .menu-list.show+#hamburgerMenu .menu-icon.active .bar:nth-child(1) {
            transform: rotate(0) translate(0);
        }

        .menu-list.show+#hamburgerMenu .menu-icon.active .bar:nth-child(3) {
            transform: rotate(0) translate(0);
        }

        .menu-list.show+#hamburgerMenu .menu-icon.active .bar:nth-child(2) {
            opacity: 1;
        }

        .menu-list.show+#hamburgerMenu .menu-icon.active {
            transform: translateX(250px); /* アイコンを左端からメニューの幅分だけ右に移動 */
        }
    </style>

    <title>Hamburger Menu</title>
</head>

<body>
    <h1>
        タイトル
    </h1>
    <div class="container">
        <div class="hamburger-menu" id="hamburgerMenu">
            <div class="menu-icon" id="menuIcon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
        <div class="menu-list" id="menuList">
            <ul>
                <li><a href="#">Home</a></li>
                <li class="submenu">
                    <a href="#">About</a>
                    <ul class="sub-menu">
                        <li><a href="#">History</a></li>
                        <li><a href="#">Team</a></li>
                    </ul>
                </li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var menuIcon = document.getElementById("menuIcon");
            var menuList = document.getElementById("menuList");
            var menuWidth = menuList.clientWidth; // メニューの幅を取得

            menuIcon.addEventListener("click", function () {
                menuIcon.classList.toggle("active");
                menuList.classList.toggle("show");
            });

            // サブメニューのクリックでアコーディオン効果
            var subMenus = document.querySelectorAll('.submenu');
            subMenus.forEach(function (subMenu) {
                subMenu.addEventListener('click', function () {
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</body>

</html>
