<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/12/21
 * Time: 11:13
 */
class CommonDataModel extends Model
{
    public function getData($where)
    {
        $data = $this->field('value')->where($where)->find();
        return !empty($data['value']) ? $data['value'] : 0;
    }

    public function setData($where, $value)
    {
        $value += $this->getData($where);
        $value = number_format($value, 2, '.', '');
        if ($value > 0) {
            $this->where($where)->save(array('value' => $value));
        }
        return $value;
    }
}