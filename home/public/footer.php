
<div class="clear"></div>
<!--页脚start-->
<div class="footer">
  <div class="link">
    <div class="title_link">友情链接</div>
    <ul class="ul_link">
      <?php
			$sql ="select * from bbs_fri";
			$row = mysql_func($sql);
			foreach($row as $fri){
		?>
      <li> <a href="<?php echo $fri['url']  ?>" class="link_img"><img src="<?php echo strstr($fri['pic'],'../r')  ?>" title="<?php echo $fri['title']  ?>" alt="<?php echo $fri['desc1']  ?>" /></a>
        <div class="link_1"><a href=""><?php echo $fri['title'] ?></a></div>
        <div class="link_2"><a href=""><?php echo $fri['desc1'] ?></a></div>
      </li>
      <?php
				}
			?>
    </ul>
  </div>
  <div class="clear"></div>
  <div class="footer_1">
    <div class="foot_left">
      <p>Powered by <span>轻松参透测试系统</span>!V1.0</p>
      <p><em>&copy;</em><span class="copy">2001-2002 Comenz Inc.</span></p>
    </div>
    <div class="foot_right">
      <p><a href="">Archiver</a><span>|</span><a href="">手机版</a><span>|</span><strong>轻松参透测试系统</strong>（京ICP证110024号|京网文[2011]0019-007号|北京公安备案:1101082242）</p>
      <p>GMT+8,2012-11-13 20:33,Processed in 0.030692 second(s),2 queries,Gzip On,MemcachedOn</p>
    </div>
  </div>
</div>
<!--页脚end-->
</body></html>