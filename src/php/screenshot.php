<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 27.06.2017
 * Time: 12:47
 */
class screenshot
{
    public function __construct()
    {
        // set optional parameters (leave blank if unused)
        $params['fullpage'] = '';
        $params['width'] = '';
        $params['viewport'] = '';
        $params['format'] = '';
        $params['css_url'] = '';
        $params['delay'] = '';
        $params['ttl'] = '';
        $params['force'] = '';
        $params['placeholder'] = '';
        $params['user_agent'] = '';
        $params['accept_lang'] = '';
        $params['export'] = '';

        if (isset($_POST["viewport"])) {
            $params['viewport'] = $_POST["viewport"];
        }

        if (isset($_POST["width"])) {
            $params['width'] = $_POST["width"];
        }

        if (isset($_POST["placeholder"])) {
            $params['placeholder'] = urlencode($_POST["placeholder"]);
        }

        echo $this->screenshotlayer($_POST["url"], $params);
    }

    protected function screenshotlayer($url, $args)
    {

        // set access key
        $access_key = '9ef98ea39250f6bda54b1466957247e1';

        // set secret keyword (defined in account dashboard)
        $secret_keyword = 'root';

        // encode target URL
        $params['url'] = urlencode($url);

        $params += $args;

        // create the query string based on the options
        foreach ($params as $key => $value) {
            $parts[] = "$key=$value";
        }

        // compile query string
        $query = implode("&", $parts);

        // generate secret key from target URL and secret keyword
        $secret_key = md5($url . $secret_keyword);

        return "https://api.screenshotlayer.com/api/capture?access_key=$access_key&secret_key=$secret_key&$query";
    }
}

$s = new Screenshot();