<?php

class Helper_Curl {

    //public static  $user_agent = "Googlebot/1.0 (googlebot@googlebot.com http://googlebot.com/)";
    //public static  $user_agent = "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Maxthon; .NET CLR 1.1.4322)";
    public static $user_agent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.163 Safari/535.19";

    public function post($path, $params, $timeout=3, $format='json'){/*{{{*/
        $ch = curl_init();
        $url = $path;
		curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);// 设为TRUE把curl_exec()结果转化为字串，而不是直接输出
		curl_setopt($ch, CURLOPT_POST, 1);//启用POST提交
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params)); //设置POST提交的字符串
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 超时时间
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);//HTTP请求User-Agent:头
		curl_setopt($ch,CURLOPT_HTTPHEADER,array(
					//'Accept-Language: zh-cn',
					'Accept-Language: zh-CN,zh;q=0.8',
					'Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3',
					'Connection: Keep-Alive',
					'Cache-Control: no-cache'
					));//设置HTTP头信息
		$data     = curl_exec($ch); //执行预定义的CURL
		$info     = curl_getinfo($ch); //得到返回信息的特性
		$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$errorNo  = curl_errno($ch);
		curl_close($ch);
        return $data;
    }/*}}}*/

    public static function get($url, $params=array(), $timeout=10){/*{{{*/

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        //设置POST提交的字符串
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 超时时间
        curl_setopt($ch, CURLOPT_USERAGENT, self::$user_agent);//HTTP请求User-Agent:头
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Accept-Language: zh-cn',
            'Connection: Keep-Alive',
            'Cache-Control: no-cache'
        ));//设置HTTP头信息
        $data     = curl_exec($ch); //执行预定义的CURL
        $info     = curl_getinfo($ch); //得到返回信息的特性
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        $errorNo  = curl_errno($ch);
        curl_close($ch);
        //echo $data;
        if(empty($data))
            echo "Response is empty, url $url \n";
        if($httpCode != 200)
            echo "HttpCode Error: $httpCode \n";
        return $data;
    }/*}}}*/

}
