/**
 * Created by Administrator on 2015/12/3.
 */

$(function(){

    //编辑
    $('.talk-info').on('click','.js-weixin-share',function(){
        var html = "<div class='controls'><textarea class='text_class' rows='5' cols='35'></textarea> <button class='btn btn-primary js-modal-save-btn'>确定</button> <button class='btn btn-default js-modal-close-btn'>取消</button></div>";
        var sec = $(".text_class").val();
        $(".talk").after(html);
        $('.js-weixin-share').hide();
    });

    //确定
    $('.talk-info').on('click', '.js-modal-save-btn',function(){
        var sec = $(".text_class").val();
        if(sec.length <= 0)
        {
            $('.explain-text > .text').text('分享内容不能为空！');
            $(".js-dialog-img").Dialog();
            return false;
        }
        var html2 = "<p class='msg'><span class='sec_msg'>"+ sec +"</span><span class='js-weixin-share'>&nbsp;&nbsp编辑</span></p>";
        $(".popover").html(html2);
        $(".controls").remove();
    });

    //取消
    $('.talk-info').on('click','.js-modal-close-btn',function(){
        $(".controls").remove();
        $('.js-weixin-share').show();
    });

});
