namespace helpers;
class Log
{
    public $log_path = './log/';

    public function __construct($log_path = './log/')
    {
        $this->log_path = $log_path;
    }

    public function write($file_name, $msg, $dir = 'api')
    {
        $file_name = strtolower($file_name);
        if (!preg_match('/^[a-z0-9_]+$/', $file_name) || !preg_match('/^[a-z0-9_]+$/', $dir)) {
            return FALSE;
        }
        $this->log_path = $this->log_path . $dir . '/';
        file_exists($this->log_path) || mkdir($this->log_path, 0755, true);
        if (!is_dir($this->log_path)) {
            return FALSE;
        }
        $filepath = $this->log_path . $file_name . '_' . date('Y_m') . '.log';
        $message = date('Y-m-d H:i:s') . ':  ';
        $message .= $msg . "\n";
        $result = error_log($message, 3, $filepath);
        return $result;
    }


    function read($month = '', $filename = 'order_syn', $dir = 'api')
    {
        $month = (!empty($month) && preg_match('/^[\d]{4}\_[\d]{1,2}$/', $month)) ? $month : date('Y_m');
        $filename = strtolower($filename);
        if (!preg_match('/^[a-z0-9_]+$/', $filename)) {
            $filename = 'order_syn';
        }
        if (!preg_match('/^[a-z0-9_]+$/', $dir)) {
            $dir = 'api';
        }

        $filepath = $this->log_path . '/' . $filename . '_' . $month . '.log';
        $str = $filepath;
        if (!file_exists($filepath)) {
            $str .= '<hr>not exists;';
        } else {
            $size = round(filesize($filepath) / 1024, 2) . 'KB';
            $line_count = count(file($filepath));
            $str .= " (FileSize: <b>$size</b> LineCount: <b>{$line_count}</b>)<hr>";
            $str .= nl2br(file_get_contents($filepath));
        }

        return $str;
    }
}
