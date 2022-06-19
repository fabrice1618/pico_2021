<?php  

class View
{
    private $layouts = [];

    const menu_guest = [
        [ 'type' => 'menu', 'active' => true, 'href' => '/', 'description' => 'Home' ],
        [ 'type' => 'menu', 'active' => false, 'href' => '/register', 'description' => 'Enregistrement' ],
        [ 'type' => 'menu', 'active' => false, 'href' => '/login', 'description' => 'Connexion' ],
    ];

    const menu_user = [
        [ 'type' => 'menu', 'active' => true, 'href' => '/', 'description' => 'Home' ],
        [ 'type' => 'submenu', 'active' => false, 'title' => 'userName' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/profile', 'description' => 'Profil' ],
        [ 'type' => 'submenudivider' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/logout', 'description' => 'Logout' ],
    ];

    const menu_admin = [
        [ 'type' => 'menu', 'active' => true, 'href' => '/', 'description' => 'Home' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/profile', 'description' => 'Profil' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/users', 'description' => 'Utilisateurs' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/groups', 'description' => 'Groupes' ],
        [ 'type' => 'submenudivider' ],
        [ 'type' => 'submenu', 'active' => false, 'href' => '/logout', 'description' => 'Logout' ],
    ];

    const menu_struct = <<<EOT
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Pico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                %s
            </ul>
        </div>
    </div>
    </nav>
EOT;

    const submenu_struct = <<<EOT
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">%s</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        %s
                    </ul>
                </li>
EOT;

    const menu_item = '<li class="nav-item"><a class="nav-link %s" %s href="%s">%s</a></li>'.PHP_EOL;

    const submenu_item = '<li><a class="dropdown-item" href="%s">%s</a></li>'.PHP_EOL;

    const submenu_separator = '<li><hr class="dropdown-divider" /></li>'.PHP_EOL;


    protected function menu()
    {

        $app = App::getInstance();
        if ( ! $app->session->isAuth() ) {
            // User is guest
            $menu = self::menu_guest;
        } elseif ( $app->session->isAuth() && $app->session->isAdmin() ) {
            // User is admin
            $menu = self::menu_admin;
        } else {
            // User is normal user
            $menu = self::menu_user;
        }


    $sMenuContent = "";
    $sSubmenuContent = "";

    foreach ($menu as $aMenu) {
        switch ($aMenu['type']) {
            case 'menu':
                $sMenuContent .= sprintf(
                    self::menu_item, 
                    ($aMenu['active']? "active": ""),
                    ($aMenu['active']? 'aria-current="page"': ""),
                    $aMenu['href'],
                    $aMenu['description']
                );
                break;
            case 'submenu':
                $sSubmenuContent .= sprintf(
                    self::submenu_item,
                    $aMenu['href'],
                    $aMenu['description']
                );
                break;
            case 'submenudivider':
                $sSubmenuContent .= self::submenu_separator;
                break;
        }        
    }

    if (! empty($sSubmenuContent) ) {
        $sSubmenu = sprintf( self::submenu_struct, "userName", $sSubmenuContent );
    } else {
        $sSubmenu = "";
    }
    
    $sMenu = sprintf( self::menu_struct, $sMenuContent . $sSubmenu );

    return($sMenu);
    }


    protected function bodyStart()
    {
        return("\t<body>");
    }

    protected function bodyEnd()
    {
    return( <<<EOT
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="public/assets/scripts.js"></script>
    </body>
EOT);        
    }

    protected function headHtml( $sDescription, $sTitle )
    {
    return( <<<EOT
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="${sDescription}" />
        <meta name="author" content="" />
        <title>${sTitle}</title>
        <link rel="apple-touch-icon" sizes="180x180" href="public/assets/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="public/assets/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="public/assets/favicon-16x16.png">
        <link rel="manifest" href="public/assets/site.webmanifest">        
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="public/assets/styles.css" rel="stylesheet" />
    </head>
EOT);        
    }


    protected function startHtml()
    {
        return( <<<EOT
        <!DOCTYPE html>
        <html lang="en">
        EOT);        
    }

    protected function endHtml()
    {
        return( "</html>" );        
    }

    protected function debugPanel()
    {
        $app = App::getInstance();

        $sDebugPanel = <<<EOT
        <div class="card mt-5">
        <div class="card-body">
          <h5 class="card-title">Debug</h5>
          <p class="card-text">%s</p>
        </div>
        </div>
EOT;

        $sDebugContent = "";
        if ( ! empty($app->debug->data) ) {
            foreach ($app->debug->data as $sContent) {
                $sDebugContent .= "<pre>" . $sContent . "</pre>" . PHP_EOL;
            }
        }

        return( sprintf( $sDebugPanel, $sDebugContent ) );

    }
    
    public function makeHtml( $sPageContent )
    {
        $this->addLayout( $this->startHtml() );
        $this->addLayout( $this->headHtml( "Pico project", "Pico" ) );
        $this->addLayout( $this->bodyStart() );
        $this->addLayout( $this->menu() );
        $this->addLayout( $sPageContent );
        $this->addLayout( $this->debugPanel() );
        $this->addLayout( $this->bodyEnd() );
        $this->addLayout( $this->endHtml() );
    }

    protected function addLayout( $sContent )
    {
        $this->layouts[] = $sContent;
    }

    public function render()
    {
        $sViewContent = "";
        foreach ($this->layouts as $sContent) {
            $sViewContent .= $sContent;
        }

        return($sViewContent);
    }
}