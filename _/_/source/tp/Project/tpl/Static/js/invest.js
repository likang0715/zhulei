function investLook(id){
  var url='?c=Invest&a=investLook&uid='+id;
        layer.open({
            type: 2,
            //skin: 'layui-layer-lan',
            title: '投资人审核',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['80%', '70%'],
            content: url,
        });
}