<style>
	body, div, iframe, ul, ol, dl, dt, dd, h1, h2, h3, h4, h5, h6, p, pre, table, th, td, 
form, input, button, select, textarea {margin: 0;padding: 0;font-weight: normal;font-style: normal;font-size: 100%;font-family: inherit;}
ol, ul {list-style: none;}
img {border: 0;}
a:link,a:visited {color:#5A5A5A;text-decoration:none;}
a:hover {color:#c00;text-decoration:underline;}
body {font-size:12px;color:#5A5A5A;font-family:arial, sans-serif;background:#fff}
div,form,img,ul,ol,li,dl,dt,dd {margin: 0; padding: 0; border:0; }
h1,h2,h3,h4,h5,h6 {margin:0; padding:0; font-size:12px; font-weight:normal;}
table,td,tr,th{font-size:12px;}
li{list-style-type:none;}
img{vertical-align:top;}


.content {height:100%;overflow:hidden;padding:10px 0 30px 10px;}
.box {float:left;widtH:48%;margin:0px 0 2px 10px;_display:inline;padding-bottom:12px;height:380px;background:url(main/boxb.png) no-repeat center bottom;}
.box h3 {border:1px solid #DADADA;background:url(main/boxbg.png) repeat-x;height:33px;line-height:33px;color:#4D4D4D;font-weight:bold;padding:0 14px}
.box .con {padding:4px;height:336px;border:1px solid #DADADA;border-top:0;background:#F2F2F2;}
.box .dcon {padding:20px 20px 0;height:324px}

a.isub,a.isub:visited,a.isub:hover {background:url(isub.png) no-repeat;display:inline-block;color:#fff;heighT:32px;line-height:32px;text-align:center}
.update {margin-bottom:20px}
.update p {line-heighT:32px;}
.update a.isub,.update a.isub:visited {width:73px;}

/* 颜色 */
.red {color:#f00}
.blue,a.blue,a.blue:visited {color:#1CA1DA}
</style>
<include file="Public:header"/>
<div class="content">
<div class="box" style="width:95%">
	<div class="mainbox">
		<h3>
			<if condition="$needUpdate">有更新请备份好文件<else/>暂时没有更新</if>
		</h3>
	    <div class="con dcon">
	        <div class="update">
	            <if condition="$needUpdate">
	                <p style="color:red">注意了：在升级前请先备份好您的网站文件，不做备份直接升级可能造成网站不能访问，不做备份直接升级造成的网站问题概不负责</p>
	                <p style="color:red">另外：必须做好数据库备份</p>
	                <p style="color:red">备份就是把您的网站文件拷贝一份放到其他地方</p>
	                <p><a href="?c=System&a=sqlUpdate&upSqls=1"  class="blue">我已经备份好了，升级吧</a></p>
	            <else/>
	                暂时没有更新 <a href="?c=Index&a=main" class="blue">返回</a>
	            </if>
	        </div>
	    </div>
	</div>
</div>
</div>
<include file="Public:footer"/>