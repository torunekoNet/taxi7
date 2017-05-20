<?php

/**
 * File: UploadController.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 11:57
 * Description: 文件上传
 */
class UploadController extends RedController
{

    public function actionFile()
    {
        $uploader = AceUploadedFile::getInstanceByName('imgFile');
        $domain = $this->app->params['upload'];
        $filename = $this->getTempName($uploader->getTempName());
        $type = $this->getType($uploader->getName());
        $dir = $this->request->getQuery('dir') . '/' . date('Ymd') . '/';
        $url = $uploader->saveAs($dir . $filename . $type, $domain);
        if ($url) {
            $this->response(0, $url);
        } else {
            $this->response(1, $uploader->getError());
        }
    }

    private function getTempName($tempName)
    {
        $basename = basename($tempName);
        $basename = str_replace('php', '', $basename);
        return $basename . date('His');
    }

    private function getType($name)
    {
        $temp_arr = explode(".", $name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        return '.' . strtolower($file_ext);
    }

    public function response($status = 200, $info = 'success', $data = null)
    {
        header('Content-Type:application/json; charset=UTF-8');
        echo CJSON::encode(array('error' => $status, 'url' => $info));
    }
}