(function worker() 
{
  $.ajax(
  {
    type: 'GET',
    url: 'https://94e3a03e.ngrok.io/api/index.php?a=ad&b=get',
    responseType:'application/json',
    contentType: 'application/json',
    success:function(response)
    {
        //var returnedData = JSON.parse(response);
        //console.log(response);
        console.log(response.data.pic_path);
        var url = response.data.ad_url;
        var height = "100px";
        var style  = "background: #64787f;left: 30%;width:36%;position:fixed;top:0px;height:100px";
        var img    = "<a target='_blank' href='"+url+"'><img src='" + response.data.pic_path + "' style='" + style + "'/></a>";
        $('html').append(img);
        $('body').css({
            '-webkit-transform': 'translateY(' + height + ')'
        });

    },
    error:function() 
    {
        //$('#notification-bar').text('An error occurred');
    },
    complete:function() 
    {
      // Schedule the next request when the current one's complete
      //setTimeout(worker, 5000);
    }
  });
})();

