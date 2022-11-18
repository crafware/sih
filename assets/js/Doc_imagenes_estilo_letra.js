setTimeout(function() {
        img = document.getElementsByTagName("img");
        imgN = document.getElementsByTagName("img").length;
        for (var i = 0; i < img.length; i++) {
            img[i].id = i;
        }
    }, 1)
    function deleteTypeLetter(id) {
        t = document.getElementById(id);
        textarea1 = t.getElementsByTagName("textarea")[0];
        code = t.getElementsByClassName("jodit_wysiwyg")[0];
        span = code.getElementsByTagName("span");
        for (var i = 0; i < span.length; i++) {
            span[i].setAttribute('style', 'font-family: Arial, Helvetica, sans-serif;');
        }
        /*Combierte PNG a JPEJ */
        img = code.getElementsByTagName("img");
        for (var i = 0; i < img.length; i++) {
            if (img[i].id == "") {
                var canvas  = document.createElement('canvas');
                var width   = img[i].width;
                var height  = img[i].height;
                var res     = 300
                if(width > res){
                    height  = (res/width)*height;
                    width   = res;
                }
                if(height > res){
                    width   = (res/height)*width;
                    height  = res;
                }
                canvas.width    = width;
                canvas.height   = height;
                canvas1         = canvas.getContext('2d');
                canvas1.drawImage(img[i], 0, 0, width, height);

                var dataURL = canvas.toDataURL('image/jpeg', 5.0);
                img[i].src = dataURL;
                img[i].id = imgN;
                imgN += 1;
            }
        }
    }
