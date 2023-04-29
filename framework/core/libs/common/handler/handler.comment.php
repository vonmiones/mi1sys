<?php 
// declare(strict_types=1);
// namespace framework\core\libs\common\handler;

class Comment
{
    public function getFileComments()
    {
        $result = [];
        $docs = array();
        foreach (get_declared_classes()  as $kClass => $vClass) {
            if (preg_match('/^mi1_apps\s*/', $vClass ) > 0) {
                $doc = (new ReflectionClass($vClass))->getdoccomment();
                $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
                preg_match_all($pattern, $doc, $matches, PREG_PATTERN_ORDER);
                array_push($docs,$matches[0]);
            }        
        }
        // $pattern = '/@\w+ : |\r|\n|\t/i';
        $pattern = '/@/i';

        $keys = array("Name","Author","Website","Email","Number","DateCreated","Method");
        $replacement = '';
        foreach ($docs as $k1 => $v1) {
            $result[] = preg_replace($pattern,$replacement,$v1);
        }
        return $result;
    }
}