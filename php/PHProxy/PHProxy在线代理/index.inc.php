<HTML>
<HEAD>
<TITLE>PHProxy - PHP在线代理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<style>
body, input{font-family: "Bitstream Vera Sans", Arial, Helvetica, sans-serif;color: #44352C;}
a{color: #9B9C83;text-decoration:none;border-bottom: 1px orange dashed;}
a:hover 
{color: #0080FF;}
#container{border: 1px #9B9C83 solid;-moz-border-radius: 8px;margin: auto;padding: 5px;width: 700px;}
ul#navigation, ul#form{list-style-type: none;padding: 0;margin: 0;}
ul#navigation{float: right;}
ul#form{clear: both;}
ul#navigation li{float: left;margin: 0;padding: 5px 0;border-top: 2px #BFAA9B solid;}
ul#navigation li a{font-weight: bold;color: #ffffff;background-color: #AA8E79;padding: 5px 15px;margin-left: 1px;text-decoration: none;border-bottom: 0 #ffffff solid;}
ul#navigation li  a:hover{color: #44352C;}
ul#form li{width: 700px;}
#address_bar{border-top: 2px #BFAA9B solid;border-bottom: 3px #44352C solid;background-color: #AA8E79;text-align: center;padding: 5px 0;color: #ffffff;}
#go{background-color: #ffffff;font-weight: bold;color: #AA8E79;border: 0 #ffffff solid;padding: 2px 5px;}
#address_box{width: 500px;}
.option{padding: 2px 0;background-color: #EEEBEA;}
.option label{border-bottom: 2px #ffffff solid;}
form{margin: 0;}
#error, #auth{background-color: #BF6464;border-top: 1px solid #44352C;border-bottom: 1px solid #44352C;width: 700px;clear: both;}
#auth{background-color: #94C261;}
#error p, #auth p, #auth form{margin: 5px;}
</style>
</HEAD>
<BODY onkeydown="if(event.keyCode==27) return false;">
<CENTER>
<DIV class=maintable><BR>
<h1>在线代理</h1><BR>
<DIV class=simpletable style="WIDTH: 98%; TEXT-ALIGN: left">
<DIV class="altbg2 smalltxt" align=center>
<div id="container">
<?php
switch ($data['category'])
{
    case 'auth':
?>
  <div id="auth"><p>
  <b>请输入用户名及密码 "<?php echo htmlspecialchars($data['realm']) ?>" on <?php echo $GLOBALS['_url_parts']['host'] ?></b>
  <form method="post" action="">
    <input type="hidden" name="<?php echo $GLOBALS['_config']['basic_auth_var_name'] ?>" value="<?php echo base64_encode($data['realm']) ?>" />
    <label>用户名 <input type="text" name="username" value="" /></label> <label>密码 <input type="password" name="password" value="" /></label> <input type="submit" value="Login" class="button"/>
  </form></p></div>
<?php
        break;
    case 'error':
        echo '<div id="error"><p>';
        
        switch ($data['group'])
        {
            case 'url':
                echo '<b>网址错误(' . $data['error'] . ')</b>: ';
                switch ($data['type'])
                {
                    case 'internal':
                        $message = '连接指定主机失败. '
                                 . '可能由于服务器不存在，连接超时，或者服务器拒绝访问。'
                                 . '请重新连接，同时检查该网址是否正确。';
                        break;
                    case 'external':
                        switch ($data['error'])
                        {
                            case 1:
                                $message = '您要访问的网址被服务器列入了黑名单，请选择其他网址。';
                                break;
                            case 2:
                                $message = '您输入的URL不正确。';
                                break;
                        }
                        break;
                }
                break;
            case 'resource':
                echo '<b>资源错误:</b> ';
                switch ($data['type'])
                {
                    case 'file_size':
                        $message = '您要下载的文件太大。<br />'
                                 . '本系统只允许大小为<b>' . number_format($GLOBALS['_config']['max_file_size']/1048576, 2) . ' MB</b>以下的文件下载。<br />'
                                 . '您当期要下载的文件大小为： <b>' . number_format($GLOBALS['_content_length']/1048576, 2) . ' MB</b>';
                        break;
                    case 'hotlinking':
                        $message = '您通过异地网站使用本代理程序访问资源。It appears that you are trying to access a resource through this proxy from a remote Website.<br />'
                                 . '出于安全原因，请使下边的表单来访问站点.';
                        break;
                }
                break;
        }
        
        echo '本代理系统访问站点出现错误。 <br />' . $message . '</p></div>';
        break;
}
?>
 <div style="text-align: center">
<div style="width: 50%; text-align: left">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<ul style="margin: 2px auto;">
<label class="f12">网址:<input id="address_box" size="60" type="text" name="<?php echo $GLOBALS['_config']['url_var_name'] ?>" value="<?php echo isset($GLOBALS['_url']) ? htmlspecialchars($GLOBALS['_url']) : '' ?>" onfocus="this.select()" /></label><input id="go" class="button" type="submit" value=" 访问" />
      <?php
      
      foreach ($GLOBALS['_flags'] as $flag_name => $flag_value)
      {
          if (!$GLOBALS['_frozen_flags'][$flag_name])
          {
              echo '<li class="optionclass"><label><input type="checkbox" name="' . $GLOBALS['_config']['flags_var_name'] . '[' . $flag_name . ']"' . ($flag_value ? ' checked="checked"' : '') . ' /> ' . $GLOBALS['_labels'][$flag_name][1] . '</label></li>' . "\n";
          }
      }
      ?>
</ul></form>
</div>
</div>
</div>
</DIV></DIV>
</DIV></CENTER>
</BODY></HTML>