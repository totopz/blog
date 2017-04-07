<?php

class CheckAuthentication extends \Slim\Middleware
{
    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        $pathInfo = $this->app->request->getPathInfo();

        $isAuthenticated = false;

        if (isset($_SESSION['userId']) == true && User::isValid($_SESSION['userId']) == true) {
            $user = new User($_SESSION['userId']);

            if ($user->checkAuthentication() == true) {
                // add logged user to twig variables
                $twig = $this->app->view()->getEnvironment();
                $twig->addGlobal('user', $user);

                $isAuthenticated = true;

                $this->app->container->set('user', $user);
            }
        }

        if (substr($pathInfo, 0, 6) == '/admin' && $pathInfo != '/admin/login' && $isAuthenticated == false) {
            $this->redirectToLogin();
        }

        $this->next->call();
    }

    /**
     * Clear user from the session, set flash message and redirects to login page
     */
    private function redirectToLogin()
    {
        unset($_SESSION['userId']);

        // hack in order to save the alert message before the redirect,
        // because flash middleware is still not initialized
        $env = $this->app->environment();

        $env['slim.flash'] = new \Slim\Middleware\Flash();
        $env['slim.flash']->set('warning', 'Please login!');
        $env['slim.flash']->save();

        $this->app->redirectTo('admin.login');
    }
}