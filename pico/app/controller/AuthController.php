<?php 

class AuthController
{

    public function __construct( $action_name )
    {
        // Execution de l'action
        $this->$action_name();
    }

    public function login()
    {
        $oView = new LoginView();
        $app = App::getInstance();

//        $app->response->setStatusCode( 404 );
//        $sRunningTime = sprintf("Duree script : %5.3f ms<br>", Debug::runningTimeMs( $app->request->time ) );
//        $app->debug->addDebug( $sRunningTime );
        $oView->make( $app->session->get_csrf_token() );

        $app->response->send( $oView->render() );
    }

    public function loginpost()
    {

    }

    public function logout()
    {

    }

}