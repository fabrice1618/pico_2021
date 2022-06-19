<?php 

class HTTP404Controller
{

    public function __construct( $action_name )
    {
        // Execution de l'action
        $this->$action_name();
    }

    public function display()
    {
        $oView = new Http404View();
        $app = App::getInstance();

        $app->response->setStatusCode( 404 );
        $sRunningTime = sprintf("Duree script : %5.3f ms<br>", Debug::runningTimeMs( $app->request->time ) );
        $app->debug->addDebug( $sRunningTime );
        $oView->make( $app->request->uri, $app->request->method );

        $app->response->send( $oView->render() );
    }
}