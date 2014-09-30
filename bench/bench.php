#!/usr/bin/php

<?php

/**
 * @useage
 * cd /home/www/yeap/bench
 * /usr/local/php/bin/php ./bench.php -c 2000 -t 30 (clients:2000, time:30sec)
 */

if (!function_exists("xhprof_enable"))
    die("php5-xhprof not found\n");
//if (!function_exists("apc_add"))
    //die("php5-apc not found\n");
if (!function_exists("curl_close"))
    die("php5-curl not found\n");
if (!function_exists("imagecopy"))
    die("php5-gd not found\n");
if (!class_exists("Locale"))
    die("php5-intl not found\n");

$opt = getopt("c:t:");
$gc = isset($opt['c']) ? $opt['c'] : 200;
//$gn = isset($opt['n']) ? $opt['n'] : 30000;
$gt = isset($opt['t']) ? $opt['t'] : 30;

$al = array(
    'mirco' => 'http://micromvc4.pfb.example.com/',
    'aceexample' => 'http://admin.aceexample.dev/test/',
    'yeap' => 'http://www.yeap.dev/demo',
    'ci' => 'http://ci.pfb.example.com/',
    'adk' => 'http://api.ta.amgbs.dev/test',
    'laravel' => 'http://laravel.pfb.example.com/',
);
$result_folder = "./result/".date("Ymd")."/";

//
$rs = array();
$output = '';
$count = 1;
for ($i = 0; $i < $count; $i++) {

    foreach ($al as $k => $url) {

		$result_dir = "{$result_folder}{$k}/";

        shell_exec("/usr/local/php/sbin/php-fpm restart");
        do {
            $loadavg = strstr(shell_exec('cat /proc/loadavg'), ' ', true);
			echo $loadavg."\n";
            sleep(30);
        } while ($loadavg > 0.5); // 0.05

        echo "Testing {$k}\n";
        /** Memuse/Time/fun-calls/fun-map **/
        $memuse = 0;
        $time   = 0;
        $funcal = 0;
        $files  = 0;
		//Page rendered in 8.37 ms, taking 1119.56 KB, include files: 28, xhprof url
		//Page rendered in 27.78 ms, taking 238.1 KB, include files: 12, xhprof url
        $o = shell_exec("curl -X GET \"{$url}?debug=1\""); usleep(300);// Caching 300000
        $o = shell_exec("curl -X GET --ignore-content-length \"{$url}?debug=1\"");
        if (preg_match("/in \<b\>(.*?) ms(.*?)\<b\>(.*?) KB(.*?)files: (.*?),(.*?)href=\"(.*?)\"/",
            $o, $mat)) {
            $memuse = $mat[3];
            $time   = $mat[1];
            $files  = $mat[5];
            $o = shell_exec("curl -X GET \"".urldecode($mat[7])."\"");
            if (preg_match("/Number of Function Calls(.*?)\<td\>(.*?)\<\/td/", $o, $mat2)
                && preg_match("/href=\"(.*?)\"\>\[View Full Callgraph/", $o, $mat3) )
            {
                $funcal = str_replace(array(",", " "), array("", ""), $mat2[2]);
                shell_exec("mkdir -p {$result_dir}/");
                copy("http://xhprof.yeap.dev/".str_replace('/xhprof_html', '', $mat3[1]), "{$result_dir}/funmap{$i}.png");
            }
        }

        /** QPS **/
        $o = shell_exec("webbench -c $gc -t $gt -r \"{$url}\"");
        if (preg_match("/Requests\:\s([0-9]+)\ssusceed/", $o, $mat)) {
            $loadavg = strstr(shell_exec('cat /proc/loadavg'), ' ', true);
            $rs[$k][] = array($mat[1], $loadavg, $memuse, $time, $funcal, $files);
        }
    }
}

$output .= sprintf("%12s QPS, LOAD, MEM(KB), TIME(ms); functions, include files\n", 'framework');
$rsm = array();
foreach ($rs as $k => $v) {
    $output .= sprintf("%12s ", $k);
    $rqsvg = 0;
    $loadavg = 0;
    $memuse = 0;
    $time   = 0;
    $funcal = 0;
    $files  = 0;
    foreach ($v as $v2) {
        $rqsvg += $v2[0];
        $loadavg += $v2[1];
        $memuse += $v2[2];
        $time += $v2[3];
        $funcal = $v2[4];
        $files  = $v2[5];
        $output .= sprintf("%8d,%5.2f,%7.2f,%6.2f;", $v2[0], $v2[1], $v2[2], $v2[3]);
    }
    $output .= sprintf("%8d,%5.2f,%7.2f,%6.2f;  %5d,%5d\n",
        $rqsvg/$count, $loadavg/$count, $memuse/$count, $time/$count, $funcal, $files);
    $rsm['qps'][$k] = intval($rqsvg/$count);
    $rsm['load'][$k] = round($loadavg/$count, 2);
    $rsm['memuse'][$k] = round($memuse/$count, 2);
    $rsm['time'][$k] = round($time/$count, 2);
    $rsm['funcal'][$k] = $funcal;
    $rsm['files'][$k] = $files;
}

file_put_contents("{$result_folder}webbench-c{$gc}-t{$gt}.txt", $output);
echo $output;

include('./phpgraphlib.php');

foreach ($rsm as $k => $v) {
    switch ($k) {
    case 'qps':
        $graph = new PHPGraphLib(800, 450, "{$result_folder}webbench-c{$gc}-t{$gt}.png");
        $graph->addData($rsm['qps']);
        $graph->setTitle("NginxBench (webbench -c {$gc} -t {$gt})");
        break;
    case 'load':
        $graph = new PHPGraphLib(800,450, "{$result_folder}loadavg.png");
        $graph->addData($rsm['load']);
        $graph->setTitle("System LoadAvg in 1 Minute (webbench -c {$gc} -t {$gt})");
        break;
    case 'memuse':
        $graph = new PHPGraphLib(800,450, "{$result_folder}memory-usage.png");
        $graph->addData($rsm['memuse']);
        $graph->setTitle("Memory Usage (KB)");
        break;
    case 'files':
        $graph = new PHPGraphLib(800,450, "{$result_folder}number-of-files.png");
        $graph->addData($rsm['files']);
        $graph->setTitle("Number of files been included or required");
        break;
    case 'funcal':
        $graph = new PHPGraphLib(800,450, "{$result_folder}number-of-function-calls.png");
        $graph->addData($rsm['funcal']);
        $graph->setTitle("Number fo function calls");
        break;
    case 'time':
        $graph = new PHPGraphLib(800,450, "{$result_folder}response-time.png");
        $graph->addData($rsm['time']);
        $graph->setTitle("Response Time (Millisecond)");
        break;
    default:
        continue;
    }

    $graph->setTitleLocation('left');
    $graph->setBarColor('255,102,51');
    $graph->setDataValues(true);
    $graph->setXValuesHorizontal(true);
    $graph->setupXAxis(20, '');
    $graph->createGraph();
}


