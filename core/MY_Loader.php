<?php

class MY_Loader extends CI_Loader {

    public function __construct() {

        // $this->_ci_ob_level  = ob_get_level();

        // $this->_ci_view_paths = array(
        //     VIEWPATH . 'default/' => TRUE
        // );


        // $this->_ci_library_paths = array(APPPATH, BASEPATH);

        // $this->_ci_model_paths = array(APPPATH);

        // $this->_ci_helper_paths = array(APPPATH, BASEPATH);

        // log_message('debug', "Loader Class Initialized");

    }

    public function view($view, $vars = array(), $return = FALSE) {
        $nv = $view;
        $path = explode('/', $view);
        if($path[0] != 'default') {
            $file = str_replace('/', DIRECTORY_SEPARATOR, $view).'.php';
            if(! file_exists(VIEWPATH.$file)) {
                $len = count($path); $i = 0;
                $path[0] = 'default';  $nv = '';
                foreach($path as $p) {
                    if($i == $len - 1) {
                        $nv .= $p;
                    } else {
                        $nv .= $p.'/';
                    }
                    $i++;
                }
            }
        }

        return $this->_ci_load(array('_ci_view' => $nv, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
    }
}