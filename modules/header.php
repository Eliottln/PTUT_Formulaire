<header>

    <nav>
        <ul>
            <li><div><img src="/img/favicon.png" alt="FillNForm logo" id="headerlogo"></div><span></span></li>
            <li><a href="/visuAllForms.php"><img src="/img/feed_black_24dp.svg" alt="all forms">Tous les forms</a><span></span></li>
            <li><a href="/CreateForm.php"><img src="/img/edit_black_24dp.svg" alt="create form">Créer un nouveau form</a><span></span></li>
            <li><a href="/dashboard.php"><img src="/img/dashboard_black_24dp.svg" alt="manage forms">Gestion de vos forms</a><span></span></li>
            <li><a href="/logout.php" title="Se déconnecter"><img src="/img/logout_black_24dp.svg" alt="log out"></a><span></span></li>

        </ul>
    </nav>

    <script>
        let currentURL = document.querySelector('a[href="<?=$_SERVER['PHP_SELF']?>"]')
        if(currentURL){
           currentURL.setAttribute('style','font-weight: bold;') 
        }
    </script>

</header>