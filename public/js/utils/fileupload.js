$.fn.upload = function(remote, data, successFn, progressFn) {
    if (typeof(data) != 'object') {
        progressFn = successFn;
        successFn = data;
    }

    return this.each(function() {
        if (!$(this)[0].files[0]) return;

        var formData = new FormData();
        formData.append($(this).attr("name"), $(this)[0].files[0]);

        if(typeof data == 'object') {
            for (var i in data) {
                formData.append(i, data[i]);
            }
        }

        $.ajax({
            url:remote,
            type:'POST',
            xhr:function() {
                var myXHR = $.ajaxSettings.xhr();

                if(myXHR.upload && progressFn) {
                    myXHR.upload.addEventListener('progress', function(prog){
                        var value = ~~((prog.loaded / prog.total) * 100);

                        if (progressFn && typeof progressFn == 'function') {
                            progressFn(prog, value);
                        } else if (progressFn) {
                            $(progressFn).val(value);
                        }
                    }, false)  ;
                }

                return myXHR;
            },
            data:formData,
            cache: false,
            contentType:false,
            processData:false,
            complete: function(res) {
                if(successFn) successFn(res.responseText);
            }, error:function(e) {
                alert("服务器出现错误");
                //debugger;
            }
        });
    });
}