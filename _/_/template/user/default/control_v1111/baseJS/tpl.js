
            var xhr;
            function createXMLHttpRequest(){
                if(window.ActiveXObject){
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }else if(window.XMLHttpRequest){
                    xhr = new XMLHttpRequest();
                }
            }
            function UpladFile(){
                var fileObj = document.getElementById("upload_file").files[0];
                var FileController = ajax_uploadImg;
                var form = new FormData();
                form.append("myfile", fileObj);
                createXMLHttpRequest();
                xhr.onreadystatechange = handleStateChange;
                xhr.open("post", FileController, true);
                xhr.send(form);
            }
            function handleStateChange(){
                if(xhr.readyState == 4){
                    if (xhr.status == 200 || xhr.status == 0){
                        var result = xhr.responseText;
                        var json = eval("(" + result + ")");
                        if(json.code==200){
        //                                                            $("#pti_projectImg").attr("src",json.path);
                            $("#addImg").val(json.path);
                            document.getElementById("styleurl").style.backgroundImage="url("+json.path+")";
//                            alert(json.path);
                            $('#b_img').val(json.path);
//                            layer.msg("图片上传成功");
                            layer_tips(3,"图片上传成功");
                        }else{
                            layer.msg("图片上传失败");
                        }
                    }
                }
            }
            $(function(){
                $("#upload_file").change(function(){
                    UpladFile();
                })
            })
   
     
        var mouseX, mouseY; 
        var objX, objY; 
        var isDowm = false; //是否按下鼠标 
        function mouseDown(obj, e) { 
            obj.style.cursor = "move"; 
            objX = div1.style.left; 
            objY = div1.style.top; 
            mouseX = e.clientX; 
            mouseY = e.clientY; 
            isDowm = true; 
        } 
        function mouseMove(e) { 
            var div = document.getElementById("div1"); 
            var x = e.clientX; 
            var y = e.clientY; 
            if (isDowm) { 
                div.style.left = parseInt(objX) + parseInt(x) - parseInt(mouseX) + "px"; 
                div.style.top = parseInt(objY) + parseInt(y) - parseInt(mouseY) + "px"; 
            } 
        } 
        function mouseUp(e) { 
            if (isDowm) { 
                var x = e.clientX; 
                var y = e.clientY; 
                var div = document.getElementById("div1"); 
                div.style.left = (parseInt(x) - parseInt(mouseX) + parseInt(objX)) + "px"; 
                div.style.top = (parseInt(y) - parseInt(mouseY) + parseInt(objY)) + "px"; 
                mouseX = x; 
                rewmouseY = y; 
                div1.style.cursor = "default"; 
                isDowm = false; 
            } 
        } 

		
        function mouseDown2(obj, e) { 
            obj.style.cursor = "move"; 
            objX = div2.style.left; 
            objY = div2.style.top; 
            mouseX = e.clientX; 
            mouseY = e.clientY; 
            isDowm = true; 
        } 
        function mouseMove2(e) { 
            var div = document.getElementById("div2"); 
            var x = e.clientX; 
            var y = e.clientY; 
            if (isDowm) { 
                    div.style.left = parseInt(objX) + parseInt(x) - parseInt(mouseX) + "px"; 
                    div.style.top = parseInt(objY) + parseInt(y) - parseInt(mouseY) + "px"; 
            } 
        } 
        function mouseUp2(e) { 
            if (isDowm) { 
                    var x = e.clientX; 
                    var y = e.clientY; 
                    var div = document.getElementById("div2"); 
                    div.style.left = (parseInt(x) - parseInt(mouseX) + parseInt(objX)) + "px"; 
                    div.style.top = (parseInt(y) - parseInt(mouseY) + parseInt(objY)) + "px"; 
                    mouseX = x; 
                    rewmouseY = y; 
                    div2.style.cursor = "default"; 
                    isDowm = false; 
            } 
        } 
        
        function mouseDown3(obj, e) { 
            obj.style.cursor = "move"; 
            objX = div3.style.left; 
            objY = div3.style.top; 
            mouseX = e.clientX; 
            mouseY = e.clientY; 
            isDowm = true; 
        } 
        function mouseMove3(e) { 
            var div = document.getElementById("div3"); 
            var x = e.clientX; 
            var y = e.clientY; 
            
            if (isDowm) { 
                    div.style.left = parseInt(objX) + parseInt(x) - parseInt(mouseX) + "px"; 
                    div.style.top = parseInt(objY) + parseInt(y) - parseInt(mouseY) + "px"; 
            } 
        } 
        function mouseUp3(e) { 
            if (isDowm) { 
                    var x = e.clientX; 
                    var y = e.clientY; 
                    var div = document.getElementById("div3"); 
                    div.style.left = (parseInt(x) - parseInt(mouseX) + parseInt(objX)) + "px"; 
                    div.style.top = (parseInt(y) - parseInt(mouseY) + parseInt(objY)) + "px"; 
                    mouseX = x; 
                    rewmouseY = y; 
                    div3.style.cursor = "default"; 
                    isDowm = false; 
            } 
        } 
		
		
		
		
		
		$.post(degree_url, {}, function(data){
                        if(data == 1){

                        }else{
                            $('#degree').html(data);
                        }

                    })