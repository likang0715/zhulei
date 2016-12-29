<?php
class store_nav_model extends base_model{
	public function getStoreNav($store_id){
		$nav = $this->db->where(array('store_id' => $store_id))->find();
		return $nav;
	}

	public function add($data){
		return $this->db->data($data)->add();
	}

	public function edit($where, $data){
		return $this->db->where($where)->data($data)->save();
	}
	public function getParseNav($store_id, $seller_id = 0, $drp_diy_store = 1){
		$nav = $this->getStoreNav($store_id);
		if(empty($nav)) return '';
		$navData = unserialize($nav['data']);
		if(empty($navData)) return '';
		$storeNav = '<script src="' . STATIC_URL . 'js/layer_mobile/layer.m.js"></script><script type="text/javascript">function deny_drp(obj) {layer.open({title:["分销提示：","background-color:#FF6600;color:#fff;"],content: "抱歉，申请失败！<br/><span style=\"color:gray\">您访问的店铺不允许注册分销商。</span>"});return false;}</script>';
		$domain = option('config.wap_site_url');
		switch($nav['style']){
			case '1':
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-1 has-menu-'.count($navData).'">';
                if (empty($drp_diy_store)) {
                    $storeNav .= '<div class="nav-special-item nav-item"><a href="'. $domain . '/home.php?id=' . $seller_id . '" class="home">主页</a></div>';
                } else {
                    $storeNav .= '<div class="nav-special-item nav-item"><a href="' . $domain . '/home.php?id=' . $store_id . '" class="home">主页</a></div>';
                }

                foreach($navData as $value){
                    $style = '';
					switch($value['url']){
						case 'ucenter':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/ucenter.php?id='.$seller_id;
                            } else {
                                $value['url'] = $domain . '/ucenter.php?id='.$store_id;
                            }
							break;
                        case 'drp':
                            import('source.class.Drp');
                            Drp::init();
                            $visitor = Drp::checkID($seller_id, $_SESSION['wap_user']['uid']);

                            if (!empty($visitor['data']['drp_supplier_id']) && !empty($visitor['data']['allow_drp_manage'])) { //访问用户已经是分销商
                                $value['name'] = '分销管理';
                                $value['url'] = $domain . '/drp_register.php?id=' . $visitor['data']['store_id'];
                            } else if (empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_register'])) {
                                $value['url'] = $domain . '/drp_register.php?id=' . $store_id;
                            } else if (!empty($visitor['data']['store_id'])) {
                                if ($visitor['data']['status'] != 1 || $visitor['data']['drp_approve'] != 1) {
                                    if (!empty($visitor['data']['drp_supplier_id'])) {
                                        $value['name'] = '分销管理';
                                    }
                                    $value['url'] = 'javascript:void(0);';
                                    $style = 'style="color:lightgray;cursor:no-drop;"';
                                }
                            } else {
                                $value['url'] = 'javascript:deny_drp(this);';
                            }
                            break;
                        case 'home':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/home.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/home.php?id=' . $store_id;
                            }
                            break;
						case 'subject_type':
 							if (empty($drp_diy_store)) {
								$value['url'] = $domain . '/store_subject_type.php?id='. $seller_id;
							} else {
								$value['url'] = $domain . '/store_subject_type.php?id=' . $store_id;
							}
							break;
                        case 'cart':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/cart.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/cart.php?id=' . $store_id;
                            }
                            break;
                        default:
                            if (empty($drp_diy_store) && !empty($value['url']) && stripos($value['url'], option('config.site_url')) !== false) {
                                if (stripos($value['url'], 'home.php?id=') !== false) {
                                    $value['url'] = preg_replace('/home.php\?id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                                    $value['url'] = preg_replace('/home.php\?store_id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                                } else if (stripos($value['url'], 'drp_store_qrcode.php?store_id=') !== false) {
                                    $value['url'] = preg_replace('/drp_store_qrcode.php\?store_id=(\d)/i', 'drp_store_qrcode.php?store_id=' . $seller_id, $value['url']);
                                } else {
                                    $value['url'] .= '&store_id=' . $seller_id;
                                }
                            }
                            break;
					}
					$storeNav.= '<div class="nav-item">';
					$storeNav.= '<a class="mainmenu js-mainmenu" href="'.(!empty($value['url']) ? $value['url'] : 'javascript:void(0);').'">'.(!empty($value['submenu']) ? '<i class="arrow-weixin"></i>' : '').'<span class="mainmenu-txt" ' . $style . '>'.$value['name'].'</span></a>';
					if(!empty($value['submenu'])){
						$storeNav.= '<div class="submenu js-submenu"><span class="arrow before-arrow"></span><span class="arrow after-arrow"></span><ul>';
                        foreach($value['submenu'] as $k=>$v){
                            if (strtolower($v['url']) == 'drp') {
                                import('source.class.Drp');
                                Drp::init();
                                $visitor = Drp::checkID($seller_id, $_SESSION['wap_user']['uid']);
                                if (empty($visitor)) {
                                    continue 2;
                                }
                                if (!empty($visitor['data']['drp_supplier_id']) && !empty($visitor['data']['allow_drp_manage'])) { //访问用户已经是分销商
                                    $v['name'] = '分销管理';
                                    $v['url'] = $domain . '/drp_register.php?id=' . $visitor['data']['store_id'];
                                } else if (empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_register'])) {
                                    $v['url'] = $domain . '/drp_register.php?id=' . $store_id;
                                } else if (!empty($visitor['data']['store_id'])) {
                                    if ($visitor['data']['status'] != 1 || $visitor['data']['drp_approve'] != 1) {
                                        if (!empty($visitor['data']['drp_supplier_id'])) {
                                            $v['name'] = '分销管理';
                                        }
                                        $v['url'] = 'javascript:void(0);';
                                        $style = 'style="color:lightgray;cursor:no-drop;"';
                                    }
                                } else {
                                    $v['url'] = 'javascript:deny_drp(this);';
                                }
                            } else if (strtolower($v['url']) == 'ucenter') {
                                if (empty($drp_diy_store)) {
                                    $v['url'] = $domain . '/ucenter.php?id=' . $seller_id;
                                } else {
                                    $v['url'] = $domain . '/ucenter.php?id=' . $store_id;
                                }
                            } else if (strtolower($v['url']) == 'home') {
                                if (empty($drp_diy_store)) {
                                    $v['url'] = $domain . '/home.php?id=' . $seller_id;
                                } else {
                                    $v['url'] = $domain . '/home.php?id=' . $store_id;
                                }
                            } else {
                                if (empty($drp_diy_store) && !empty($v['url']) && stripos($v['url'], option('config.site_url')) !== false) {
                                    if (stripos($v['url'], 'home.php?id=') !== false) {
                                        $v['url'] = preg_replace('/home.php\?id=(\d)/i', 'home.php?id=' . $seller_id, $v['url']);
                                        $v['url'] = preg_replace('/home.php\?store_id=(\d)/i', 'home.php?id=' . $seller_id, $v['url']);
                                    } else {
                                        $v['url'] .= '&store_id=' . $seller_id;
                                    }
                                }
                            }
                            $storeNav.= ' <li><a href="'.(!empty($v['url']) ? $v['url'] : 'javascript:void(0);').'" ' . $style . '>'.$v['name'].'</a></li>';
							if($k != count($value['submenu'])-1){
								$storeNav.= '<li class="line-divide"></li>';
							}
						}
						$storeNav.= '</ul></div>';
					}
					$storeNav.= '</div>';
				}

