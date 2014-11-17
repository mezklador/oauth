<?php namespace Server\src;


class Model {
    private $datas = [];

    private function __construct(array $ins)
    {
        if (is_array($ins) && isset($ins)) $this->datas = $ins;
    }

    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->datas)) $this->datas[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->datas)) return $this->datas[$key];
        return false;
    }

    function __call($method,$arguments) {
        $meth = $this->from_camel_case(substr($method,3,strlen($method)-3));
        return array_key_exists($meth,$this->datas) ? $this->datas[$meth] : false;
    }

    function from_camel_case($str) {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }
} 