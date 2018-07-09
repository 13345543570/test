<?php 
	// //链接数据库
	// function con($dataname){
 //        $con=mysqli_connect('localhost','root','123456',$dataname);
 //        if (!$con){ 
 //            apiReturn('0',"连接错误: " . mysqli_connect_error()); 
 //        }
 //        mysqli_set_charset($con,'utf8');
 //        return $con;
 //    }
 //    $con = con('baiyi');
 //    $tablename = 'baiyi_'.date("Ym");//创建每个月份的数据表（为每个大数据量的表且读写频繁的每个月创建一个新表，查询旧表时根据查询条件的去区分哪个表）

	// $sql = 'CREATE TABLE IF NOT EXISTS '.$tablename.'(
	// 		id int primary key auto_increment
	// 		)';
	// $res = mysqli_query($con,$sql);//这个sql语句是表不存在时创建 表存在时不创建
	// echo $res;exit;
	
	// aaa();
	// function aaa(){
	// 	global $_SERVER;
	// 	var_dump($_SERVER);
	// }

	//获取浏览器
function getbrowser()
    {
        global $_SERVER;
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browser_ver = '';
        if (preg_match('/OmniWeb\\/(v*)([^\\s|;]+)/i', $agent, $regs)) {
            $browser = 'OmniWeb';
            $browser_ver = $regs[2];
        }
        if (preg_match('/Netscape([\\d]*)\\/([^\\s]+)/i', $agent, $regs)) {
            $browser = 'Netscape';
            $browser_ver = $regs[2];
        }
        if (preg_match('/safari\\/([^\\s]+)/i', $agent, $regs)) {
            $browser = 'Safari';
            $browser_ver = $regs[1];
        }
        if (preg_match('/MSIE\\s([^\\s|;]+)/i', $agent, $regs)) {
            $browser = 'Internet Explorer';
            $browser_ver = $regs[1];
        }
        if (preg_match('/Opera[\\s|\\/]([^\\s]+)/i', $agent, $regs)) {
            $browser = 'Opera';
            $browser_ver = $regs[1];
        }
        if (preg_match('/NetCaptor\\s([^\\s|;]+)/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') NetCaptor';
            $browser_ver = $regs[1];
        }
        if (preg_match('/Maxthon/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') Maxthon';
            $browser_ver = '';
        }
        if (preg_match('/360SE/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') 360SE';
            $browser_ver = '';
        }
        if (preg_match('/SE 2.x/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') 搜狗';
            $browser_ver = '';
        }
        if (preg_match('/FireFox\\/([^\\s]+)/i', $agent, $regs)) {
            $browser = 'FireFox';
            $browser_ver = $regs[1];
        }
        if (preg_match('/Lynx\\/([^\\s]+)/i', $agent, $regs)) {
            $browser = 'Lynx';
            $browser_ver = $regs[1];
        }
        if ($browser != '') {
            return $browser . ' ' . $browser_ver;
        } else {
            return 'Unknow browser';
        }
}
//获取ip
function getIP()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
                $ip = getenv('REMOTE_ADDR');
            } else {
                if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = 'unknown';
                }
            }
        }
        if($ip=='117.71.59.101'){
            $ip = '****';
        }
        return $ip;
    }
//获取用户系统
function getplat()
    {
        if (isMobile()) {
            return 'Mobile';
        }
        global $_SERVER;
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $os = false;
        if (preg_match('/win/', $agent)) {
            if (preg_match('/4.9/', $agent)) {
                $os = 'Windows ME';
            }
            if (preg_match('/nt 5.0/', $agent)) {
                $os = 'Windows 2000';
            }
            if (preg_match('/nt 5.1/', $agent)) {
                $os = 'Windows XP';
            }
            if (preg_match('/nt 5.2/', $agent)) {
                $os = 'Windows Server 2003';
            }
            if (preg_match('/nt 6.0/', $agent)) {
                $os = 'Windows Vista/Server 2008';
            }
            if (preg_match('/nt 6.1/', $agent)) {
                $os = 'Windows 7/Server 2008 R2/Thin PC';
            }
            if (preg_match('/nt 6.2/', $agent)) {
                $os = 'Windows 8/Server 2012';
            }
            if (preg_match('/nt 6.3/', $agent)) {
                $os = 'Windows 8.1/Server 2012 R2';
            }
            if ($os == '') {
                $os = 'Windows';
            }
            if (preg_match('/wow64/', $agent)) {
                $os .= ' (64位系统)';
            }
        } else {
            if (preg_match('/linux/', $agent)) {
                $os = 'Linux';
            } else {
                if (preg_match('/unix/', $agent)) {
                    $os = 'Unix';
                } else {
                    if (preg_match('/sun/', $agent) && preg_match('/os/', $agent)) {
                        $os = 'SunOS';
                    } else {
                        if (preg_match('/ibm/', $agent) && preg_match('/os/', $agent)) {
                            $os = 'IBM OS/2';
                        } else {
                            if (preg_match('/mac/', $agent) && preg_match('/pc/', $agent)) {
                                $os = 'Macintosh';
                            } else {
                                if (preg_match('/powerpc/', $agent)) {
                                    $os = 'PowerPC';
                                } else {
                                    if (preg_match('/aix/', $agent)) {
                                        $os = 'AIX';
                                    } else {
                                        if (preg_match('/hpux/', $agent)) {
                                            $os = 'HPUX';
                                        } else {
                                            if (preg_match('/netbsd/', $agent)) {
                                                $os = 'NetBSD';
                                            } else {
                                                if (preg_match('/bsd/', $agent)) {
                                                    $os = 'BSD';
                                                } else {
                                                    if (preg_match('/osf1/', $agent)) {
                                                        $os = 'OSF1';
                                                    } else {
                                                        if (preg_match('/irix/', $agent)) {
                                                            $os = 'IRIX';
                                                        } else {
                                                            if (preg_match('/freebsd/', $agent)) {
                                                                $os = 'FreeBSD';
                                                            } else {
                                                                if (preg_match('/teleport/', $agent)) {
                                                                    $os = 'teleport';
                                                                } else {
                                                                    if (preg_match('/flashget/', $agent)) {
                                                                        $os = 'flashget';
                                                                    } else {
                                                                        if (preg_match('/webzip/', $agent)) {
                                                                            $os = 'webzip';
                                                                        } else {
                                                                            if (preg_match('/offline/', $agent)) {
                                                                                $os = 'offline';
                                                                            } else {
                                                                                $os = $agent;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $os;
    }
//是否是移动端
function isMobile()
    {
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
        }
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
            if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))) {
                return true;
            }
        }
        return false;
    }
echo getbrowser()."<br/>";
echo getIP()."<br/>";
echo getplat()."<br/>";
var_dump(isMobile());

 ?>