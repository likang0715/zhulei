/**
 * Created by win7 on 2016/3/11.
 */
var now_page = 1;
var is_ajax = false;
var max_page;

$(function(){
    FastClick.attach(document.body);
    $(window).scroll(function(){
        if(now_page > 1 && $(window).scrollTop() / ($('body').height() - $(window).height()) >= 0.95){
            if(is_ajax == true){
                if(typeof(max_page) != 'undefined'){
                    if(now_page <= max_page) {
                        if($('.wx_loading2').is(":hidden")) {
                            getProduct();
                        }
                    }
                }
            }
        }
    });

    getProduct();

    function getProduct(){
        $('.wx_loading2').show();
        $.ajax({
            type:"POST",
            url: page_url,
            data:'page='+now_page,
            dataType:'json',
            success:function(result){
                if(Object.prototype.toString.apply(result.err_msg.list).slice(8, -1) === 'Object'){
                   var javascript_arr = Object.keys(result.err_msg.list);
                }else{
                   var javascript_arr = result.err_msg.list;
                }
                console.log(javascript_arr);
                var data = '';
                if(result.err_code){
                    motify.log(result.err_msg);
                }else{
                    if(javascript_arr.length > 0) {
                        for(var i=0;i<javascript_arr.length;i++){
                            data += '<a href="/wap/drp_product_detail.php?product_id='+javascript_arr[i]['product_id']+'">';
                            data +='<div class="disItem">';
                            data +='<div class="itemSin">';
                            data +=    '<h2 class="itemImg">';
                            data +=        '<i><img src="' + javascript_arr[i]['image'] + '"/></i>' + javascript_arr[i]['name'];
                            data +=    '</h2>';
                            data +=    '<h2 class="itemImg" style="color:#43b8ec;margin-left: 2.2rem;margin-top: -0.7rem;">￥' + javascript_arr[i]['price'] + '   <small class="levelNow">'+ javascript_arr[i]['unified_profit']+'</small></h2>';
                            data += '</div>';
                            data += '</div>';
                            data += '<div class="row">';
                            data += '<ul>';
                            data +=    '<li>';
                            data +=    '<h4>直销利润</h4>';
                            data +=    '<p>￥' + javascript_arr[i]['reward_1'] + '</p>';
                            data +=    '</li>';
                            data += '<li>';
                            data +=    '<h4>二级分销分润</h4>';
                            data +=   '<p>￥' + javascript_arr[i]['reward_2'] + '</p>';
                            data +=    '</li>';
                            data +=    '<li>';
                            data +=    '<h4>三级分销分润</h4>';
                            data +=   '<p>￥' + javascript_arr[i]['reward_3'] + '</p>';
                            data +=  '</li>';
                            data += '               <li class="itemArrow">';
                            data += '                             <img width=8px" height="14px"; style=" vertical-align: bottom;" src="/template/wap/default/ucenter/images/ic_chevron_dark.png"/>';
                            data += '                         </li>';
                            data +=  '</ul>';
                            data += '         </a>';
                            data +=  '</div>';
                        }

                        $(".disLevelDetail").append(data);

                        if(typeof(result.err_msg.noNextPage) == 'undefined'){
                            is_ajax = false;
                        }else if(result.err_msg.noNextPage) {
                            is_ajax = true;
                        }
                        max_page = result.err_msg.max_page;
                    }else{
                        $('.empty-list').show();
                    }
                    now_page ++;
                }

                $('.wx_loading2').hide();
            },
            error:function(){
                $('.wx_loading2').hide();
                motify.log(label + 'dd' + '商品读取失败，<br/>请刷新页面重试',0);
            }
        });
    }
});