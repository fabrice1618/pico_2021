<?php

class Http404View extends View
{

    public function pageContent( $sUri, $sMethod )
    {

    $sContent = <<<EOT
        <div class="container">
            <div class="row">
              <div class="col-3"></div>
              <div class="col-6 text-center mt-5">
                    <h1>404 - Page non trouvée</h1>
              </div>
              <div class="col-3"></div>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6 mt-3">
                      <p class="text-center">Method: ${sMethod}&nbsp;&nbsp;URI: ${sUri}</p>
                </div>
                <div class="col-3"></div>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                  <div class="text-center mt-3">
                      <p>Revenir à la <a href="/">page d'accueil</a></p>
                  </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
EOT;
    
    return($sContent);
    }

    public function make( $sUri, $sMethod )
    {
        $this->makeHtml( $this->pageContent( $sUri, $sMethod ) );
    }

}