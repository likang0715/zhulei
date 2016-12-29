<?php

/*
 * 截取中文字符串
 */

function msubstr($str, $start = 0, $length, $suffix = true, $charset = "utf-8") {
    if (function_exists("mb_substr")) {
        if ($suffix && strlen($str) > $length)
            return mb_substr($str, $start, $length, $charset) . "...";
        else
            return mb_substr($str, $start, $length, $charset);
    }elseif (function_exists('iconv_substr')) {
        if ($suffix && strlen($str) > $length)
            return iconv_substr($str, $start, $length, $charset) . "...";
        else
            return iconv_substr($str, $start, $length, $charset);
    }
    $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    if ($suffix)
        return $slice . "…";
    return $slice;
}

function arr_htmlspecialchars(&$value) {
    $value = htmlspecialchars($value);
}

function fulltext_filter($value) {
    return htmlspecialchars_decode($value);
}

/**
 * 得到附件的网址
 * is_remote,是否是远程，否时直接用本地图片
 */
function getAttachmentUrl($fileUrl, $is_remote = true) {
    if (empty($fileUrl)) {
        return '';
    } else {
        // 如果已经是完整url地址，则不做处理
        if (strstr($fileUrl, 'http://') !== false) {
            return $fileUrl;
        }

        $attachment_upload_type = C('config.attachment_upload_type');
        $url = C('config.site_url') . '/upload/';

        // 如果当前路径中已有upload，将不增加此路径
        if (strstr($fileUrl, 'upload/') !== false) {
            $url = C('config.site_url') . '/';
        }

        if ($attachment_upload_type == '1' && $is_remote) {
            $url = 'http://' . C('config.attachment_up_domainname') . '/';
        }

        return $url . $fileUrl;
    }
}

//列出文件夹
function list_dir($dirpath, $extension = array()) {
    if ($dirpath[strlen($dirpath) - 1] != "/") {
        $dirpath.="/";
    }
    static $result_array = array();
    if (is_dir($dirpath)) {
        $handle = opendir($dirpath);
        while (false !== ( $file = readdir($handle))) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $filename = $dirpath . $file;
            if (is_dir($filename)) {
                array_push($result_array, $filename);
                list_dir($filename, $extension);
            } else {
                if (count($extension) > 0) {
                    $options = @pathinfo($filename);
                    if (!in_array($options['extension'], $extension)) {
                        continue;
                    }
                }
                array_push($result_array, $filename);
            }
        }
        closedir($handle);
    }
    return $result_array;
}

//检测权限方法
function filemode($file, $checktype = 'w') {
    if (!file_exists($file)) {
        return false;
    }
    $file = realpath($file);
    if (is_dir($file)) {
        $testfile = $file . '/isfwrite.text';
        $dir = @opendir($file);
        if (!$dir) {
            return false;
        }
        if ($checktype == 'r') {
            $mode = (@readdir($dir) != false) ? true : false;
            @closedir($dir);
            return $mode;
        }
        if ($checktype == 'w') {
            $fp = @fopen($testfile, 'wb');
            if ($fp != false) {
                $wp = @fwrite($fp, " ");
                $mode = ($wp != false) ? true : false;
                @fclose($fp);
                @unlink($testfile);
                return $mode;
            } else {
                return false;
            }
        }
    } else {
        if ($checktype == 'r') {
            $fp = @is_readable($file);
            $mode = ($fp) ? true : false;
            return $mode;
        }
        if ($checktype == 'w') {
            $fp = @is_writable($file);
            $mode = ($fp) ? true : false;
            return $mode;
        }
    }
}

function parent_recursion($id = 0) {
    $list = array();
    $son_list = D('ProductCategory')->where('cat_fid=' . $id)->order('cat_sort asc')->select();
    if ($son_list) {
        foreach ($son_list as $v) {
            $v['children'] = parent_recursion($v['cat_id']);
            $list[] = $v;
        }
        return $list;
    }
}
// 写入数据库前的过滤
function getAttachment($file){
    if (empty($file)) {
        return;
    }
    $search = trim(C('config.site_url'), '/') . '/upload/';
    $attachment_upload_type = C('config.attachment_upload_type');
    if ($attachment_upload_type == '1') {
        $search = trim('http://' . C('config.attachment_up_domainname'), '/') . '/';
    }
    $file = trim(str_replace($search, '', $file), '/');
    return $file;
}

?>