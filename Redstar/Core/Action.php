<?php
namespace Redstar\Core;
use \Mob\Adn\Helper\Util;
use Evenement\EventEmitter;
abstract class Action extends EventEmitter
{

    protected function setReq()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
        $this->cookies = $_COOKIE;
        unset($_GET, $_POST, $_REQUEST, $_FILES, $_COOKIE);
        $this->ret_format = $this->getParam('ret_format', 's') ?
            $this->getParam('ret_format', 's') : 'base64';
    }

    
    public function getParam($key, $type = 's')
    {
        $arr = $this->get;
        if (isset($arr[$key])) {
            if ($type === 'i') {
                return intval($arr[$key]);
            }
            return $arr[$key];
        }
        if ($type === 's') return '';
        if ($type === 'i') return 0;
        return '';
    }

    public function getParams()
    {
        return $this->get;
    }

    protected function filterParams()
    {
        throw new \Exception('need override FilterParams method!');
    }

    public function execute()
    {
        $this->setReq();
        $this->filterParams();
        $this->run();
    }

    public function beforeRun()
    {
        // hook plugins
    }

    public function afterRun()
    {
        // hook plugins
    }

    public function returnSuccess($data, $ret)
    {
        $ret['status'] = 200;
        $ret['msg'] = '';
        $ret['data'] = $data;
        if ($this->ret_format == 'json') {
            return json_encode($ret);
        } else if ($this->ret_format == 'base64') {
            return base64_encode(json_encode($ret));
        } else {
            return $ret;
        }
    }

    public function returnError($errCode, $msg, $ret)
    {
        $ret['status'] = $errCode;
        $ret['msg'] = $msg;
        $ret['data'] = '';
        if ($this->ret_format == 'json') {
            return json_encode($ret);
        } else if ($this->ret_format == 'base64') {
            return base64_encode(json_encode($ret));
        } else {
            return $ret;
        }
    }
    

    public static function returnData($status, $msg='', $data=array()) {
        $format = Util::getParam('xxx') == 'xxx'? 'json': 'base64';
        if(!$msg){
            $msgArr = Conf::getConf('msg');
            $msg = isset($msgArr[$status])? $msgArr[$status]: 'Unknown error';
        }
    
        $return = array(
                'status' => $status,
                'msg' => $msg
        );
        $data && $return['data'] = $data;
        $json = json_encode($return);
        if($format == 'base64'){
            echo base64_encode($json);
        }else {
            echo $json;
        }
        exit();
    }
    
}
