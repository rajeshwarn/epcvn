<?php
class My_Auth_User
{
    public static function authenticate()
    {
        // Check this request is allowed to auth
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $userInfo = $auth->getIdentity();

            Zend_Layout::getMvcInstance()->assign('username', $userInfo['username']);
        } else {
            $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
            $redirectUrl = 'admin/user/login/?redirectUrl='.BASE_URL.$url;

            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl($redirectUrl);
        }
    }

    public static function allow($request)
    {
        if(!My_Auth_Acl::isAllowed(Zend_Auth::getInstance()->getIdentity(), $request)){
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl('error/accessdenied');
        }
    }
}