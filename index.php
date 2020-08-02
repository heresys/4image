<?php 

require('simplehtmldom/simple_html_dom.php');

function searchImages($url) {
    $context = stream_context_create(array(
        'http' => array(
            'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
        ),
    ));
    
    # create directory to download images
    $urlTreated = preg_replace('/[^\d-]/i', '', $url);
    mkdir("t" . $urlTreated, 0777, true);
    chdir("t" . $urlTreated);

    # get html of url and download images
    $html = file_get_html($url, false, $context);
    foreach($html->find('img') as $element) {
        $elementPure = $element->src;
        $elementTreated = substr($elementPure, 2);
        $elementTreated = str_replace("s.", ".", $elementTreated);
        exec("wget $elementTreated");
    }
}


echo "===================================\n";
echo "     DOWNLOAD IMAGES with PHP7\n               4CHAN\n";
echo "===================================\n";

$url = readline("[-] Thread link: ");
searchImages($url);
