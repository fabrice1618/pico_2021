<?php

class LoginView extends View
{

    public function pageContent( $csrf_token )
    {

    $sContent = <<<EOT
    <div class="container">
    <form action="/loginpost" method="post" >
    <input type="hidden" name="csrf_token" value="${csrf_token}">
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="text-center mt-5">
            <h1>Connexion</h1>
                <div class="mb-3 mt-5">
                  <label for="loginEmail" class="form-label">Adresse email</label>
                  <input type="email" class="form-control" name="loginEmail" id="loginEmail">
                </div>
                <div class="mb-3">
                  <label for="loginPassword" class="form-label">Password</label>
                  <input type="password" class="form-control"name="loginPassword" id="loginPassword">
                </div>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 mt-3 text-center">
            <button type="submit" class="btn btn-primary">Connexion</button>
        </div>
        <div class="col-3"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 mt-5 text-center">
            <a href="/lostpwd">Mot de passe oublié</a>
        </div>
        <div class="col-3"></div>
    </div>
    </form>
    </div>
EOT;
    
    return($sContent);
    }

    public function make( $csrf_token )
    {
        $this->makeHtml( $this->pageContent( $csrf_token ) );
    }

}