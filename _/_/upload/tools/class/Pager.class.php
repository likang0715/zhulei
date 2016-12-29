<?php
    require_once PIGCMS_PATH .'/source/class/user_page.class.php';
    class Pager extends Page
    {
        private $parameter = array();
        public function __construct($totalRows, $listRows, $parameter)
        {
            $this->totalRows = $totalRows;
            $this->nowPage  = !empty($_GET['p']) ? intval($_GET['p']) : 1;
            $this->listRows = $listRows;
            $this->totalPage = ceil($totalRows/$listRows);
            if($this->nowPage > $this->totalPage && $this->totalPage>0){
                $this->nowPage = $this->totalPage;
            }
            $this->firstRow = $listRows*($this->nowPage-1);
            $this->parameter = $parameter;
        }

        public function show(){
            if($this->totalRows == 0) return false;
            $now = $this->nowPage;
            $total = $this->totalPage;

            $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?");
            $parse = parse_url($url);
            if(isset($parse['query'])) {
                parse_str($parse['query'],$params);
                unset($params['p']);
                if (!empty($params)) {
                    $url   =  $parse['path'] . '?' . http_build_query($params);
                } else {
                    $url   =  $parse['path'];
                }
            }
            $url = preg_replace('/[?|&]p=\d+/i', '', $url);
            $url  =  $url . (strpos($url,'?') ? '&p=' : '?p=');
            $str = '<span class="total">共 '.$this->totalRows.' 条，每页 '.$this->listRows.' 条</span> ';

            if($total == 1) return $str;

            if($now > 1){
                $str.= '<a class="prev fetch_page" data-page-num="'.($now-1).'" href="' . $url . ($now-1) . '">上一页</a>';
            }
            if($now!=1 && $now>4 && $total>6){
                $str .= ' ... ';
            }
            for($i=1;$i<=5;$i++){
                if($now <= 1){
                    $page = $i;
                }elseif($now > $total-1){
                    $page = $total-5+$i;
                }else{
                    $page = $now-3+$i;
                }
                if($page != $now  && $page>0){
                    if($page<=$total){
                        $str .= '<a class="fetch_page num" data-page-num="'.$page.'" href="' . $url . $page . '">'.$page.'</a>';
                    }else{
                        break;
                    }
                }else{
                    if($page == $now) $str .= '<a class="num active" data-page-num="'.$page.'" href="' . $url . $page . '">'.$page.'</a>';
                }
            }
            if ($now != $total){
                $str .= '<a class="fetch_page next" data-page-num="'.($now+1).'" href="' . $url . ($now+1) . '">下一页</a>';
            }
            // if($total != $now && $now<$total-5 && $total>10){
            // $str .= '<a class="fetch_page num" data-page-num="'.$total.'" href="javascript:void(0);">尾页&nbsp;&rsaquo;</a>';
            // }
            return $str;
        }
    }