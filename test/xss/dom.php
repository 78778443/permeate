<?php
error_reporting(0);
$name = htmlspecialchars($_GET['name']);

//http://localhost/test/xss/dom.php?name=%3Cimg%20src=1%20onerror=alert(1)%20/%3E

?>
<input id="username" type="text" value="<?php echo $name; ?>"/>
<div id="content"></div>

<script type="text/javascript">
    //获取输入的名称,并且输出在content内，导致dom-xss。
    var username = document.getElementById("username");
    var content = document.getElementById("content");
    content.innerHTML = username.value;

</script>