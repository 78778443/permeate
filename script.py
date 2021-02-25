#引入需要的模块
import os
import time
import sys
import codecs
sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

# 更新代码
os.system("php /root/start.php")

#定义grep关键词,和需要执行的命令
keyList = {
#     'rad.php':'cd /root/qingscan/edge  &&  php rad.php  >> ./tmp/edge_rad.txt & ',
#     'xray.php':'cd /root/qingscan/edge  &&  php xray.php  >> ./tmp/edge_xray.txt & ',
#    'rad getResult':'cd /root/qingscan  &&  php index.php rad getResult  >> ./tmp/rad_getResult.txt & ',
#    'xray getResult':'cd /root/qingscan  &&  php index.php xray getResult  >> ./tmp/xray_getResult.txt & ',
#    'php -S':'cd /root/qingscan  &&  php -S 0.0.0.0:80  >> ./tmp/php_service.txt & ',
}

#死循环不断监听任务是不是挂了
timeSleep = 5
i=True
while i:
    #遍历需要监控的关键词和对应的脚本
    for key,value in keyList.items():
        #执行命令查看任务是否已经执行
        cmd = "ps -ef | grep '%s' | grep -v 'grep'"%key
        result = os.popen(cmd).readlines()
        #如果返回值长度是0说明任务没有执行
        if len(result) == 0 :
            #执行命令
            os.system(value)
            print('我要执行脚本了')
    #每次循环完毕将休眠2个小时
    time.sleep(timeSleep)