				$storeNav .= '</div>';
				break;
			case '2':
                foreach($navData as $value){
					switch($value['url']){
						case 'ucenter':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/ucenter.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/ucenter.php?id=' . $store_id;
                            }
							break;
                        case 'drp':
                            import('source.class.Drp');
                            Drp::init();
                            $visitor = Drp::checkID($seller_id, $_SESSION['wap_user']['uid']);

                            if (!empty($visitor['data']['drp_supplier_id']) && !empty($visitor['data']['allow_drp_manage'])) { //访问用户已经是分销商
                                $value['name'] = '分销管理';
                                $value['url'] = $domain . '/drp_register.php?id=' . $visitor['data']['store_id'];
                            } else if (empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_register'])) {
                                $value['url'] = $domain . '/drp_register.php?id=' . $store_id;
                            } else if (!empty($visitor['data']['store_id'])) {
                                if ($visitor['data']['status'] != 1 || $visitor['data']['drp_approve'] != 1) {
                                    if (!empty($visitor['data']['drp_supplier_id'])) {
                                        $value['name'] = '分销管理';
                                    }
                                    $value['url'] = 'javascript:void(0);';
                                }
                            } else {
                                $value['url'] = 'javascript:deny_drp(this);';
                            }
                            break;
                        case 'home':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/home.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/home.php?id=' . $store_id;
                            }
                            break;
						case 'subject_type':
 							if (empty($drp_diy_store)) {
								$value['url'] = $domain . '/store_subject_type.php?id='. $seller_id;
							} else {
								$value['url'] = $domain . '/store_subject_type.php?id=' . $store_id;
							}
							break;
                        case 'cart':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/cart.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/home.php?id=' . $store_id;
                            }
                            break;
                        default:
                         if (empty($drp_diy_store) && !empty($value['url']) && stripos($value['url'], option('config.site_url')) !== false) {
                            if (stripos($value['url'], 'home.php?id=') !== false) {
                            	$value['url'] = preg_replace('/home.php\?id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                            	$value['url'] = preg_replace('/home.php\?store_id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                            } else {
                            	$value['url'] .= '&store_id=' . $seller_id;
                            }
                         }
                           break;
					}
					if(!empty($value['image1']) && (substr($value['image1'],0,9) == './upload/' || substr($value['image1'],0,11) == './template/')){
						$value['image1'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image1']);
						$value['image1'] = str_replace('./template/',option('config.site_url').'/template/',$value['image1']);
					}
					if(!empty($value['image2']) && (substr($value['image2'],0,9) == './upload/' || substr($value['image2'],0,11) == './template/')){
						$value['image2'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image2']);
						$value['image2'] = str_replace('./template/',option('config.site_url').'/template/',$value['image2']);
					}
					$newNavData[] = $value;
				}
                if (!empty($nav['bgcolor'])) {
                    $background_color = $nav['bgcolor'];
                } else {
                    $background_color = '#2B2D30';
                }
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-2 has-menu-'.(count($newNavData)).'" style="background-color:' . $background_color . ';">';
				$storeNav.= '<ul class="clearfix">';
				foreach($newNavData as $key=>$value){
					$storeNav.= '<li><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'"></a></li>';
				}
				$storeNav .= '</ul>';
				$storeNav .= '</div>';
				break;
			case '3':
                foreach($navData as $value){
					switch($value['url']){
						case 'ucenter':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/ucenter.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/ucenter.php?id=' . $store_id;
                            }
							break;
                        case 'drp':
                            import('source.class.Drp');
                            Drp::init();
                            $visitor = Drp::checkID($seller_id, $_SESSION['wap_user']['uid']);

                            if (!empty($visitor['data']['drp_supplier_id']) && !empty($visitor['data']['allow_drp_manage'])) { //访问用户已经是分销商
                                $value['name'] = '分销管理';
                                $value['url'] = $domain . '/drp_register.php?id=' . $visitor['data']['store_id'];
                            } else if (empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_register'])) {
                                $value['url'] = $domain . '/drp_register.php?id=' . $store_id;
                            } else if (!empty($visitor['data']['store_id'])) {
                                if ($visitor['data']['status'] != 1 || $visitor['data']['drp_approve'] != 1) {
                                    if (!empty($visitor['data']['drp_supplier_id'])) {
                                        $value['name'] = '分销管理';
                                    }
                                    $value['url'] = 'javascript:void(0);';
                                }
                            } else {
                                $value['url'] = 'javascript:deny_drp(this);';
                            }
                            break;
                        case 'home':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/home.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/home.php?id=' . $store_id;
                            }
                            break;
						case 'subject_type':
 							if (empty($drp_diy_store)) {
								$value['url'] = $domain . '/store_subject_type.php?id='. $seller_id;
							} else {
								$value['url'] = $domain . '/store_subject_type.php?id=' . $store_id;
							}
							break;
                        case 'cart':
                            if (empty($drp_diy_store)) {
                                $value['url'] = $domain . '/cart.php?id=' . $seller_id;
                            } else {
                                $value['url'] = $domain . '/cart.php?id=' . $store_id;
                            }
                            break;
                        default:
                            if (empty($drp_diy_store) && !empty($value['url']) && stripos($value['url'], option('config.site_url')) !== false) {
                            	if (stripos($value['url'], 'home.php?id=') !== false) {
                            		$value['url'] = preg_replace('/home.php\?id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                            		$value['url'] = preg_replace('/home.php\?store_id=(\d)/i', 'home.php?id=' . $seller_id, $value['url']);
                            	} else {
                            		$value['url'] .= '&store_id=' . $seller_id;
                            	}
                            }
                            break;
					}
					if(!empty($value['image1']) && (substr($value['image1'],0,9) == './upload/' || substr($value['image1'],0,11) == './template/')){
						$value['image1'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image1']);
						$value['image1'] = str_replace('./template/',option('config.site_url').'/template/',$value['image1']);
					}
					if(!empty($value['image2']) && (substr($value['image2'],0,9) == './upload/' || substr($value['image2'],0,11) == './template/')){
						$value['image2'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image2']);
						$value['image2'] = str_replace('./template/',option('config.site_url').'/template/',$value['image2']);
					}
					$newNavData[] = $value;
				}
                if (!empty($nav['bgcolor'])) {
                    $background_color = $nav['bgcolor'];
                } else {
                    $background_color = '#2B2D30';
                }
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-3 has-menu-'.(count($newNavData)-1).'" style="background-color:' . $background_color . ';">';
				foreach($newNavData as $key=>$value){
                    if($key > 0) {
                        $storeNav.= '<div class="nav-item"><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'" data-mouseover="' . $value['image2'] . '" data-mouseout="' . $value['image1'] . '"></a></div>';
                    }
                    if (count($newNavData) == 1) {
                        $storeNav.= '<div class="nav-item"><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'" data-mouseover="' . $value['image2'] . '" data-mouseout="' . $value['image1'] . '"></a></div>';
                    }
                    if(($key == 0 && count($newNavData) == 1) || ($key == 2 && count($newNavData) > 3) || ($key == 1 && count($newNavData) == 2) || ($key == 1 && count($newNavData) == 3)){
                        $storeNav.= '<div class="nav-special-item nav-item"><a href="'.($newNavData[0]['url'] ? $newNavData[0]['url'] : 'javascript:;').'" style="background-image:url('.$newNavData[0]['image1'].');border-color:' . $background_color . ';" title="'.$newNavData[0]['text'].'" data-mouseover="' . $newNavData[0]['image2'] . '" data-mouseout="' . $newNavData[0]['image1'] . '"></a></div>';
					}
				}
				$storeNav .= '</div>';
				break;
		}
		return $storeNav;
	}
}