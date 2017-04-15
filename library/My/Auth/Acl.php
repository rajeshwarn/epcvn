<?php
class My_Auth_Acl
{
    protected $_name = 'privilege';

    public static function isAllowed($user, $request)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $stmt = $db->select()->from('privilege AS p', array('id'))
                            ->joinLeft('role AS r', 'r.id = p.roleId', array('id AS roleId'))
                            ->joinLeft('user_role AS ur', 'ur.roleId = r.id', array())
                            ->joinLeft('resource AS re', 're.id = p.resourceId', array('moduleName','controllerName','actionName'))
                            ->where('ur.uId = ' . $user['userId'])
                            ->where('re.moduleName = ?', $request->getModuleName())
                            ->where('re.controllerName = ?', $request->getControllerName())
                            ->where('re.actionName = ?', $request->getActionName());
        $row = $db->fetchRow($stmt);

        if($row !== FALSE){
            return TRUE;
        }  else {
            return FALSE;
        }
    }

    public function listAllowed($user)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $stmt = $db->select()->from('privilege AS p', array('id'))
                            ->joinLeft('role AS r', 'r.id = p.roleId', array('id AS roleId'))
                            ->joinLeft('user_role AS ur', 'ur.roleId = r.id', array())
                            ->joinLeft('resource AS re', 're.id = p.resourceId', array('moduleName','controllerName','actionName', 'detail', 'p.resourceId'))
                            ->where('ur.userId = ' . $user['userId'])
                            ->group('resourceId');

        $row = $db->fetchAll($stmt);
        return $row;
    }
}