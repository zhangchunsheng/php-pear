<?php
/**
 * @title Ftp
 * @description
 * Ftp
 * @author zhangchunsheng
 * @email zhangchunsheng423@gmail.com
 * @version V1.0
 * @date 2015-12-23
 * @copyright  Copyright (c) 2015-2016 Luomor Inc. (http://www.luomor.com)
 */
namespace LL;

class Ftp {
    public $conn;

    protected $_ftpServer = "";

    public function __construct($ftpServer) {
        $this->_ftpServer = $ftpServer;
        $this->conn = ftp_connect($ftpServer);
    }

    public function __call($func, $arg) {
        if(strstr($func, 'ftp_') !== false && function_exists($func)) {
            array_unshift($arg, $this->conn);
            return call_user_func_array($func, $arg);
        } else {
            // replace with your own error handler.
            die("$func is not a valid FTP function");
        }
    }

    /**
     * login with username and password
     *
     * @param $userName
     * @param $password
     */
    public function login($userName, $password) {
        ftp_login($this->conn, $userName, $password);
    }

    /**
     * close the connection
     */
    public function close() {
        ftp_close($this->conn);
    }

    public function dir($dir) {
        return ftp_nlist($this->conn, $dir);
    }

    public function getText($file, $remoteFile) {
        return ftp_get($this->conn, $file, $remoteFile, FTP_ASCII);
    }

    public function getTexts($dir, $remoteFiles) {
        if(!is_dir($dir)) {
            mkdir($dir);
        }
        foreach($remoteFiles as $remoteFile) {
            $file = $dir . "/" . $this->getFileName($remoteFile);
            $this->getText($file, $remoteFile);
        }
    }

    public function getFileName($file) {
        if(strripos($file, "/") > 0) {
            return substr($file, strripos($file, "/") + 1);
        }
        return $file;
    }

    /**
     * @param $file tobe uploaded
     * @param $remoteFile
     */
    public function uploadText($file, $remoteFile) {
        // upload a file
        if (ftp_put($this->conn, $remoteFile, $file, FTP_ASCII)) {
            error_log("successfully uploaded $file");
        } else {
            error_log("There was a problem while uploading $file");
        }
    }
}